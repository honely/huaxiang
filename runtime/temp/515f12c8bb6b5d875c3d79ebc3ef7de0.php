<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:90:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\user\index.html";i:1591087557;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591172124;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1583744281;}*/ ?>
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
        height:64px !important;
        /*line-height:86px !important;*/
        clear: both;
    }
</style>
<div style="margin: 20px;">
    <span class="layui-breadcrumb" lay-separator=">">
        <a>客户列表</a>
        <a><cite>客户列表</cite></a>
    </span>
</div>
<hr/>
<section class="panel panel-padding" style="padding-top: 10px;padding-left: 10px;">
    <form class="layui-form layui-form-pane1">
        <div class="layui-form-item  demoTable">
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <input type="text" name="keywords" id="keywords"  placeholder="请输入用户昵称" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <span class="layui-btn" data-type="reload">查询</span>
                    <a href="<?=url('user/index')?>" class="layui-btn layui-btn-warm">刷新</a>
                </div>
            </div>
        </div>
    </form>
</section>
<section>
    <table lay-filter="demo" id="test123" lay-skin="nob"></table>
</section>
<script type="text/html" id="barDemo">
    <?php if($editable == true): ?>
    {{#  if(d.role_id == 1){ }}
    <a class="layui-btn layui-btn-xs" lay-event="admin">一般用户</a>
    {{#  }else{ }}
    <a class="layui-btn layui-btn-xs" lay-event="admin">管理员</a>
    {{#  } }}
    <?php endif; ?>
    <a class="layui-btn layui-btn-xs" lay-event="edit">详情</a>
    <?php if($addable == true): ?>
    <a class="layui-btn layui-btn-xs" lay-event="touch">沟通</a>
    <?php endif; ?>


</script>
<script>
    layui.use(['table','laydate','form'], function(){
        var table = layui.table
            ,form = layui.form;
        table.render({
            elem: '#test123'
            ,skin: 'line'
            ,url:'/xcx/user/userData/'
            ,height: 'full-200'
            ,cols: [[
                {field:'id', sort: true, title:'ID'}
                ,{field:'avaurl', title: '图像',templet:'<div><img style="width: 60px;height: 60px;" src="{{ d.avaurl}}"></div>'}
                ,{field:'nickname',title: '昵称'}
                ,{field:'count',title: '收藏量'}
                ,{field:'roleId',title: '管理员'}
                ,{field:'cdate', title: '注册时间'}
                ,{align:'center',toolbar: '#barDemo',title:'操作' }
            ]]
            ,limit:15
            ,limits:[15,30,50]
            ,id: 'testReload'
            ,page:true
        });

        table.on('tool(demo)', function(obj){
            var data = obj.data;
            var id = data.id;
            var role_id = data.role_id;
            var weChat = <?php echo $wechat; ?>;
            if(obj.event === 'edit'){
                window.location.href='<?=url("user/details")?>?id='+ id ;
            }else if(obj.event === 'touch'){
                if(weChat == 0){
                    layer.msg('您暂无该操作权限！',{
                        time: 2000
                    });
                }else{
                    window.location.href='<?=url("user/touch")?>?id='+ id ;
                }
            }else if(obj.event === 'admin'){
                if(weChat == 0){
                    layer.msg('您暂无该操作权限！',{
                        time: 2000
                    });
                }else{
                    var msg = role_id == 1 ? '一般用户'  : '管理员' ;
                    layer.confirm('确定将该用户改为'+msg+'？', {
                        btn : [ '确定', '取消' ]//按钮
                    }, function() {
                        $.ajax({
                            'type':"get",
                            'url':"<?=url('user/admin')?>",
                            'data':{id:id,role_id:role_id},
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
                                            window.location.href='<?=url("user/index")?>';
                                        }
                                        ,cancel:function (index) {
                                            layer.close(index);
                                            window.location.href='<?=url("user/index")?>';
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

            }
        });
        var $ = layui.$, active = {
            reload: function(){
                var keywords = $('#keywords').val();
                //执行重载
                table.reload('testReload', {
                    url: '/xcx/user/userData/'
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