<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:91:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\house\index.html";i:1587441482;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1587553386;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1583744281;}*/ ?>
<!DOCTYPE html>
<html style="height: 100%">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <title>小宝租房后台管理系统</title>
    <link rel="stylesheet" href="../../../layui/src/css/layui.css">
    <link rel="stylesheet" href="../../../layui/src/autocomplete/selectpage.css">
    <script src="../../../static/jquery-1.10.2.min.js"></script>
    <script src="../../../layui/src/layui.js"></script>
    <script src="../../../layui/src/autocomplete/selectpage.js"></script>
	<style>
		.layui-body{
			left:0!important
		}
	</style>
</head>
<body class="layui-layout-body" style="height: 100%">

<style>
    .layui-table-cell{
        height:36px !important;
        line-height:36px !important;
        clear: both;
    }
</style>
<div style="margin: 20px;">
    <span class="layui-breadcrumb" lay-separator=">">
        <a>房源管理</a>
        <a><cite>房源列表</cite></a>
    </span>
    <div style="float:right;">
        <button class="layui-btn layui-btn-primary layui-btn-sm"  onclick="addArt()"><i class="layui-icon"></i>发布房源</button>
    </div>
</div>
<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
    <div class="layui-tab-content" style="height: 100px;">
        <div class="layui-tab-item layui-show">
            <section class="panel panel-padding" style="padding-top: 10px;padding-left: 10px;">
                <form class="layui-form layui-form-pane1">
                    <div class="layui-form-item  demoTable">
                        <div class="layui-inline">
                            <div class="layui-input-inline" style="width: 250px;">
                                <input type="text" name="keywords" id="keywords"  placeholder="请输入房源标题或编号" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline" style="width: 300px;">
                                <span class="layui-btn" data-type="reload">查询</span>
                                <a href="<?=url('house/index')?>" class="layui-btn layui-btn-warm">刷新</a>
<!--                                <span class="layui-btn layui-btn-normal" >导出</span>-->
                            </div>
                        </div>
                    </div>
                </form>
            </section>
            <section class="panel panel-padding">
                <table lay-skin="line" class="layui-table" lay-filter="demo" lay-data="{height: 'full-200', cellMinWidth:60, url:'/xcx/house/houseData/', limit:20,limits:[20,30,50] ,id: 'testReload',page:true}" >
                    <thead>
                    <tr>
                        <th lay-data="{field:'dsn' ,width:110}">房源编号</th>
                        <th lay-data="{field:'title',width:230}">标题</th>
                        <th lay-data="{field:'city',width:100}">城市</th>
                        <th lay-data="{field:'area',width:120}">区域</th>
                        <th lay-data="{field:'collection',width:100}">收藏量</th>
                        <th lay-data="{field:'view',width:100}">点击量</th>
                        <th lay-data="{field:'top', templet: '#top1',unresize: true}">置顶</th>
                        <th lay-data="{field:'tj', templet: '#switchTj',unresize: true}">推荐</th>
                        <th lay-data="{field:'status',width:80}">状态</th>
                        <th lay-data="{field:'cdate',width:100}">添加时间</th>
                        <th lay-data="{ width:250, toolbar: '#barDemo'}">操作</th>
                    </tr>
                    </thead>
                </table>
            </section>
        </div>
    </div>
</div>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="tags">标签</a>
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-xs  layui-btn-warm" lay-event="alert">详情</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script type="text/html" id="top1">
    <input type="checkbox" name="sex" lay-skin="switch" value="{{d.id}}" lay-text="是|否" lay-filter="topDemo" {{ d.top == '是' ? 'checked' : '' }}>
</script>
<script type="text/html" id="switchTj">
    <input type="checkbox" name="sex" lay-skin="switch" value="{{d.id}}" lay-text="是|否" lay-filter="sexDemo" {{ d.tj == '是' ? 'checked' : '' }}>
</script>
<script>
    layui.use(['table','laydate','form','element'], function(){
        var table = layui.table
            ,form = layui.form
            ,element = layui.element
            ,laydate = layui.laydate;
        laydate.render({
            elem: '#live_time'
            ,range: true
        });

        //监听是否开启操作
        form.on('switch(topDemo)', function(obj){
            var id = this.value;
            //如果选中状态是true,后台数据将要改为显示
            var change = obj.elem.checked;
            if(change){
                change = 1;
            }else{
                change = 0;
            }
            $.ajax({
                type: 'POST',
                url: "<?=url('house/status')?>?id="+id+ "&change="+change,
                dataType:  'json',
                success: function(data){
                    // console.log(data.msg);
                    layer.msg(data.msg);
                }
            });
        });


        //监听是否开启操作
        form.on('switch(sexDemo)', function(obj){
            var id = this.value;
            //如果选中状态是true,后台数据将要改为显示
            var change = obj.elem.checked;
            if(change){
                change = 1;
            }else{
                change = 0;
            }
            $.ajax({
                type: 'POST',
                url: "<?=url('house/tjstatus')?>?id="+id+ "&change="+change,
                dataType:  'json',
                success: function(data){
                    // console.log(data.msg);
                    layer.msg(data.msg);
                }
            });
        });


        var $ = layui.$, active = {
            reload: function(){
                var keywords = $('#keywords').val();
                //执行重载
                table.reload('testReload', {
                    url: '/xcx/house/houseData/'
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,where: {
                        keywords: keywords
                    },
                    success:function (data) {
                        console.log(data);
                    }
                });
            }

        };
        $('.demoTable .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
        table.on('tool(demo)', function(obj){
            var data = obj.data;
            var id = data.id;
            if(obj.event === 'edit'){
                window.location.href='<?=url("house/edit")?>?id='+id;
            }else if(obj.event === 'alert'){
                layer.open({
                    type: 2,
                    title: '查看详情',
                    shadeClose: true,
                    shade: false,
                    maxmin: true,
                    area: ['80%', '80%'],
                    content: "<?=url('house/detail')?>?id="+id
                });
            }else if(obj.event === 'tags'){
                window.location.href='<?=url("house/tags")?>?id='+id;
                // layer.open({
                //     type: 2,
                //     title: '打标签',
                //     shadeClose: true,
                //     shade: false,
                //     maxmin: true,
                //     area: ['80%', '80%'],
                //     content: "<?=url('house/tags')?>?id="+id
                // });
            } else if(obj.event === 'del'){
                layer.confirm('确定删除该房源？删除后不可恢复！', {
                    btn : [ '确定', '取消' ]//按钮
                }, function() {
                    $.ajax({
                        'type':"get",
                        'url':"<?=url('house/del')?>",
                        'data':{id:id},
                        'success':function (result) {
                            if(result.code < 1){
                                layer.msg(result.msg);
                            }else {
                                layer.msg(result.msg);
                                layer.open({
                                    title: '信息'
                                    ,content: result.msg
                                    ,yes: function(index){
                                        layer.close(index);
                                        window.location.href='<?=url("house/index")?>';
                                    }
                                    ,cancel:function (index) {
                                        layer.close(index);
                                        window.location.href='<?=url("house/index")?>';
                                    }
                                });
                            }
                        },
                        'error':function () {
                            console.log('error');
                        }
                    })
                },function(){
                    layer.msg('您已取消该操作！',{
                        time: 2000
                    });
                });
            }
        });
    });
    function addArt() {
        window.location.href='<?=url("house/add")?>';
    }    function addArt1() {
        window.location.href='<?=url("house/add1")?>';
    }

</script>
</div>
<script>
    //JavaScript代码区域
    layui.use('element', function(){
        var element = layui.element;

    });
</script>
</body>
</html>