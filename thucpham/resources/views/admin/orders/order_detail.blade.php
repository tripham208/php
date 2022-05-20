@extends('admin.main')
@section('header')
    <!-- Custom styles for this page -->
    <link href="/template/admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h3 class="h3 mb-2 text-gray-800">Chi tiết {{$loaidon}} {{$hoadon->id}}</h3>
            </div>
            <div class="card-body">
                <h4>Nhân viên: {{\App\Models\User::getName($hoadon->idEmployee)}}</h4>
                <h4>Khách hàng: {{\App\Models\User::getName($hoadon->idCustomer)}}</h4>
                <h4>Thời gian: {{$hoadon->time}}</h4>
                <h4>Tổng tiền: {{$hoadon->total}}</h4>
            </div>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary" style="float: left">Danh sách chi tiết {{$loaidon}} </h6>
                 @if($hoadon->typeOrder==3)
                <a class="btn btn-primary" href="duyet/{{$hoadon->id}}"
                        style="float: right">
                    Duyệt đơn
                </a>
                @elseif($hoadon->typeOrder==4)
                        <a class="btn btn-primary" href="giao/{{$hoadon->id}}"
                           style="float: right">
                            Giao thành công
                        </a>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th style="width: 5%">STT</th>
                            <th style="">Sản phẩm</th>
                            <th style="width: 15%">Số lượng</th>
                            <th style="width: 10%">Đơn giá</th>
                            <th style="width: 10%">Giảm giá</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $x=0
                        @endphp
                        @foreach($data as $item)
                            @php
                                $x+=1
                            @endphp
                            <tr>
                                <th>{{$x}}</th>
                                <th>{{\App\Models\Product::where('id', $item->idProduct)->first()->name}}</th>
                                <th> {{$item->quantity}}</th>
                                <th>{{$item->unitPrice}}</th>
                                <th>{{$item->discount}}</th>
                            </tr>

                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

@endsection
@section('footer')
    <!-- Page level plugins -->
    <script src="/template/admin/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/template/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/template/admin/js/demo/datatables-demo.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function removeRow(id, url) {
            if (confirm('Xóa mà không thể khôi phục. Bạn có chắc ?')) {
                $.ajax({
                    type: 'DELETE',
                    datatype: 'JSON',
                    data: {id},
                    url: url,
                    success: function (result) {
                        if (result.error === false) {
                            alert(result.message);
                            location.reload();
                        } else {
                            alert('Xóa lỗi vui lòng thử lại');
                        }
                    }
                })
            }
        }
    </script>
@endsection
