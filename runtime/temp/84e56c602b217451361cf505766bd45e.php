<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:91:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\house\index.html";i:1599027995;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
        <a><cite><?php echo $lable['houselist']; ?></cite></a>
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
                                    <option value="5"><?php echo $lable['detail']; ?></option>
                                    <option value="6">公司</option>
                                    <option value="7">PM</option>
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
                            <div class="layui-input-inline">
                                <input type="text" name="time" readonly class="layui-input" id="time">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline" style="width:150px;">
                                <input type="checkbox" id="top" lay-skin="primary" title="<?php echo $lable['top']; ?>" value="否" lay-filter="top123">
                                <input type="checkbox" id="tj" lay-skin="primary" title="<?php echo $lable['tuijian']; ?>" value="否" lay-filter="tj123">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline" >
                                <span class="layui-btn layui-btn-sm " data-type="reload"><?php echo $lable['search']; ?></span>
                                <a href="<?=url('house/index')?>" class="layui-btn layui-btn-warm layui-btn-sm "><?php echo $lable['fresh']; ?></a>
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
                <table lay-skin="line" class="layui-table" lay-filter="demo" lay-data="{height: 'full-200', cellMinWidth:60, url:'/xcx/house/houseData/', limit:50,limits:[50] ,id: 'testReload',page:true}" >
                    <thead>
                    <tr>
                        <th lay-data="{type:'checkbox', width:48}">id</th>
                        <th lay-data="{field:'dsn' ,width:110}"><?php echo $lable['houseid']; ?></th>
                        <th lay-data="{field:'title',width:230}"><?php echo $lable['title']; ?></th>
                        <th lay-data="{field:'address',width:120}"><?php echo $lable['address']; ?></th>
                        <th lay-data="{field:'price',width:120}"><?php echo $lable['rentp']; ?></th>
                        <th lay-data="{field:'type',width:70}">类型</th>
                        <th lay-data="{field:'view',width:70}"><?php echo $lable['view']; ?></th>
                        <?php if($topable == true): ?>
                        <th lay-data="{field:'top', templet: '#top1',width:85}"><?php echo $lable['top']; ?></th>
                        <?php endif; if($tjable == true): ?>
                        <th lay-data="{field:'tj', templet: '#switchTj',width:85}"><?php echo $lable['tuijian']; ?></th>
                        <?php endif; ?>
                        <th lay-data="{field:'statuss',width:70}"><?php echo $lable['status']; ?></th>
                        <th lay-data="{field:'pm' ,width:110}">PM</th>
                        <th lay-data="{field:'corp' ,width:110}">公司</th>
                        <th lay-data="{field:'user_id' ,width:110}">发布人</th>
                        <th lay-data="{field:'cdate',width:105}"><?php echo $lable['updatetime']; ?></th>
                        <?php if($offable == true): ?>
                        <th lay-data="{field:'status',templet: '#status',width:110}"><?php echo $lable['shangxiaxian']; ?></th>
                        <?php endif; ?>
                        <th lay-data="{ width:116, toolbar: '#barDemo'}"><?php echo $lable['caozuo']; ?></th>
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
</script>
<script type="text/html" id="top1">
    <input type="checkbox" name="sex" lay-skin="switch" value="{{d.id}}" lay-text="<?php echo $lable['shi']; ?>|<?php echo $lable['fou']; ?>" lay-filter="topDemo" {{ d.top == '是' ? 'checked' : '' }}  {{ d.isTop == false ? 'disabled' : '' }}  {{ d.status == 0 ? 'disabled' : '' }}>
</script>
<script type="text/html" id="status">
    <input type="checkbox" name="sex" lay-skin="switch" value="{{d.id}}" lay-text="<?php echo $lable['on']; ?>|<?php echo $lable['off']; ?>" lay-filter="statusDemo" {{ d.status == 1 ? 'checked' : '' }}  {{ d.status == 0 ? 'disabled' : '' }}>
</script>
<script type="text/html" id="switchTj">
    <input type="checkbox" name="sex" lay-skin="switch" value="{{d.id}}" lay-text="<?php echo $lable['shi']; ?>|<?php echo $lable['fou']; ?>" lay-filter="sexDemo" {{ d.tj == '是' ? 'checked' : '' }} {{ d.isTj == false ? 'disabled' : '' }}  {{ d.status == 0 ? 'disabled' : '' }}>
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
        form.on('checkbox(top123)', function(data){
            var check = this.checked ? '是' : '否';
            $('#top').val(check);
        });
        form.on('checkbox(tj123)', function(data){
            var check = this.checked ? '是' : '否';
            $('#tj').val(check);
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
            var address = $('#address').val();
            var top = $('#top').val();
            var tj = $('#tj').val();
            var time = $('#time').val();
            table.reload('testReload', {
                url: '/xcx/house/houseData/'
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
                    address: address,
                    top: top,
                    tj: tj,
                    time: time
                },
                success:function (data) {
                    console.log(data);
                }
            });
        });
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
                url: "<?=url('house/status')?>?id="+id+ "&change="+change,
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


        //监听是否开启操作
        form.on('switch(sexDemo)', function(obj){
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
                url: "<?=url('house/tjstatus')?>?id="+id+ "&change="+change,
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
            reload: function(){
                var keywords = $('#keywords').val();
                var keytype = $('#keytype').val();
                var order = $('#order').val();
                var city = $('#city').val();
                var status = $('#statu').val();
                var area = $('#bu_c_id').val();
                var address = $('#address').val();
                var top = $('#top').val();
                var tj = $('#tj').val();
                var time = $('#time').val();
                table.reload('testReload', {
                    url: '/xcx/house/houseData/'
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
                        address: address,
                        top: top,
                        tj: tj,
                        time: time
                    },
                    success:function (data) {
                        console.log(data);
                    }
                });
            },
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
                                            window.location.href='<?=url("house/index")?>';
                                        }
                                    });
                                }
                            }
                        });
                    },function(){
                        layer.msg('<?php echo $lable['quxiaocaozuo']; ?>！');
                    });
                }
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
                window.location.href='<?=url("house/edit")?>?id='+id+'&type=1';
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
            }
        });
    });
    function addArt() {
        window.location.href='<?=url("house/add")?>?typess=2';
    }    function addArt1() {
        window.location.href='<?=url("house/add1")?>';
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