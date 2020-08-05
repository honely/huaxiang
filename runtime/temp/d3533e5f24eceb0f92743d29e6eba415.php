<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:93:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\house\myhouse.html";i:1596527777;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
        <a><?php echo $lable['houselist']; ?></a>
        <a><cite><?php echo $lable['myhouse']; ?></cite></a>
    </span>
    <div style="float:right;">
        <?php if($addable == true): ?>
        <button class="layui-btn layui-btn-primary layui-btn-sm"  onclick="addArt()"><i class="layui-icon"></i><?php echo $lable['fabufangyuan']; ?></button>
        <?php endif; ?>
    </div>
</div>
<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
    <div class="layui-tab-content" style="height: 100px;">
        <div class="layui-tab-item layui-show">
            <section class="panel panel-padding" style="padding-top: 0px;padding-left: 10px;">
                <form class="layui-form layui-form-pane1">
                    <div class="layui-form-item  demoTable">
                        <div class="layui-inline" >
                            <label class="layui-form-label" style="padding: 9px 14px;width: 57px;font-weight: bold"><?php echo $lable['keys']; ?>：</label>
                            <div class="layui-input-inline" style="width: 80px;margin-right: 0px;">
                                <select name="keytype" id="keytype" style="border-right: white;">
                                    <option value="2">ID</option>
                                    <option value="1"><?php echo $lable['title']; ?></option>
                                    <option value="4"><?php echo $lable['postby']; ?></option>
                                    <option value="3"><?php echo $lable['houseAddr']; ?></option>
                                    <option value="5"><?php echo $lable['rendetail']; ?></option>
                                </select>
                            </div>
                            <div class="layui-input-inline" style="width:160px;">
                                <input type="text" name="keywords" id="keywords"  placeholder="<?php echo $lable['pleaseInput']; ?>" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" style="padding: 9px 14px;width: 42px;font-weight: bold"><?php echo $lable['status']; ?>：</label>
                            <div class="layui-input-inline" style="width:110px;">
                                <select name="status" id="statu">
                                    <option value=""><?php echo $lable['suoyou']; ?></option>
                                    <option value="1"><?php echo $lable['on']; ?></option>
                                    <option value="2"><?php echo $lable['off']; ?></option>
                                    <option value="3"><?php echo $lable['draft']; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline" style="margin-right: 0px;">
                            <label class="layui-form-label" style="padding: 9px 14px;width: 42px;font-weight: bold"><?php echo $lable['quyu']; ?>：</label>
                            <div class="layui-input-inline" style="width: 80px;margin-right: 0px;">
                                <select name="city" id="city" lay-filter="bu_p_id">
                                    <option value=""><?php echo $lable['city']; ?></option>
                                    <?php if(is_array($cityinfo) || $cityinfo instanceof \think\Collection || $cityinfo instanceof \think\Paginator): $i = 0; $__LIST__ = $cityinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$role): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo $role['name']; ?>"><?php echo $role['sname']; ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                            <div class="layui-input-inline" style="width:80px;">
                                <div class="layui-input-inline" style="width: 80px;">
                                    <select name="area" id="bu_c_id">
                                        <option value=""><?php echo $lable['area']; ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" style="padding: 9px 14px;width: 80px;font-weight: bold"><?php echo $lable['postdate']; ?>：</label>
                            <div class="layui-input-inline" style="width:244px;">
                                <input type="text" name="time" readonly class="layui-input" id="time" placeholder="<?php echo $lable['selectUpdateTime']; ?>">
                            </div>
                        </div>
                        <div class="layui-inline" style="width: 110px !important;">
                            <div class="layui-input-inline" >
                                <span class="layui-btn layui-btn-sm " data-type="reload"><?php echo $lable['search']; ?></span>
                                <a href="<?=url('house/myhouse')?>" class="layui-btn layui-btn-warm layui-btn-sm "><?php echo $lable['fresh']; ?></a>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
            <section class="panel panel-padding" style="padding-top: 0px;padding-left: 10px;">
                <form class="layui-form layui-form-pane1">
                    <div class="layui-form-item  demoTable">
                        <div class="layui-inline" style="margin-top: 5px;">
                            <div class="layui-input-inline" >
                                <span class="layui-btn layui-btn-sm layui-btn-danger" data-type="getCheckData"><?php echo $lable['delete']; ?></span>
                            </div>
                        </div>
                        <div class="layui-inline" style="float: right;margin-right: 60px;">
                            <label class="layui-form-label" style="padding: 9px 14px;width: 80px;font-weight: bold"><?php echo $lable['order']; ?>：</label>
                            <div class="layui-input-inline" style="width:130px;">
                                <select name="order" id="order"  lay-filter="reOrder">
                                    <option value=""><?php echo $lable['ordertype']; ?></option>
                                    <option value="1"><?php echo $lable['viewdesc']; ?></option>
                                    <option value="2"><?php echo $lable['viewasc']; ?></option>
                                    <option value="3"><?php echo $lable['likedesc']; ?></option>
                                    <option value="4"><?php echo $lable['likeasc']; ?></option>
                                    <option value="5"><?php echo $lable['datedesc']; ?></option>
                                    <option value="6"><?php echo $lable['detaasc']; ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
            <section class="panel panel-padding">
                <table lay-skin="line" class="layui-table" lay-filter="demo" lay-data="{height: 'full-200', cellMinWidth:60, url:'/xcx/house/myData/', limit:50,limits:[50] ,id: 'testReload',page:true}" >
                    <thead>
                    <tr>
                        <th lay-data="{type:'checkbox', width:48}">id</th>
                        <th lay-data="{field:'dsn' ,width:110}"><?php echo $lable['houseid']; ?></th>
                        <th lay-data="{field:'title',width:230}"><?php echo $lable['title']; ?></th>
                        <th lay-data="{field:'address',width:220}"><?php echo $lable['address']; ?></th>
                        <th lay-data="{field:'price',width:120}"><?php echo $lable['rentp']; ?></th>
                        <th lay-data="{field:'collection',width:70}"><?php echo $lable['like']; ?></th>
                        <th lay-data="{field:'view',width:70}"><?php echo $lable['view']; ?></th>
                        <th lay-data="{field:'statuss',width:70}"><?php echo $lable['status']; ?></th>
                        <?php if($offable == true): ?>
                        <th lay-data="{field:'status',templet: '#status',width:110}"><?php echo $lable['shangxiaxian']; ?></th>
                        <?php endif; ?>
                        <th lay-data="{field:'pm' ,width:110}">PM</th>
                        <th lay-data="{field:'corp' ,width:110}">公司</th>
                        <th lay-data="{field:'user_id' ,width:110}">发布人</th>
                        <th lay-data="{field:'cdate',width:120}"><?php echo $lable['updatetime']; ?></th>
                        <th lay-data="{ width:200, toolbar: '#barDemo'}"><?php echo $lable['caozuo']; ?></th>
                    </tr>
                    </thead>
                </table>
            </section>
        </div>
    </div>
