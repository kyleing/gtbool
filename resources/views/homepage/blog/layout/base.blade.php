<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <script>
        @if(Session::get('msg'))
        alert("{{Session::get('msg')}}")
        @endif
    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="tguo">

    @include('homepage.blog.layout.header')

    @yield('header')
</head>

<body class="home-template">

<!-- start header -->
<header class="main-header"  style="background-image: url(/assets/images/header.jpg)">
<div class="container">
    <div class="row">
        <div class="col-sm-12">

            <!-- start logo -->
            <a class="branding" href="/" title="郭腾　．．．．"><img src="/assets/images/logo1.jpg" alt="郭腾　．．．．"  class="img-circle"></a>
            <!-- end logo -->
            <img src="http://static.ghostchina.com/image/6/d1/fcb3879e14429d75833a461572e64.jpg" alt="Ghost 博客系统" class="hide">
        </div>
    </div>
</div>
</header>
<!-- end header -->

<!-- start navigation -->
<nav class="main-navigation">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="navbar-header">
                        <span class="nav-toggle-button collapsed" data-toggle="collapse" data-target="#main-menu">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-bars"></i>
                        </span>
                </div>
                <div class="collapse navbar-collapse" id="main-menu">
                    <ul class="menu" id="topMenu">
                        <li class="nav-current" role="presentation"><a href="/blog">首页</a></li>
                        <li  role="presentation"><a href="/blog/article/catalog">博文目录</a></li>
                        <li  role="presentation"><a href="/ghost-cheat-sheet/">未知</a></li>
                        <li  role="presentation"><a href="http://docs.ghostchina.com/zh/">关于我</a></li>
                        <li  role="presentation"><a href="" data-toggle="modal" data-target="#register-modal">注册</a></li>
                        <li  role="presentation"><a href="" data-toggle="modal" data-target="#login-modal">登陆</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- end navigation -->

@yield('content')

@include('homepage.blog.layout.footer')

<!-- login modal start -->
<div class="modal fade" id="login-modal" role="dialog" aria-labelledby="loginModal">
    <div class="modal-dialog" role="document" aria-hidden="true">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="login-title">Login Blog</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form class="form-horizontal" action="/user/login" method="post">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10">
                                <input type="email" name="user_name" class="form-control" id="inputEmail3" placeholder="Username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> Remember me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="modal-button-bottom" >
                                <button type="submit" class="btn btn-success">Sign in</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- login modal end -->

<!-- register modal start -->
<div class="modal fade" id="register-modal" role="dialog" aria-labelledby="loginModal">
    <div class="modal-dialog" role="document" aria-hidden="true">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="login-title">成为我的粉丝</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form class="form-horizontal" action="/user/register" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">用户名</label>
                            <div class="col-sm-10">
                                <input type="email" name="user_name" class="form-control" id="inputEmail3" placeholder="Username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">重复密码</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="modal-button-bottom" >
                                <button type="submit" class="btn btn-success">注册</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- register modal end -->

<!-- 公共部分 -->
<script>
    $(function(){
        var $menu = $('#topMenu');
        var $node = $menu.find('a[href="' + location.pathname + location.search + location.hash + '"]').addClass('active');
        $node = $node.length ? $node : $menu.find('a[href="' + location.pathname + location.search + '"]');
        $node = $node.length ? $node : $menu.find('a[href="' + location.pathname + '"]');
        $li = $node.parent();

        $menu.find('li').removeClass('nav-current');
        $li.addClass('nav-current');
    });
</script>

</body>
</html>
