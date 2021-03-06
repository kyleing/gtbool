@extends('homepage.blog.layout.base')
@section('header')
        <!-- Custom styles for this template -->
<link rel="stylesheet" href="/assets/blog/css/screen.css">
<link rel="stylesheet" type="text/css" href="/assets/blog/simditor/styles/simditor.css" />

<link rel="stylesheet" type="text/css" href="/assets/blog/css/jquery.tagsinput.css" />
<link rel="stylesheet" type="text/css" href="/assets/blog/css/jquery-ui.css" />
@stop

@section('content')
        <!-- start site's main content area -->
<section class="content-wrap">
    <div class="container">
        <div class="row">

            <main class="col-md-12 main-content">

                <article id=92 class="post tag-about-ghost tag-release tag-ghost-0-7-ban-ben">

                    <form method="post">
                        <div class="post-content">
                            <div class="post-edit-title">
                                <label>标题</label>
                                <input type="text" name="title" class="form-control" id="titleInput" placeholder="title">
                            </div>
                            <div class="post-edit-tag">
                                <label>标签云</label>
                                <input type="text" name="tag" class="form-control tags" id="tagInput" placeholder="Add a tag (TAB or ENTER to add and move)">
                            </div>
                            <textarea id="editor"  name="content" placeholder="开始博客" autofocus></textarea>
                        </div>
                        <input type="submit" class="btn btn-primary " value="发布博文">
                    </form>

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


<script type="text/javascript" src="/assets/blog/simditor/scripts/module.min.js"></script>
<script type="text/javascript" src="/assets/blog/simditor/scripts/hotkeys.min.js"></script>
<script type="text/javascript" src="/assets/blog/simditor/scripts/uploader.min.js"></script>
<script type="text/javascript" src="/assets/blog/simditor/scripts/simditor.min.js"></script>

<script type="text/javascript" src="/assets/blog/js/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="/assets/blog/js/jquery-ui.min.js"></script>

<script>
    $(document).ready(function()
    {
        var editor = new Simditor({
            textarea: $('#editor'),
            //optional options
            toolbar: [
                'title',
                'bold',
                'italic',
                'underline',
                'strikethrough',
                'color',
                'ol',
                'ul',
                'blockquote',
                'code',
                'table',
                'link',
                'image',
                'hr',
                'indent',
                'outdent',
                'alignment'
            ]
        });
    });
</script>

<script type="text/javascript">
    function onAddTag(tag) {
        alert("Added a tag: " + tag);
    }
    function onRemoveTag(tag) {
        alert("Removed a tag: " + tag);
    }

    function onChangeTag(input,tag) {
        alert("Changed a tag: " + tag);
    }

    $(function() {
        $('#tagInput').tagsInput({width:'auto'});
    });
</script>

@stop
