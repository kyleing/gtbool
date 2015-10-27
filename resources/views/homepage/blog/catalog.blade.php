@extends('homepage.blog.layout.base')
        @section('title')博文目录@stop
@section('header')
        <!-- Custom styles for this template -->
<link rel="stylesheet" href="/assets/blog/css/screen.css">
@stop

@section('content')
        <!-- start site's main content area -->
<section class="content-wrap">
    <div class="container">
        <div class="row">

            <main class="col-md-9 main-content">

                <article id=92 class="post tag-about-ghost tag-release tag-ghost-0-7-ban-ben">
                    @if($data)
                        @foreach($data as $list)
                    <div class="catalog-main">
                        <div class="catalog-title"><h4><a href="/blog/article?id={{$list['id']}}">{{$list['title']}}</a></h4></div>
                        <div class="catalog-time">{{$list['created_at']}}</div>
                    </div>
                        @endforeach
                        @endif
                </article>

                <nav class="pagination" role="navigation">
                    <span class="page-number">第 {{Input::get('page',1)}} 页 &frasl; 共 {{ceil($pageInfo['count'] / 10)}}  页</span>
                    <a class="older-posts" href="/page/2/"><i class="fa fa-angle-right"></i></a>
                </nav>


            </main>

            @include('homepage.blog.layout.right')

        </div>
    </div>
</section>
@stop
