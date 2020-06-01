<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:90:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\mate\index.html";i:1589851102;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1587691504;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1583744281;}*/ ?>
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
    .layui-form-item {
        margin-bottom: 0px !important;
        clear: both;
        *zoom: 1;
    }
</style>
<div style="margin: 20px;">
    <span class="layui-breadcrumb" lay-separator=">">
        <a>找室友管理</a>
        <a><cite>找室友列表</cite></a>
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
<!--                            发布人-->
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline" style="width: 80px;">
                                <select name="city" id="city" lay-filter="bu_p_id">
                                    <option value="">请选择城市</option>
                                    <?php if(is_array($cityinfo) || $cityinfo instanceof \think\Collection || $cityinfo instanceof \think\Paginator): $i = 0; $__LIST__ = $cityinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$role): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo $role['name']; ?>"><?php echo $role['name']; ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline" style="width:80px;">
                                <div class="layui-input-inline" style="width: 80px;">
                                    <select name="area" id="bu_c_id">
                                        <option value="">请选择学校</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline" style="width:110px;">
                                <select name="status" id="statu">
                                    <option value="">请选择状态</option>
                                    <option value="1">发布</option>
                                    <option value="2">草稿</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline">
                                <input type="text" name="time" readonly class="layui-input" id="time" placeholder="请选择发布日期">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline" >
                                <span class="layui-btn layui-btn-sm " data-type="reload">查询</span>
                                <a href="<?=url('mate/index')?>" class="layui-btn layui-btn-warm layui-btn-sm ">刷新</a>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
            <section class="panel panel-padding" style="padding-top: 10px;padding-left: 10px;">
                <form class="layui-form layui-form-pane1">
                    <div class="layui-form-item  demoTable">
                        <div class="layui-inline">
                            <div class="layui-input-inline" style="width: 300px;">
                                <span class="layui-btn layui-btn-normal layui-btn-sm" >点击量</span>
                                <input type="hidden" id="orderView" value="0">
                                <span type="button" class="layui-btn layui-btn-xs layui-btn-primary" data-type="reload" id="viewZ">
                                    <i class="layui-icon">&#xe619;</i>
                                </span>
                                <span type="button" class="layui-btn layui-btn-xs layui-btn-primary" data-type="reload" id="viewD">
                                    <i class="layui-icon">&#xe61a;</i>
                                </span>
                                <span class="layui-btn layui-btn-normal layui-btn-sm">收藏量</span>
                                <input type="hidden" id="orderColt" value="0">
                                <span type="button" class="layui-btn layui-btn-xs layui-btn-primary" data-type="reload" id="collectZ">
                                    <i class="layui-icon">&#xe619;</i>
                                </span>
                                <span type="button" class="layui-btn layui-btn-xs layui-btn-primary" data-type="reload" id="collectD">
                                    <i class="layui-icon">&#xe61a;</i>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
            <section class="panel panel-padding">
                <table lay-skin="line" class="layui-table" lay-filter="demo" lay-data="{height: 'full-200', cellMinWidth:60, url:'/xcx/mate/indexData/', limit:20,limits:[20,30,50] ,id: 'testReload',page:true}" >
                    <thead>
                    <tr>
                        <th lay-data="{field:'dsn' ,width:140}">帖子编号</th>
                        <th lay-data="{field:'title',width:150}">标题</th>
                        <th lay-data="{field:'city',width:100}">城市</th>
                        <th lay-data="{field:'school',width:120}">校区</th>
                        <th lay-data="{field:'collection',width:100}">收藏量</th>
                        <th lay-data="{field:'view',width:100}">点击量</th>

                        <th lay-data="{field:'cdate',width:180}">添加时间</th>
                        <th lay-data="{field:'user_id',width:80}">发布人</th>
                        <th lay-data="{field:'statuss',width:80}">状态</th>
                        <th lay-data="{field:'top', templet: '#switchTop',unresize: true}">上下线</th>
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
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon">&#xe640;</i>删除</a>
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
                url: "<?=url('mate/status')?>?id="+id+ "&change="+change,
                dataType:  'json',
                success: function(data){
                    // console.log(data.msg);
                    layer.msg(data.msg);
                }
            });
        });
        form.on('select(bu_p_id)', function(data){
            var city=data.value;
            $.ajax({
                type: 'POST',
                url: "<?=url('mate/getschool')?>?city="+city,
                data: {city:city},
                dataType:  'json',
                success: function(data){
                    var code=data.data;
                    console.log(code);
                    $("#bu_c_id").html("<option value=''>请选择城市</option>");
                    $.each(code, function(i, val) {
                        var option1 = $("<option>").val(val.id).text(val.name);
                        $("#bu_c_id").append(option1);
                        form.render('select');
                    });
                    $("#bu_c_id").get(0).selectedIndex=0;
                }
            });
        });
        laydate.render({
            elem: '#time'
            ,range: true
        });
        var $ = layui.$, active = {
            reload: function(){
                var keywords = $('#keywords').val();
                var orderv = $('#orderView').val();
                var orderc = $('#orderColt').val();
                var city = $('#city').val();
                var status = $('#statu').val();
                var school = $('#school').val();
                var time = $('#time').val();
                //执行重载
                table.reload('testReload', {
                    url: '/xcx/mate/indexData/'
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,where: {
                        keywords: keywords,
                        orderv: orderv,
                        orderc: orderc,
                        city: city,
                        school: school,
                        status: status,
                        time: time
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
                    content: "<?=url('mate/details')?>?id="+id
                });
            } else if(obj.event === 'del'){
                layer.confirm('确定删除？删除后不可恢复！', {
                    btn : [ '确定', '取消' ]//按钮
                }, function() {
                    $.ajax({
                        'type':"get",
                        'url':"<?=url('mate/del')?>",
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
                                        window.location.href='<?=url("mate/index")?>';
                                    }
                                    ,cancel:function (index) {
                                        layer.close(index);
                                        window.location.href='<?=url("mate/index")?>';
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
    function switchOrder(id) {
        layui.use(['table','jquery'], function(){
            var table = layui.table;
            table.reload('testReload', {
                url: '/admin/order/orderData/'
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    step: id,
                },
                success:function (data) {
                    console.log(data);
                }
            });
        })
    }
    $("#viewZ").click(function(){
        $("#orderView").val(1);
        $("#orderColt").val(0);
    });
    $("#viewD").click(function(){
        $("#orderView").val(2);
        $("#orderColt").val(0);
    });
    $("#collectZ").click(function(){
        $("#orderColt").val(1);
        $("#orderView").val(0);
    });
    $("#collectD").click(function(){
        $("#orderColt").val(2);
        $("#orderView").val(0);
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