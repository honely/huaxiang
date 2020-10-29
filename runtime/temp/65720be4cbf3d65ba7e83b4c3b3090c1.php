<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:93:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\inspect\index.html";i:1603711545;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
        <a>求租拼租</a>
        <a><cite>求租拼租列表</cite></a>
    </span>
</div>
<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
    <div class="layui-tab-content" style="height: 100px;">
        <div class="layui-tab-item layui-show">
            <section class="panel panel-padding">
                <table lay-skin="line" class="layui-table" lay-filter="demo" lay-data="{height: 'full-200', cellMinWidth:60, url:'/xcx/inspect/indexData/', limit:50,limits:[50] ,id: 'testReload',page:true}" >
                    <thead>
                    <tr>
                        <th lay-data="{field:'hp_id' ,type:'checkbox',width:80}">id</th>
                        <th lay-data="{field:'address',width:250}">看房地址</th>
                        <th lay-data="{field:'ad_realname',width:100}">看房员</th>
                        <th lay-data="{field:'hp_plandate',width:150}">看房日期</th>
                        <th lay-data="{field:'hp_lastime',width:140}">看房时间</th>
                        <th lay-data="{field:'hp_maxnum',width:100}">最大看房人数</th>
                        <th lay-data="{field:'hp_type',width:180}">看房性质</th>
                        <th lay-data="{field:'hp_status',width:150}">状态</th>
                        <th lay-data="{ width:330, toolbar: '#barDemo'}">操作</th>
                    </tr>
                    </thead>
                </table>
            </section>
        </div>
    </div>
</div>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs  layui-btn" lay-event="addTime">增加时间</a>
    <a class="layui-btn layui-btn-xs  layui-btn" lay-event="update">修改</a>
    <a class="layui-btn layui-btn-xs  layui-btn" lay-event="cancel">取消</a>
    <a class="layui-btn layui-btn-xs  layui-btn-warm" lay-event="addRent">登记租客</a>
    <a class="layui-btn layui-btn-xs  layui-btn-warm" lay-event="contact">联系租客</a>
</script>
<script>
    layui.use(['table','laydate','form','element'], function(){
        var table = layui.table
            ,form = layui.form
            ,element = layui.element
            ,laydate = layui.laydate;
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
                url: "<?=url('forent/status')?>?id="+id+ "&change="+change,
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
                var type = $('#type').val();
                //执行重载
                table.reload('testReload', {
                    url: '/xcx/forent/indexData/'
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,where: {
                        keywords: keywords,
                        type: type
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
            var id = data.hp_id;
            if(obj.event === 'addTime'){
                layer.open({
                    type: 2,
                    title: '增加时间',
                    shadeClose: true,
                    shade: false,
                    maxmin: true,
                    area: ['80%', '80%'],
                    content: "<?=url('inspect/addtime')?>?id="+id
                });
            }else if(obj.event === 'addRent'){
                layer.open({
                    type: 2,
                    title: '登记租客',
                    shadeClose: true,
                    shade: false,
                    maxmin: true,
                    area: ['80%', '80%'],
                    content: "<?=url('inspect/addRent')?>?id="+id
                });
            }else if(obj.event === 'contact'){
                layer.open({
                    type: 2,
                    title: '联系租客',
                    shadeClose: true,
                    shade: false,
                    maxmin: true,
                    area: ['80%', '80%'],
                    content: "<?=url('inspect/emailrent')?>?id="+id
                });
            }else if(obj.event === 'cancel'){
                $.ajax({
                    'type':"get",
                    'url':"<?=url('inspect/cancel')?>?id="+id,
                    'success':function (result) {
                        if(result.code < 1){
                            layer.msg(result.msg);
                            window.location.href='<?=url("inspect/index")?>';
                        }else {
                            layer.msg(result.msg);
                            window.location.href='<?=url("inspect/index")?>';
                        }
                    },
                    'error':function () {
                        console.log('error');
                    }
                })
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