@extends('admin.main')
@section('header')
    <!-- Custom styles for this page -->
    <link href="/template/admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="/template/admin/css/styles.css" rel="stylesheet" />
@endsection
@section('content')

    <!-- Product section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" height="400px" width="400px" src="{{$sanpham->anh}}" alt="..." /></div>
                <div class="col-md-6">
                    <h1 class="display-5 fw-bolder">{{$sanpham->ten}}</h1>
                    <div class="fs-5 mb-5">
                        <span>Đơn giá: {{$sanpham->dongia}}</span>
                        <span>Số lượng: {{$sanpham->soluong}}</span>
                    </div>
                    <p class="lead"> {!!$sanpham->mota!!}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Related items section-->

@endsection
@section('footer')
    <!-- Page level plugins -->
    <script src="/template/admin/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/template/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/template/admin/js/demo/datatables-demo.js"></script>

@endsection
