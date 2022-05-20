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
                <h3 class="h3 mb-2 text-gray-800">Chi tiết hóa đơn {{$hoadon->id}}</h3>
            </div>
            <div class="card-body">
                <h4>Nhân viên: {{\App\Http\Controllers\Admin\ImportProductController::name($hoadon->idEmployee)}}</h4>
                <h4>Nhà cung
                    cấp: {{\App\Http\Controllers\Admin\ImportProductController::name($hoadon->idSupplier)}}</h4>
                <h4>Thời gian: {{$hoadon->time}}</h4>
                <h4>Tổng tiền: {{$hoadon->total}}</h4>
            </div>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary" style="float: left">Danh sách chi tiết hóa đơn </h6>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                        style="float: right">
                    Thêm
                </button>

                <!-- Modal -->
                <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Thêm chi tiết</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @include('alert')
                                <form class="user" id="form" action="" method="post">
                                    <div class="form-group">
                                        <label for="exampleInputEmail"> Tên sản phẩm</label>
                                        <select class="form-control" name="sp">
                                            @foreach($product as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 ">
                                            <label for="exampleInputEmail"> Số lượng</label>
                                            <input type="number" min="0" name="sl"
                                                   class="form-control form-control-user"
                                                   id="exampleInputPassword">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="exampleInputEmail"> Đơn giá</label>
                                            <input type="number" min="0" name="dg"
                                                   class="form-control form-control-user"
                                                   id="exampleInputPassword">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 ">
                                            <label for="exampleInputEmail"> Giam giá</label>
                                            <input type="number" min="0" name="gg"
                                                   class="form-control form-control-user"
                                                   id="exampleInputPassword">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="exampleInputEmail"> Hạn sử dụng</label>
                                            <input type="date" min="0" name="hsd"
                                                   class="form-control form-control-user"
                                                   id="exampleInputPassword">
                                        </div>
                                    </div>

                                    <label for="exampleInputEmail"> Serial</label>
                                    <input type="text" min="0" name="sr"
                                           class="form-control form-control-user"
                                           id="exampleInputPassword">
                                    @csrf

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" form="form" class="btn btn-primary">Thêm</button>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <th style="width: 20%">Hạn sử dụng</th>
                            <th style="width: 10%">Serial</th>
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
                                <th>{{$item->expiry}}</th>
                                <th>{{$item->serial}}</th>
                            </tr>

                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a style="float: left" href="/admin/hoadon/nhap/delete/{{$hoadon->id}}"
                   class="btn btn-primary btn-user btn-block col-lg-3">Trở về</a>
                <a style="float: right" href="/admin/hoadon/nhap/save/{{$hoadon->id}}"
                   class="btn btn-primary btn-user btn-block col-lg-3">Lưu</a>
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
