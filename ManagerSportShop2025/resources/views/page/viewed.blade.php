@extends('master')

@section('content')
    <div class="container my-5">
        <Br></Br>
        <h2 class="text-center mb-4 text-primary fw-bold">Sản phẩm đã xem gần đây</h2>
        <Br></Br>

        @if($viewedProducts->isEmpty())
            <p class="text-center text-muted fs-5">Bạn chưa xem sản phẩm nào.</p>
        @else
            <div class="row g-4">
                @foreach($viewedProducts as $viewedProduct)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0 rounded-3">
                            <div class="position-relative">
                                <img src="{{ $viewedProduct->product->image ?? asset('default-image.jpg') }}" 
                                     class="card-img-top img-fluid rounded-top" 
                                     alt="{{ $viewedProduct->product->name }}" 
                                     style="height: 220px; object-fit: cover;">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-dark fw-bold">{{ $viewedProduct->product->name }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($viewedProduct->product->description, 80) }}</p>
                                <a href="{{ route('chi-tiet-san-pham', $viewedProduct->product->id) }}" 
                                   class="btn btn-outline-primary mt-auto w-100">
                                   Xem chi tiết <i class="fa fa-chevron-right"></i>
                                </a>
                                <!-- Nút xóa sản phẩm khỏi lịch sử -->
                                <form action="{{ route('products.viewed.destroy', $viewedProduct->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100">Xóa khỏi lịch sử</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <br>
            <!-- Nút xóa toàn bộ lịch sử -->
            <div class="text-center mt-4">
                <form action="{{ route('products.viewed.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa toàn bộ lịch sử sản phẩm</button>
                </form>
            </div>
        @endif
    </div>
    <Br></Br>
@endsection
