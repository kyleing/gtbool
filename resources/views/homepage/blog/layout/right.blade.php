<aside class="col-md-3 sidebar">
    <!-- start widget -->
    <!-- end widget -->

    <!-- start tag cloud widget -->
    <!-- end tag cloud widget -->

    <!-- start widget -->
    <div class="widget">
        <h4 class="title"><i class="glyphicon glyphicon-pencil"></i></h4>
        <div class="content download">
            <a href="/blog/article/edit" class="btn btn-default btn-block"><i class="glyphicon glyphicon-pencil"></i> 发布新文章</a>
        </div>
    </div>
    <!-- end widget -->

    <!-- start tag cloud widget -->
    <div class="widget">
        <h4 class="title"><i class="glyphicon glyphicon-cloud"></i></h4>
        <div class="content tag-cloud" id="tagCloud">

        </div>
    </div>
    <!-- end tag cloud widget -->

    <!-- start widget -->
    <div class="widget">
        <h4 class="title">Archives</h4>
        <div id="createTime">

        </div>
    </div>
    <!-- end widget -->
    <div class="widget">
        <h4 class="title">链接</h4>
        <div>
            <p><a href="">Bootstrap中文网</a></p>
            <p><a href="">laravel中文网</a></p>
        </div>
    </div>
    <!-- start widget -->
    <!-- end widget -->
</aside>

<script>
    $(function(){
        $.get('/blog/article/info',{},function(res,status)
        {
            $.each(res,function(k,v){
               if(k == 'tag')
               {
                   for(var i = 0 ;i < v.length ;i++)
                   {
                       var str = "<a href=''>"+ v[i] +"</a>";
                       $(".tag-cloud").append(str);
                   }
               }
                if(k == 'time')
                {
                    for(var j = 0 ;j < v.length ;j++)
                    {
                        var time = "<p><a href=''>"+ v[j] +"</a><p/>";
                        $("#createTime").append(time);
                    }
                }

            });
        },'json')
    });
</script>