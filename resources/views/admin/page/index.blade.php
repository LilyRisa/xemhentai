@extends('admin.layout')
@section('content')
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="card">
                    <div class="card-header">
                        Danh sách page tĩnh
                        <div class="card-header-actions pr-1">
                            <a href="/admin/page/update"><button class="btn btn-block btn-primary btn-sm mr-3" type="button">Thêm mới</button></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="get" action="">
                            <div class="form-group row">
                                <div class="col-4">
                                    <input type="text" name="keyword" class="form-control" placeholder="Từ khóa">
                                </div>
                                <div class="col-4">
                                    <input type="text" name="time_range" class="form-control datetimes" data-date="{{isset($_GET['time_range'])? $_GET['time_range'] : ''}}" value="{{isset($_GET['time_range'])? $_GET['time_range'] : ''}}" placeholder="Khoảng thời gian">
                                </div>
                                <input type="hidden" name="status" value="{{$_GET['status']}}">
                                
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <input type="text" name="title" class="form-control" value="{{isset($_GET['title'])? $_GET['title'] : ''}}" placeholder="Tiêu đề">
                                </div>
                                <div class="col-4">
                                    <input type="text" name="slug" class="form-control" value="{{isset($_GET['slug'])? $_GET['slug'] : ''}}" placeholder="Url bài viết">
                                </div>
                                <div class="col-2">
                                    <input type="submit" class="btn btn-success" value="Tìm kiếm">
                                </div>
                            </div>
                        </form>
                        <table class="table table-striped table-bordered datatable">
                            <thead>
                            <tr>
                                <th class="text-center w-5">ID</th>
                                <th>Tiêu đề</th>
                                <th class="text-center w-15">Ngày đăng bài</th>
                                <th class="text-center w-15">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($listItem)) @foreach($listItem as $item)
                            <tr>
                                <td class="text-center">{{$item->id}}</td>
                                <td><a target="_blank" rel="nofollow" href="{{getUrlStaticPage($item)}}">{{$item->title}}</a></td>
                                <td class="text-center">{{date('d-m-Y H:i', strtotime($item->displayed_time))}}</td>
                                <td class="text-center">
                                    <a class="btn btn-info" href="/admin/page/update/{{$item->id}}">
                                        <svg class="c-icon">
                                            <use xlink:href="/admin/images/icon-svg/free.svg#cil-pencil"></use>
                                        </svg>
                                    </a>
                                    <a class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')"
                                       href="/admin/page/delete/{{$item->id}}">
                                        <svg class="c-icon">
                                            <use xlink:href="/admin/images/icon-svg/free.svg#cil-trash"></use>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach @endif
                            </tbody>
                        </table>
                        <ul class="pagination">
                            @if($page > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{getUrlPage($page-1)}}">Prev</a>
                                </li>
                            @endif
                            @for($i = 1; $i <= $pagination; $i++)
                                <li class="page-item @if($i == $page) active @endif">
                                    <a class="page-link" href="{{getUrlPage($i)}}">{{$i}}</a>
                                </li>
                            @endfor
                            <li class="page-item">
                                <a class="page-link" href="{{getUrlPage($page+1)}}">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
