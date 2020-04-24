<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:90:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\tags\house.html";i:1587353195;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1587691504;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1583744281;}*/ ?>
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
    <script src="../../../static/jquery-1.10.2.min.js"></script>
    <script src="../../../layui/src/layui.js"></script>
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
            <a>标签管理</a>
            <a><cite>房源标签</cite></a>
        </span>
    <div style="float:right;">
        <button class="layui-btn layui-btn-primary layui-btn-sm"  onclick="addBanner()"><i class="layui-icon"></i>添加</button>
    </div>
</div>
<hr/>
<section class="panel panel-padding">
    <table lay-skin="line" class="layui-table" lay-filter="demo" lay-data="{height: 'full-200', cellMinWidth:30, url:'/xcx/tags/tagData/', where:{type: 1}, limit:20,limits:[20,30,50] ,id: 'testReload',page:true}" >
        <thead>
        <tr>
            <th lay-data="{field:'id',width:80}">Id</th>
            <th lay-data="{field:'name'}">名称</th>
            <th lay-data="{align:'left',width:168, toolbar: '#barDemo'}">操作</th>
        </tr>
        </thead>
    </table>
</section>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="review">修改</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script>

    function addBanner(){
        window.location.href="<?=url('tags/add')?>?type=1";
    }
    layui.use(['table','laydate','form'], function(){
        var table = layui.table
            ,form = layui.form
            ,laydate = layui.laydate;
        table.on('tool(demo)', function(obj){
            var data = obj.data;
            var id = data.id;
            if(obj.event === 'review'){
                layer.open({
                    type: 2,
                    shadeClose: true,
                    shade: false,
                    maxmin: true,
                    area: ['80%', '80%'],
                    content: "<?=url('tags/edit')?>?type=1&id="+id
                });
            }else if(obj.event === 'del'){
                layer.confirm('确定删除该记录？删除后不可恢复！', {
                    btn : [ '确定', '取消' ]//按钮
                }, function() {
                    $.ajax({
                        'type':"get",
                        'url':"<?=url('tags/del')?>",
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
                                        window.location.href='<?=url("tags/house")?>';
                                    }
                                    ,cancel:function (index) {
                                        layer.close(index);
                                        window.location.href='<?=url("tags/house")?>';
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