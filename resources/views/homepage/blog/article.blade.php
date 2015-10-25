@extends('homepage.blog.layout.base')
@section('header')
        <!-- Custom styles for this template -->
<link rel="stylesheet" href="/assets/blog/css/screen.css">
<link rel="stylesheet" type="text/css" href="/assets/blog/simditor/styles/simditor.css" />


@stop

@section('content')
        <!-- start site's main content area -->
<section class="content-wrap">
    <div class="container">
        <div class="row">

            <main class="col-md-12 main-content">

                <article id=92 class="post tag-about-ghost tag-release tag-ghost-0-7-ban-ben">

                    <div class="post-head">
                        <h1 class="post-title"><a href="">{{$data['title']}}</a></h1>
                        <div class="post-meta">
                            <time class="post-date" datetime="2015年9月7日星期一凌晨4点31分" title="2015年9月7日星期一凌晨4点31分">{{$data['created_at']}}</time>
                        </div>
                    </div>
                    <div class="post-content ">
                        <pre>
                        {{$data['content']}}
                        </pre>
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
            </main>
        </div>
    </div>
</section>
<script>
    $(".post-content").html("{{$data['content']}}");
</script>
@stop
