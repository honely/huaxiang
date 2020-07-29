<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:91:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\user\serlog.html";i:1592898807;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
    .layui-form-item {
        margin-bottom: 0px !important;
        clear: both;
        *zoom: 1;
    }
</style>
<div style="margin: 20px;">
    <span class="layui-breadcrumb" lay-separator=">">
        <a>客户管理</a>
        <a><cite>搜索历史</cite></a>
    </span>
</div>
<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
    <div class="layui-tab-content" style="height: 100px;">
        <div class="layui-tab-item layui-show">
            <section class="panel panel-padding" style="padding-top: 10px;padding-left: 10px;">
                <form class="layui-form layui-form-pane1">
                    <div class="layui-form-item  demoTable">
                        <div class="layui-inline">
                            <div class="layui-input-inline">
                                <input type="text" name="keywords" id="keywords"  placeholder="请输入搜索关键词" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline">
                                <input type="text" name="user" id="user"  placeholder="请选择客户昵称" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline" >
                                <span class="layui-btn layui-btn-sm " data-type="reload">查询</span>
                                <a href="<?=url('user/serlog')?>" class="layui-btn layui-btn-warm layui-btn-sm ">刷新</a>
                                <?php if($addable == true): ?>
                                <a class="layui-btn layui-btn-normal layui-btn-sm"  id="export">导出</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
            <section class="panel panel-padding">
                <table lay-skin="line" class="layui-table" lay-filter="demo" lay-data="{height: 'full-200', cellMinWidth:60, url:'/xcx/user/logData/', limit:50,limits:[50] ,id: 'testReload',page:true}" >
                    <thead>
                    <tr>
                        <th lay-data="{field:'sk_id'}">ID</th>
                        <th lay-data="{field:'sk_keywords'}">关键词</th>
                        <th lay-data="{field:'sk_type'}">搜索类型</th>
                        <th lay-data="{field:'sk_userid'}">用户ID</th>
                        <th lay-data="{field:'sk_username'}">用户昵称</th>
                        <th lay-data="{field:'sk_addtime'}">搜索时间</th>
                    </tr>
                    </thead>
                </table>
            </section>
        </div>
    </div>
</div>
<script>
    layui.use(['table','laydate','form','element'], function(){
        var table = layui.table
            ,form = layui.form
            ,laydate = layui.laydate;
        laydate.render({
            elem: '#time'
            ,range: true
        });
        var $ = layui.$, active = {
            reload: function(){
                var keywords = $('#keywords').val();
                var user = $('#user').val();
                table.reload('testReload', {
                    url: '/xcx/user/logData/'
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,where: {
                        keywords: keywords,
                        user: user
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
    });
    $('#export').click(function () {
        var keywords = $('#keywords').val();
        var user = $('#user').val();
        window.location.href='<?=url("export/out")?>?keywords='+keywords+'&user='+user;
    })
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