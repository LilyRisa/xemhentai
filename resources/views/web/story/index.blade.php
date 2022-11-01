@extends('web.layout')
@section('main')
<div class="position-relative d-flex justify-content-center bg_secondary w-100 max-100">
    <div class="d-flex flex-wrap bg-white mt-auto container h-75">
        <div class="col-lg-3 col-12 pt-2 d-flex justify-content-center">
        {!! genImage($oneItem->thumbnail, 225, 330, 'img-fluid w-100 my-4 pt-lg-0') !!}
        </div>
        <div class="mt-4 px-4 d-flex flex-lg-inline flex-wrap col-lg-9 col-12"> 
           <ul class="w-100 ps-0">
                <li class="list-unstyled d-flex"><span class="fs-25">{{$oneItem->title}}</span></li>
                <li class="list-unstyled mt-1"><span class="fs-16 text-secondary">Tác giả: {{$oneItem->author}}</span></li>
                <li class="list-unstyled d-flex mt-1"><span class="fs-16">Tình trạng: </span><span class="ms-2 fs-16 text_secondary">{{$oneItem->is_update}}</span></li> 
                <li class="list-unstyled d-flex mt-1"><span class="fs-16">Lượt xem: </span><span class="ms-2 fs-16 d-flex align-items-center"><i class="icon-eye pt-1 me-2"></i>{{$oneItem->view_count}}</span></li> 
                <li class="list-unstyled d-flex mt-2">
                    @include('web.block._vote', ['data' => $oneItem, 'url' => '/story/ajax_rate'])
                </li>
                <li class="list-unstyled d-flex mt-1">
                    @if(!empty($oneItem->tags))
                        @foreach ($oneItem->tags as $t)
                            <div class="rounded-pill mx-2 border px-1"><a href="{{getUrlTag($t)}}">{{$t->title}}</a></div>
                        @endforeach
                    @endif
                </li>
                <li class="list-unstyled mt-3"><span>{!! $oneItem->content !!}</span></li>
                <li class="list-unstyled d-flex mt-5"><a class="btn bg-green1 border-0 text-white follow-story" data-status="0" data-story="{{$oneItem->id}}"><i class="icon-heart text-white"></i> Thêm vào tủ</a></li>
              
                <li class="list-unstyled d-flex mt-3"><a href="{{getUrlChapter($oneItem->chapter->last())}}" class="btn btn-secondary bg_secondary text-white border-0">Đọc từ đầu</a><a href="{{getUrlChapter($oneItem->chapter->first())}}" class="btn btn-secondary bg_secondary ms-2 text-white border-0">Đọc mới nhất</a></li>
           </ul>
           <ul class="ps-0">
            <li class="list-unstyled d-flex">
                <i class="icon-facebook1 text-primary"></i>
                <i class="icon-twitter1 ms-2 text-primary"></i>
                <i class="icon-youtube2 ms-2 text-danger"></i>
            </li>
           </ul>
        </div>
    </div>
</div>

<div class="container position-relative bg-white">
    <div class="row mt-0 pt-3">
    <div class="col-lg-9">
        <div class="d-flex container mt-2">
        <p class="text-nowrap">
            Chương (321)
        </p>
        <p class="text-end">
            Cập nhật lần cuối 25/12/2021
        </p>
    </div>

        
    <div class="col-12 container position-relative">
        <div class="show-more-height text">
        <ul class="list-unstyled row">
            @if(!empty($oneItem->chapter))
                @foreach($oneItem->chapter as $chapter)
                <li class="col-12">
                    <a href="{{getUrlChapter($chapter)}}" class="d-block list-group-item bg-light my-1 mx-0 d-flex">
                        @php
                            $title = explode("- ", $chapter->title);
                            $title = end($title);
                        @endphp
                        <p class="pb-0 mb-0">{{$title}}</p>
                        <p class="small text-secondary ms-auto mb-0">{{$chapter->update_origin}}</p>
                    </a>
                </li>
                @endforeach
            @endif
        </ul>
        </div>
        <nav class="mt-2">
            <ul class="pagination justify-content-center post"> 
               <button class="category-badge active show-more-chapter cursor-pointer" aria-current="page" data-url="load-more-posts">Xem thêm</button> 
            </ul>
         </nav>
        </div>
        
    </div>
    <div class="col-lg-3">
        <div class="mt-2 d-flex">
            <p class="fs-16 text-uppercase">
                Cùng tác giả
            </p>
            <div class="ms-auto pe-0">
            <a class="text-end text_secondary text-decoration-none" href="#">
                xem thêm >>
            </div>
            </a>
        </div>
        <div class="">
            @for ($i = 1; $i < 8; $i++)
                <div class="mt-2 pb-2 border-bottom row">
                    <div class="col-3"><img src="/img/book1.jpeg" class="img-fluid"></div>
                    <div class="col-9">
                        <div class="m-0 p-0">Tên truyện</div>
                        <div class="row mt-2">
                            <div class="col-9 fs-12">Chương 123</div>
                            <div class="col-3 text-end fs-12 fst-italic d-flex"><i class="icon-eye pt-1"></i><p class="ms-1"> 1205</p></div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>

@endsection