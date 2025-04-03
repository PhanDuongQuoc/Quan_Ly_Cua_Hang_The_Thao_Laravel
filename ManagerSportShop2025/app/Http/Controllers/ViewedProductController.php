<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\viewedproduct;
use App\Models\product;
use Illuminate\Support\Facades\Auth;

class ViewedProductController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem lịch sử sản phẩm.');
        }

        $viewedProducts = viewedproduct::where('user_id', Auth::id())
                                       ->with('product')
                                       ->latest()
                                       ->take(10)
                                       ->get();

        return view('page.viewed', compact('viewedProducts'));
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xóa sản phẩm.');
        }

        $viewedProduct = viewedproduct::where('id', $id)
                                      ->where('user_id', Auth::id())
                                      ->first();

        if ($viewedProduct) {
            $viewedProduct->delete();
            return redirect()->route('products.viewed')->with('success', 'Đã xóa sản phẩm khỏi lịch sử.');
        }

        return redirect()->route('products.viewed')->with('error', 'Không tìm thấy sản phẩm để xóa.');
    }

    public function clearHistory()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xóa lịch sử.');
        }

        viewedproduct::where('user_id', Auth::id())->delete();

        return redirect()->route('products.viewed')->with('success', 'Đã xóa toàn bộ lịch sử sản phẩm.');
    }
}
