<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:90:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\corp\index.html";i:1594897943;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
        <a><cite>公司列表</cite></a>
    </span>
    <div style="float:right;">
        <button class="layui-btn layui-btn-primary layui-btn-sm"  onclick="addBanner()"><i class="layui-icon"></i>添加公司</button>
    </div>
</div>
<hr/>
<section class="panel panel-padding">
    <table lay-skin="line" class="layui-table" lay-filter="demo" lay-data="{height: 'full-200', cellMinWidth:30, url:'/xcx/corp/corpData/', limit:50,limits:[50] ,id: 'testReload',page:true}" >
        <thead>
        <tr>
            <th lay-data="{field:'cp_id',width:80}">Id</th>
            <th lay-data="{field:'cp_name'}">公司名称</th>
            <th lay-data="{field:'cp_address'}">地址</th>
            <th lay-data="{field:'cp_email'}">邮箱</th>
            <th lay-data="{field:'cp_tel'}">电话</th>
            <th lay-data="{field:'cp_count'}">员工数</th>
            <th lay-data="{field:'cp_addtime'}">提交时间</th>
            <th lay-data="{align:'left',width:168, toolbar: '#barDemo'}">操作</th>
        </tr>
        </thead>
    </table>
</section>
<script type="text/html" id="top1">
    <input type="checkbox" name="sex" lay-skin="switch" value="{{d.h_id}}" lay-text="已回访|未回访" lay-filter="topDemo" {{ d.h_is_review == '是' ? 'checked' : '' }}>
</script>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="review">详情</a>
    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
</script>
<script type="text/javascript">

    function addBanner(){
        window.location.href='<?=url('corp/add')?>';
    }
</script>
<script>
    layui.use(['table','laydate','form'], function(){
        var table = layui.table
            ,form = layui.form
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
                url: "<?=url('help/status')?>?id="+id+ "&change="+change,
                dataType:  'json',
                success: function(data){
                    // console.log(data.msg);
                    layer.msg(data.msg);
                }
            });
        });
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
                window.location.href='<?=url("corp/edit")?>?cp_id='+h_id;
            }else if(obj.event === 'del'){
                layer.confirm('确定删除该公司？删除后不可恢复！', {
                    btn : [ '确定', '取消' ]//按钮
                }, function() {
                    $.ajax({
                        'type':"get",
                        'url':"<?=url('corp/del')?>",
                        'data':{cp_id:h_id},
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
                                        window.location.href='<?=url("corp/index")?>';
                                    }
                                    ,cancel:function (index) {
                                        layer.close(index);
                                        window.location.href='<?=url("corp/index")?>';
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