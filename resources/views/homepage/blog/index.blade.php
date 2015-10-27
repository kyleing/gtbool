@extends('homepage.blog.layout.base')
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

                @if($data)
                    @foreach($data as $list)
                <article id=92 class="post tag-about-ghost tag-release tag-ghost-0-7-ban-ben">
                    <div class="post-head">
                        <h1 class="post-title"><a href="/blog/article?id={{$list['id']}}">{{$list['title']}}</a></h1>
                        <div class="post-meta">
                            <time class="post-date" datetime="2015年9月7日星期一凌晨4点31分" title="2015年9月7日星期一凌晨4点31分">{{$list['created_at']}}</time>
                        </div>
                    </div>
                    <div class="post-content">
                        <p>{!! $list['content'] !!}</p>
                    </div>
                    <div class="post-permalink">
                        <a href="/blog/content?id=1" class="btn btn-default">阅读全文（139）</a>
                    </div>

                    <footer class="post-footer clearfix">
                        <div class="pull-left tag-list">
                            <i class="fa fa-folder-open-o"></i>
                            <a href="/tag/about-ghost/">Ghost</a>, <a href="/tag/release/">新版本发布</a>, <a href="/tag/ghost-0-7-ban-ben/">Ghost 0.7 版本</a>
                        </div>
                        <div class="pull-right share">
                        </div>
                    </footer>
                </article>
                    @endforeach
                @endif

                <nav class="pagination" role="navigation">
                    <span class="page-number">第 1 页 &frasl; 共 8 页</span>
                    <a class="older-posts" href="/page/2/"><i class="fa fa-angle-right"></i></a>
                </nav>


            </main>

            @include('homepage.blog.layout.right')

        </div>
    </div>
</section>
@stop
