<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:89:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\user\msgs.html";i:1591087955;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1587691504;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1583744281;}*/ ?>
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
        height:60px !important;
        line-height:60px !important;
        clear: both;
    }
</style>
<div style="margin: 20px;">
    <span class="layui-breadcrumb" lay-separator=">">
        <a>我的会话列表</a>
    </span>
</div>
<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
    <div class="layui-tab-content" style="height: 100px;">
        <div class="layui-tab-item layui-show">
            <section class="panel panel-padding">
                <table lay-skin="line" class="layui-table" lay-filter="demo" lay-data="{height: 'full-200', cellMinWidth:60, url:'/xcx/user/msgData/', limit:20,limits:[20,30,50] ,id: 'testReload',page:true}" >
                    <thead>
                    <tr>
                        <th lay-data="{field:'mp_id'}">会话id</th>
                        <th lay-data="{field:'avaurl',templet: '#status'}">图像</th>
                        <th lay-data="{field:'nickname'}">昵称</th>
                        <th lay-data="{field:'mp_mod_time'}">时间</th>
                        <th lay-data="{field:'count'}">未读</th>
                        <th lay-data="{ toolbar: '#barDemo'}">操作</th>
                    </tr>
                    </thead>
                </table>
            </section>
        </div>
    </div>
</div>
<script type="text/html" id="status">
    <img src="{{d.avaurl}}" alt="" style="width: 60px;height: 60px;">
</script>
<script type="text/html" id="barDemo">
    <?php if($addable == true): ?>
    <a class="layui-btn layui-btn-xs" lay-event="edit">沟通</a>
    <?php endif; if($editable == true): ?>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    <?php endif; ?>
</script>
<script>
    layui.use(['table','laydate','form','element'], function(){
        var table = layui.table
            ,form = layui.form
            ,element = layui.element
            ,laydate = layui.laydate;
        laydate.render({
            elem: '#time'
            ,range: true
        });
        table.on('tool(demo)', function(obj){
            var data = obj.data;
            var mp_id = data.mp_id;
            if(obj.event === 'edit'){
                window.location.href='<?=url("user/touchs")?>?mp_id='+ mp_id;
            }else if(obj.event === 'del'){
                layer.confirm('确定删除该聊天？删除后不可恢复！', {
                    btn : [ '确定', '取消' ]//按钮
                }, function() {
                    $.ajax({
                        'type':"get",
                        'url':"<?=url('user/delmsg')?>",
                        'data':{mpid:mp_id},
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
                                        window.location.href='<?=url("user/msgs")?>';
                                    }
                                    ,cancel:function (index) {
                                        layer.close(index);
                                        window.location.href='<?=url("user/msgs")?>';
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