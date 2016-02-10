<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="my first web">
    <meta name="author" content="tguo">
    <title>登录</title>

    <link href="/assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/assets/blog/css/home.css">
</head>

<style>
body {
    background: url(/assets/images/login_bg.jpg) center top no-repeat;
    overflow-x: hidden;
    background-attachment: fixed;
    background-size: cover;
}
</style>
<body>

<div class="site-wrapper">
    <div class="site-wrapper-inner">
        <div class="cover-container">
            <div class="masthead clearfix">
                <div class="inner">
                    <h3 class="masthead-brand">Gtbool <small>my first web</small></h3>
                    <nav>
                        <ul class="nav masthead-nav">
                            <li class="active"><a href="#">Home</a></li>
                            <li><a href="blog">Blog</a></li>
                            <li><a href="picture">Picture</a></li>
                            <li><a href="sh">Shell</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
             <div class="inner cover">
                        <h1 class="cover-heading">Log in</h1>
                        <form class="ng-pristine ng-valid ng-scope">
                          <div class="form-group">
                                 <input style="" class="form-control input-lg ng-pristine ng-valid ng-touched" ng-model="form.email" placeholder="Email" name="email" ng-disabled="loading" type="text">
                          </div>
                          <div class="form-group">
                           <input style="" class="form-control input-lg ng-pristine ng-valid ng-touched" ng-model="form.password" placeholder="Password" name="password" ng-disabled="loading" type="password">
                          </div>
                          <div class="form-group">
                          <button type="submit" class="btn btn-success btn-lg btn-block">Sign In</button>
                          </div>
                          </form>
             </div>
        </div>
    </div>
</div>



<!-- Bootstrap core JavaScript
  ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/assets/blog/js/jquery-1.9.1.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
