@extends('homepage.blog.layout.base')
@section('title')博文目录@stop
@section('header')
        <!-- Custom styles for this template -->
<link rel="stylesheet" href="/assets/blog/css/blog.css">
@stop
@section('active')catalog @stop
@section('content')
    <div class="container">

        <div class="blog-header">
            <h1 class="blog-title">The Bootstrap Blog</h1>
            <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p>
        </div>

        <div class="row">

            <div class="col-sm-8 blog-main">

                <nav>
                    <ul class="pager">
                        <li><a href="#">Previous</a></li>
                        <li><a href="#">Next</a></li>
                    </ul>
                </nav>

            </div><!-- /.blog-main -->
            @include('homepage.blog.layout.right')

        </div><!-- /.row -->

    </div><!-- /.container -->
@stop