</div>
<script type="text/html" id="barDemo">
    <?php if($editable == true): ?>
    <a class="layui-btn layui-btn-xs" lay-event="edit"><?php echo $lable['edit']; ?></a>
    <?php endif; ?>
    <a class="layui-btn layui-btn-xs  layui-btn-warm" lay-event="alert"><?php echo $lable['detail']; ?></a>
    {{#  if(d.status == 1){ }}
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="userTop"><?php echo $lable['top']; ?></a>
    {{#  } }}
</script>
<script type="text/html" id="status">
    <input type="checkbox" name="sex" lay-skin="switch" value="{{d.id}}" lay-text="<?php echo $lable['off']; ?>|<?php echo $lable['on']; ?>" lay-filter="statusDemo" {{ d.status == 1 ? 'checked' : '' }} {{ d.status == 0 ? 'disabled' : '' }} >
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
        form.on('select(bu_p_id)', function(data){
            var city=data.value;
            $.ajax({
                type: 'POST',
                url: "<?=url('house/getarea')?>?city="+city,
                data: {city:city},
                dataType:  'json',
                success: function(data){
                    var code=data.data;
                    console.log(code);
                    $("#bu_c_id").html("<option value=''><?php echo $lable['area']; ?></option>");
                    $.each(code, function(i, val) {
                        var option1 = $("<option>").val(val.area).text(val.area);
                        $("#bu_c_id").append(option1);
                        form.render('select');
                    });
                    $("#bu_c_id").get(0).selectedIndex=0;
                }
            });
        });
        form.on('select(reOrder)', function(data){
            console.log(data);
            var order = data.value;
            var keywords = $('#keywords').val();
            var keytype = $('#keytype').val();
            var city = $('#city').val();
            var status = $('#statu').val();
            var area = $('#bu_c_id').val();
            var time = $('#time').val();
            table.reload('testReload', {
                url: '/xcx/house/myData/'
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    keywords: keywords,
                    keytype: keytype,
                    order: order,
                    city: city,
                    area: area,
                    status: status,
                    time: time
                },
                success:function (data) {
                    console.log(data);
                }
            });
        });
        //监听是否开启操作
        form.on('switch(statusDemo)', function(obj){
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
                url: "<?=url('house/onstatus')?>?id="+id+ "&change="+change,
                dataType:  'json',
                success: function(data){
                    layer.msg(data.msg,{
                        time: 1500
                    },function () {
                        location.reload();
                    });
                }
            });
        });
        var $ = layui.$, active = {
            getCheckData: function(){ //获取选中数据
                var ids = '';
                var checkStatus = table.checkStatus('testReload')
                    ,data = checkStatus.data;
                if(data.length <= 0){
                    layer.msg('请至少选择一条记录！');
                }else{
                    layer.confirm('<?php echo $lable['deleteConfirm']; ?>', {
                        btn : [ '<?php echo $lable['sure']; ?>', '<?php echo $lable['cancel']; ?>' ]//按钮
                    }, function() {
                        for(var i=0;i<data.length;i++){
                            ids+=','+checkStatus.data[i].id;
                        }
                        $.ajax({
                            type: 'POST',
                            url: "<?=url('house/delBatch')?>?ids="+ids,
                            data: {ids:ids},
                            dataType:  'json',
                            success: function(data){
                                if(data.code == '1'){
                                    layer.alert('<?php echo $lable['deleteSuc']; ?>！', {
                                        icon: 1,
                                        skin: 'layer-ext-moon',
                                        time: 2000,
                                        end: function(){
                                            window.location.href='<?=url("house/myhouse")?>';
                                        }
                                    });
                                }
                            }
                        });
                    },function(){
                        layer.msg('<?php echo $lable['quxiaocaozuo']; ?>！');
                    });
                }
            },
            reload: function(){
                var keywords = $('#keywords').val();
                var keytype = $('#keytype').val();
                var city = $('#city').val();
                var status = $('#statu').val();
                var area = $('#bu_c_id').val();
                var time = $('#time').val();
                table.reload('testReload', {
                    url: '/xcx/house/myData/'
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,where: {
                        keywords: keywords,
                        keytype: keytype,
                        city: city,
                        area: area,
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
                window.location.href='<?=url("house/edit")?>?id='+id+'&type=2';
            }else if(obj.event === 'alert'){
                layer.open({
                    type: 2,
                    title: '<?php echo $lable['details']; ?>',
                    shadeClose: true,
                    shade: false,
                    maxmin: true,
                    area: ['80%', '80%'],
                    content: "<?=url('house/detail')?>?id="+id
                });
            }else if(obj.event === 'tags'){
                window.location.href='<?=url("house/tags")?>?id='+id;
            }else if(obj.event === 'userTop'){
                $.ajax({
                    'type':"get",
                    'url':"<?=url('house/usertop')?>",
                    'data':{id:id},
                    'success':function (result) {
                        console.log(result);
                        if(result.code < 1){
                            layer.msg(result.msg);
                        }else {
                            layer.msg(result.msg);
                            layer.open({
                                title: '<?php echo $lable['info']; ?>'
                                ,content: result.msg
                                ,yes: function(index){
                                    layer.close(index);
                                    window.location.href='<?=url("house/myhouse")?>';
                                }
                                ,cancel:function (index) {
                                    layer.close(index);
                                    window.location.href='<?=url("house/myhouse")?>';
                                }
                            });
                        }
                    },
                    'error':function () {
                        console.log('error');
                    }
                })
            }
        });
    });
    function addArt() {
        window.location.href='<?=url("house/add")?>?typess=1';
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