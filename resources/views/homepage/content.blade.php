@extends('homepage.layout.base')
@section('header')
        <!-- Custom styles for this template -->
<link rel="stylesheet" href="/assets/blog/css/screen.css">
@stop

@section('content')
        <!-- start site's main content area -->
<section class="content-wrap">
    <div class="container">
        <div class="row">

            <main class="col-md-12 main-content">

                <article id=92 class="post tag-about-ghost tag-release tag-ghost-0-7-ban-ben">

                    <div class="post-head">
                        <h1 class="post-title"><a href="/ghost-0-7-0-released/">Ghost 0.7.0 正式发布</a></h1>
                        <div class="post-meta">
                            <time class="post-date" datetime="2015年9月7日星期一凌晨4点31分" title="2015年9月7日星期一凌晨4点31分">2015年9月7日</time>
                        </div>
                    </div>
                    <div class="post-content">
                        <p>Ghost 0.7.0 已经正式发布了！此版本主要对后台 UI 的重构，
                            既包含重新设计，也包含底层功能的重大改进。0.7.0 还为即将到来的 API
                            做了很多铺垫工作。 Ghost 0.7.0 的主要改进 [新增] 设计新后台界面 [新增]
                            后台能够搜索博文和用户 [新增] 安
                            如果你喜欢用英文原版？可以下载 中文集成包 和 英文原版安装包，首先解压 中文版集成包，然后再解压 英文版安装包 覆盖 中文版 即可，两个版本完全兼容，任意切换，同时还能免去安装依赖包时被墙的麻烦。
                            如何升级

                            对于所有自己安装 Ghost 的用户，建议首先备份数据库，以免升级失败丢失数据。

                            升级步骤：

                            首先 下载 Ghost 0.7.0 ，然后将其加压到一个新目录（千万不要直接覆盖老版本！）
                            进入新版本所在目录，复制 config.sample.js 文件并命名为 config.js；然后参照前一个版本的配置文件修改新的 config.js，主要是配置域名、邮箱、数据库、云存储；
                            将上一个版本中的 contents 目录整个复制过来，覆盖即可。主要是主题和图片。
                            执行 npm install --production 安装所有依赖包。如果你使用的是中文版完整安装包的话无需这一步操作了！
                            将老版本的 Ghost 关闭，启动新版本。检查一下是否有错误提示。
                            启动浏览器，打开你的网站。如果你是全新安装的话，就会看到安装界面，一步步来就行了。如果你是从老版本升级的话，直接就进入你的网站了，你可以进后台看看新后台界面吧。

                        </p>
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
@stop
