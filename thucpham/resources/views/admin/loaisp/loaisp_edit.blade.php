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
                                        <h4 class="h4 text-gray-900 mb-4">Chỉnh sửa loại sản phẩm</h4>
                                    </div>
                                    @include('alert')
                                    <form class="user" action="" method="post">

                                        <div class="form-group">
                                            <label for="exampleInputEmail"> Tên loại</label>
                                            <input type="" name="name" class="form-control form-control-user"
                                                   id="exampleInputPassword" placeholder="Nhập tên loại"
                                                   value="{{$loaisp->ten}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail"> Tên loại cha</label>
                                            <select class="form-control" name="parent">
                                                <option value="null" >Không</option>
                                                @foreach($loaisps as $item)
                                                    @if($item->id==$loaisp->id)
                                                    @elseif($item->id==$loaisp->cha)
                                                        <option value="{{$item->id}}" selected >{{\App\Http\Controllers\Admin\loaispController::name($loaisp->cha)}}</option>
                                                    @else
                                                        <option value="{{$item->id}}" >{{$item->ten}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group" style="margin-bottom: 100px">
                                            <a style="float: left" href="/admin/hanghoa/loaisp"
                                               class="btn btn-primary btn-user btn-block col-lg-3">Trở về</a>
                                            <button type="submit" style="float: right;margin-top: 10px" class="btn btn-primary btn-user btn-block col-lg-3">
                                                Lưu
                                            </button>

                                        </div>
                                        @csrf
                                    </form>
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
