<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:92:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\forent\index.html";i:1598525061;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
            <section class="panel panel-padding" style="padding-top: 10px;padding-left: 10px;">
                <form class="layui-form layui-form-pane1">
                    <div class="layui-form-item  demoTable">
                        <div class="layui-inline">
                            <div class="layui-input-inline">
                                <input type="text" name="keywords" id="keywords"  placeholder="请输入房源标题或编号" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline" style="width:110px;">
                                <select name="type" id="type">
                                    <option value="">请选择类型</option>
                                    <option value="求租">求租</option>
                                    <option value="拼租">拼租</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline" >
                                <span class="layui-btn layui-btn-sm " data-type="reload">查询</span>
                                <a href="<?=url('forent/index')?>" class="layui-btn layui-btn-warm layui-btn-sm ">刷新</a>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
            <section class="panel panel-padding">
                <table lay-skin="line" class="layui-table" lay-filter="demo" lay-data="{height: 'full-200', cellMinWidth:60, url:'/xcx/forent/indexData/', limit:50,limits:[50] ,id: 'testReload',page:true}" >
                    <thead>
                    <tr>
                        <th lay-data="{field:'id' ,width:80}">id</th>
                        <th lay-data="{field:'title',width:150}">标题</th>
                        <th lay-data="{field:'city',width:100}">城市</th>
                        <th lay-data="{field:'school',width:120}">校区</th>
                        <th lay-data="{field:'type',width:100}">类型</th>
                        <th lay-data="{field:'view',width:100}">点击量</th>
                        <th lay-data="{field:'top', templet: '#switchTop',unresize: true}">上下线</th>
                        <th lay-data="{field:'cdate',width:180}">添加时间</th>
                        <th lay-data="{field:'user_id',width:150}">发布人</th>
                        <th lay-data="{field:'statuss',width:80}">状态</th>
                        <th lay-data="{ width:230, toolbar: '#barDemo'}">操作</th>
                    </tr>
                    </thead>
                </table>
            </section>
        </div>
    </div>
</div>
<script type="text/html" id="switchTop">
    <input type="checkbox" name="sex" lay-skin="switch" value="{{d.id}}" lay-text="上线|下线" lay-filter="topDemo" {{ d.status == '1' ? 'checked' : '' }}>
</script>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs  layui-btn-warm" lay-event="alert"><i class="layui-icon">&#xe637;</i>详情</a>

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
            var id = data.id;
            if(obj.event === 'alert'){
                layer.open({
                    type: 2,
                    title: '查看详情',
                    shadeClose: true,
                    shade: false,
                    maxmin: true,
                    area: ['80%', '80%'],
                    content: "<?=url('forent/details')?>?id="+id
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