<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DashBoard - Cửa hàng chuyên cung cấp đồ thể thao Future CEO Sport</title>
    <base href="{{asset('')}}">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="source_admin/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="source_admin/assets/css/style.css" rel="stylesheet">
</head>

<body>
<div class="container-xxl position-relative bg-white d-flex p-0">
        @include('sidebar')


        <!-- Content Start -->
        <div class="content">
        @include('navbar')
        @yield('content')
        @include('footer_admin')
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="source_admin/assets/lib/chart/chart.min.js"></script>
    <script src="source_admin/assets/lib/easing/easing.min.js"></script>
    <script src="source_admin/assets/lib/waypoints/waypoints.min.js"></script>
    <script src="source_admin/assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="source_admin/assets/lib/tempusdominus/js/moment.min.js"></script>
    <script src="source_admin/assets/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="source_admin/assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="source_admin/assets/js/main.js"></script>
</body>

</html>