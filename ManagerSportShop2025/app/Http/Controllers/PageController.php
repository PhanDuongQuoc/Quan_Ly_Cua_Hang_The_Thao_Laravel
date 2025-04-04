<?php

namespace App\Http\Controllers;

use App\Models\billdetail;
use App\Models\bills;
use App\Models\product;
use App\Models\slide;
use App\Models\typeproduct;
use App\Models\video;
use App\Models\customer;
use App\Models\news;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\cart;
use Illuminate\Support\Facades\Auth;
use App\Models\viewedproduct;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function getIndex(){
        $slide = slide::all();
        $product = product::paginate(8);
        $new_product = product::where('new','new')->get();


         // 1. Lấy danh sách sản phẩm được yêu thích nhiều nhất
         $wishlistProducts = DB::table('wishlists')
         ->select('product_id', DB::raw('COUNT(*) as count'))
         ->groupBy('product_id')
         ->orderByDesc('count')
         ->limit(5)
         ->get();

        // 2. Lấy danh sách sản phẩm được xem nhiều nhất
        $viewedProducts = DB::table('viewed_products')
            ->select('product_id', DB::raw('COUNT(*) as count'))
            ->groupBy('product_id')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // 3. Lấy danh sách sản phẩm bán chạy nhất
        $bestsellerProducts = DB::table('bill_detail')
        ->select('id_product as product_id', DB::raw('SUM(quantity) as total_sold')) // Đổi id_product thành product_id
        ->groupBy('id_product')
        ->orderByDesc('total_sold')
        ->limit(5)
        ->get();

        // Hợp nhất kết quả, loại bỏ trùng lặp
        $recommendedProductIds = collect($wishlistProducts)
            ->merge($viewedProducts)
            ->merge($bestsellerProducts)
            ->unique('product_id')
            ->pluck('product_id');

        // Truy vấn thông tin chi tiết sản phẩm từ bảng `products`
        $recommendedProducts = DB::table('products')
            ->whereIn('id', $recommendedProductIds)
            ->get();
        return view('page.trangchu',compact('slide','new_product','product','recommendedProducts'));
    }

    public function getSanPham(){
        $list_product = product::paginate(10);
        return view('page.sanpham',compact('list_product'));
    }

    public function getSanphamTheoLoai($type){ 
        $list_product = product::where('id_type',$type)->get();
        $list_category = typeproduct::all();
        $list_video = video::paginate(3,['*'],'another_product');
        $another_product = product::where('id_type','<>',$type) ->paginate(3,['*'],'list_video');
        return view('page.loaisanpham',compact('list_product','list_category','another_product','list_video'));
    }


    public function getChiTietSanpham(Request $req)
    {
        $product = Product::where('id', $req->id)->first();
    
        if (!$product) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
        }
    
        if (Auth::check()) {
            $userId = Auth::id();
            $exists = viewedproduct::where('user_id', $userId)
                                   ->where('product_id', $product->id)
                                   ->exists();
    
            if (!$exists) {
                viewedproduct::create([
                    'user_id' => $userId,
                    'product_id' => $product->id,
                ]);
            }
        }
    
        $product_relate = Product::where('id_type', $product->id_type)
                                 ->where('id', '<>', $product->id)
                                 ->paginate(3, ['*'], 'product_new');
        $product_best = Product::take(4)->get();
        $product_new = Product::where('new', 'new')->paginate(4, ['*'], 'product_relate');
    
        return view('page.chitietsanpham', compact('product', 'product_relate', 'product_best', 'product_new'));
    }

    public function  getLienHe(){
        return view('page.lienhe');
    }

    public function  getGioiThieu(){
        return view('page.gioithieu');
    }

    public function getVideo(Request $request){
        $list_video = video::paginate(6, ['*'], 'list_new');
        $list_new = news::paginate(2,['*'],'list_video');
        return view('page.video',compact('list_video','list_new'));
    }

    public function getAddCart(Request $req,$id){
        $product = product::find($id);
        $oldCart = Session('cart')? Session::get('cart'):null;
        $cart = new cart($oldCart);
        $cart->add($product,$id);
        $req ->session()->put('cart',$cart);
        if(count($cart->items)>0){
            Session::put('cart',$cart);
        }else{
            Session::put('cart',new cart(null));
        }
        return redirect()->back();

    }


    public function getDeleteItemCart($id){
        $oldCart = Session::has('cart')?Session::get('cart'):null;
        $cart = new cart($oldCart);
        $cart->removeItem($id);
        if(count($cart->items)>0){
            Session::put('cart',$cart);
        }
        else{
            Session::put('cart',new cart(null));
        }
        return redirect()->back();
    }


    public function getCheckout() {
        if (Session::has('cart')) {
            $cart = Session::get('cart')?Session::get('cart'):null;
            $product_cart = $cart->items; 
        } else {
            $product_cart = []; 
        }
    
        return view('page.dat_hang', compact('product_cart'));
    }
    
    

    public function postCheckout(Request $req) {
        $cart = Session::get('cart');
        if (!$cart || empty($cart->items)) {
            return redirect()->back()->with('error', 'Giỏ hàng trống, không thể đặt hàng!');
        }
    
        $customer = Customer::where('email', $req->email)->first();
        if (!$customer) {
            $customer = new Customer();
            $customer->name  = $req->name;
            $customer->gender = $req->gender;
            $customer->email = $req->email;
            $customer->address = $req->address;
            $customer->phone_number = $req->phone;
            $customer->note = $req->notes;
            $customer->save();
        }
    
     
        $bill = new Bills();
        $bill->id_customer = $customer->id;
        $bill->date_order = now(); 
        $bill->total = $cart->totalPrice; 
        $bill->payment = $req->payment_method;
        $bill->note = $req->note;
        $bill->save();
    
        foreach ($cart->items as $key => $value) {
            $bill_detail = new BillDetail();
            $bill_detail->id_bill = $bill->id;
            $bill_detail->id_product = $key;
            $bill_detail->quantity = $value['qty'];
            $bill_detail->unit_price = $value['price'] / $value['qty'];
            $bill_detail->save();
        }
    
        Session::forget('cart');
    
        return redirect()->back()->with('thongbao', 'Đặt hàng thành công!');
    }



    public function getSearch(Request $req){
        $product = product::where('name', 'LIKE', '%'.$req->key.'%')
                ->orWhere('unit_price', 'LIKE', '%'.$req->key.'%')
                ->orWhere('description', 'LIKE', '%'.$req->key.'%')
                ->paginate(6); 


       
        return view('page.search', compact('product'));
    }



    

    
    
}
