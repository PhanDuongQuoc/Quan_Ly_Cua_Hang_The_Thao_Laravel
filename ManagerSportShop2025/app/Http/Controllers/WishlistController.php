<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\wishlists;
use App\Models\product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller {

    public function showWishlist() {
        $userId = Auth::id();
        
        $wishlistItems = wishlists::where('user_id', $userId)
            ->join('products', 'wishlists.product_id', '=', 'products.id')
            ->select('products.*')
            ->get();
        
        return view('page.wishlist', compact('wishlistItems'));
    }
    public function addToWishlist($productId) {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để sử dụng chức năng này.');
        }
    
        $userId = Auth::id();
    
        if (wishlists::where('user_id', $userId)->where('product_id', $productId)->exists()) {
            return redirect()->back()->with('message', 'Sản phẩm đã có trong danh sách yêu thích.');
        }
    
        wishlists::create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);
    
        return redirect()->back()->with('message', 'Đã thêm vào danh sách yêu thích!');
    }


    public function removeFromWishlist($productId) {
        $userId = Auth::id();
        
        $wishlistItem = wishlists::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
    
        if ($wishlistItem) {
            $wishlistItem->delete();
            return redirect()->back()->with('message', 'Đã xóa khỏi danh sách yêu thích.');
        }
    
        return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong danh sách yêu thích.');
    }
    
}
