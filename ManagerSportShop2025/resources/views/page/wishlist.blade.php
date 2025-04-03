@extends('master')

@section('content')
    <div class="container my-5">
        <br><br>
        <h2 class="text-center mb-4 text-primary fw-bold">Sản phẩm yêu thích</h2>
        
        @if($wishlistItems->isEmpty())
            <p class="text-center">Chưa có sản phẩm nào trong danh sách yêu thích.</p>
        @else
        <br><br>
            <div class="row">
                @foreach($wishlistItems as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm border-light rounded">
                            <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>
                                <br>
                                <a class="beta-btn primary" href="{{ route('chi-tiet-san-pham', $product->id) }}">Chi tiết sản phẩm <i class="fa fa-chevron-right"></i></a>
                                <form action="{{ route('wishlist.remove', $product->id) }}" method="POST">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-danger">🗑 Xóa</button>
                                </form> 
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <br><br>
@endsection
