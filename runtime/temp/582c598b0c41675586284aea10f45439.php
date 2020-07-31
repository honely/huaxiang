<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:87:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\corp\my.html";i:1596189925;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
    <title>小宝经纪人平台</title>
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
        <a>公司管理</a>
        <a><cite>我的公司</cite></a>
    </span>
</div>
<hr/>
<section class="panel panel-padding">
    <table lay-skin="line" class="layui-table" lay-filter="demo" lay-data="{height: 'full-200', cellMinWidth:30, url:'/xcx/corp/myData/', limit:50,limits:[50] ,id: 'testReload',page:true}" >
        <thead>
        <tr>
            <th lay-data="{field:'cp_id',width:80}">Id</th>
            <th lay-data="{field:'cp_name'}">公司名称</th>
            <th lay-data="{field:'cp_address'}">地址</th>
            <th lay-data="{field:'cp_email'}">邮箱</th>
            <th lay-data="{field:'cp_tel'}">电话</th>
            <th lay-data="{field:'cp_count'}">员工数</th>
            <th lay-data="{field:'cp_addtime'}">提交时间</th>
            <th lay-data="{align:'left',width:185, toolbar: '#barDemo'}">操作</th>
        </tr>
        </thead>
    </table>
</section>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="review">详情</a>
    <?php if($editable == true): ?>
    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="edit">编辑</a>
    <?php endif; if($addable == true): ?>
    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="add">添加员工</a>
    <?php endif; ?>
</script>
<script>
    layui.use(['table','laydate','form'], function(){
        var table = layui.table
            ,form = layui.form;
        table.on('tool(demo)', function(obj){
            var data = obj.data;
            var h_id = data.cp_id;
            if(obj.event === 'review'){
                layer.open({
                    type: 2,
                    title: '公司详情',
                    shadeClose: true,
                    shade: false,
                    maxmin: true,
                    area: ['80%', '80%'],
                    content: "<?=url('corp/detail')?>?cp_id="+h_id
                });
            }else if(obj.event === 'edit'){
                window.location.href='<?=url("corp/edit")?>?cp_id='+h_id+'&type=2';
            }else if(obj.event === 'add'){
                window.location.href='<?=url("corp/adda")?>?cp_id='+h_id;
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