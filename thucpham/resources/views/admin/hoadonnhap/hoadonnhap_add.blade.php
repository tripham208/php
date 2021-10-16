@extends('admin.main')
@section('content')
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-12    col-lg-12 col-md-12">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="h4 text-gray-900 mb-4">Nhập hàng</h4>
                                    </div>
                                    @include('alert')
                                    <form class="user" action="" method="post">

                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <label for="exampleInputEmail"> Tên nhà cung cấp</label>
                                                <select class="form-control" name="ncc">
                                                    @foreach($ncc as $item)
                                                        <option value="{{$item->id}}">{{$item->ten}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="exampleInputEmail"> Tên nhân viên</label>
                                                <select class="form-control" name="nv">
                                                    @foreach($nhanvien as $item)
                                                        <option value="{{$item->id}}">{{$item->ten}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group" style="margin-bottom: 100px">
                                            <a style="float: left" href="/admin/hanghoa/loaisp"
                                               class="btn btn-primary btn-user btn-block col-lg-3">Trở về</a>
                                            <button type="submit" style="float: right;margin-top: 10px" class="btn btn-primary btn-user btn-block col-lg-3">
                                                Tiếp
                                            </button>

                                        </div>
                                        @csrf
                                    </form>
                                    <!-- Button trigger modal -->

                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
