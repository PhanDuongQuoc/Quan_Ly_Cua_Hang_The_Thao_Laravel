<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductRecommendationController extends Controller
{
    public function showRecommendations()
    {
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
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
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

        return view('page.trangchu', compact('recommendedProducts'));
    }
}
