<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:89:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\house\add.html";i:1587611054;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1587553386;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1583744281;}*/ ?>
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
    <link rel="stylesheet" href="../../../layui/src/autocomplete/selectpage.css">
    <script src="../../../static/jquery-1.10.2.min.js"></script>
    <script src="../../../layui/src/layui.js"></script>
    <script src="../../../layui/src/autocomplete/selectpage.js"></script>
	<style>
		.layui-body{
			left:0!important
		}
	</style>
</head>
<body class="layui-layout-body" style="height: 100%">

<style>
    .one-pan{
        position: relative;
    }
    .one{
        position: absolute;
        left:300px;
        top:0;
    }
     .layui-upload-img { width: 90px; height: 90px; margin: 0; }
    .pic-more { width:100%; left; margin: 10px 0px 0px 0px;}
    .pic-more li { width:300px; float: left; margin-right: 5px;margin-top: 10px;}
    .pic-more li .layui-input { display: initial; }
    .pic-more li a { position: absolute; top: 0; display: block; }
    #slide-pc-priview .item_img img{ width:277px; height: 177px}
    #slide-pc-priview li{position: relative;}
    #slide-pc-priview li .operate{ color: #000; display: none;}
    #slide-pc-priview li .toleft{ position: absolute;top: 40px; left: 1px; cursor:pointer;}
    #slide-pc-priview li .toright{ position: absolute;top: 40px; right: 1px;cursor:pointer;}
    #slide-pc-priview li .close{position: absolute;top: 5px; right: 5px;cursor:pointer;}
    #slide-pc-priview li:hover .operate{ display: block;}
</style>
<div class="layui-body">
    <div style="margin: 20px;">
    <span class="layui-breadcrumb" lay-separator=">">
       <a>房源管理</a>
        <a href="<?=url('house/index')?>">房源列表</a>
        <a><cite>发布房源</cite></a>
    </span>
        <div style="float:right;">
            <a href="<?=url('house/index')?>" class="layui-btn layui-btn-primary layui-btn-sm">
                <i class="layui-icon layui-icon-return"></i>
                返回列表</a>
        </div>
    </div>
    <hr/>
<div style="margin: 10px">
    <div style="padding: 15px;">
        <form class="layui-form" action="<?=url('house/add')?>" method="post">
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>基础信息</legend>
            </fieldset>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>房源名称</label>
                <div class="layui-input-block">
                    <input type="text" name="title" lay-verify="required|title" placeholder="请输入房源名称" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>地址</label>
                <div class="layui-input-block" id="input">
                    <input type="text" name="address" id="end" autocomplete="off" class="layui-input" placeholder="目的地">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>房源链接</label>
                <div class="layui-input-block">
                    <input type="text" name="http" lay-verify="required|title" placeholder="请输入房源链接" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>租金</label>
                <div class="layui-input-block">
                    <input type="text" name="price" lay-verify="required|title" placeholder="请输入租金" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>基础信息</label>
                <div class="layui-input-inline">
                    <select name="city" lay-verify="required" lay-filter="bu_p_id">
                        <option value="">请选择城市</option>
                        <?php if(is_array($city) || $city instanceof \think\Collection || $city instanceof \think\Paginator): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select name="school" lay-verify="required" id="school">
                        <option value="">请选择校区</option>
                    </select>
                </div>
            </div>
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>租约相关</legend>
            </fieldset>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>入住时间</label>
                <div class="layui-input-inline">
                    <input type="text" name="live_date" id="date" lay-verify="date" lay-verify="required" placeholder="请选择入住时间" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-input-inline">
                    <input type="checkbox" name="open" lay-skin="switch" lay-filter="switchTest" lay-text="随时|限时">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>房屋来源</label>
                <div class="layui-input-block">
                    <input type="radio" name="source" value="中介" title="中介" checked>
                    <input type="radio" name="source" value="个人" title="个人">
                    <input type="radio" name="source" value="学生公寓" title="学生公寓">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>出租方式</label>
                <div class="layui-input-block">
                    <input type="radio" name="type" value="整租" title="整租" checked>
                    <input type="radio" name="type" value="单间" title="单间">
                    <input type="radio" name="type" value="厅卧" title="厅卧">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>性别限制</label>
                <div class="layui-input-block">
                    <input type="radio" name="sex" value="男女不限" title="男女不限" checked>
                    <input type="radio" name="sex" value="限男性" title="限男性">
                    <input type="radio" name="sex" value="限女性" title="限女性">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>宠物</label>
                <div class="layui-input-block">
                    <input type="radio" name="pet" value="接受" title="接受" checked>
                    <input type="radio" name="pet" value="不接受" title="不接受">
                </div>
            </div>
            <div class="layui-form-item" pane="">
                <label class="layui-form-label">Bill相关</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="bill[包水]" lay-skin="primary" title="包水">
                    <input type="checkbox" name="bill[包电]" lay-skin="primary" title="包电">
                    <input type="checkbox" name="bill[包气]" lay-skin="primary" title="包气">
                    <input type="checkbox" name="bill[包网]" lay-skin="primary" title="包网">
                </div>
            </div>
            <div class="layui-form-item" pane="">
                <label class="layui-form-label">租期</label>
                <div class="layui-input-block">
                    <input type="radio" name="lease_term" value="灵活" title="灵活" checked>
                    <input type="radio" name="lease_term" value="1周起租" title="1周起租">
                    <input type="radio" name="lease_term" value="1个月起租" title="1个月起租">
                    <input type="radio" name="lease_term" value="3个月起租" title="3个月起租">
                    <input type="radio" name="lease_term" value="6个月起租" title="6个月起租">
                    <input type="radio" name="lease_term" value="12个月起租" title="12个月起租">
                </div>
            </div>
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>房屋相关</legend>
            </fieldset>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>房屋类型</label>
                <div class="layui-input-block">
                    <input type="radio" name="house_type" value="公寓" title="公寓" checked>
                    <input type="radio" name="house_type" value="别墅" title="别墅">
                    <input type="radio" name="house_type" value="其他" title="其他">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>户型</label>
                <div class="layui-input-block">
                    <input type="radio" name="house_room" value="一室" title="一室" checked>
                    <input type="radio" name="house_room" value="两室" title="两室">
                    <input type="radio" name="house_room" value="三室" title="三室">
                    <input type="radio" name="house_room" value="四室" title="四室">
                    <input type="radio" name="house_room" value="四室以上" title="四室以上">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>卫生间</label>
                <div class="layui-input-block">
                    <input type="radio" name="toilet" value="0" title="0" checked>
                    <input type="radio" name="toilet" value="1" title="1">
                    <input type="radio" name="toilet" value="2" title="2">
                    <input type="radio" name="toilet" value="3" title="3">
                    <input type="radio" name="toilet" value="4" title="4">
                    <input type="radio" name="toilet" value="5" title="5">
                    <input type="radio" name="toilet" value="6" title="6">
                    <input type="radio" name="toilet" value="7" title="7">
                    <input type="radio" name="toilet" value="8" title="8">
                    <input type="radio" name="toilet" value="9" title="9">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>家具</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="furniture[床]" lay-skin="primary" title="床">
                    <input type="checkbox" name="furniture[沙发]" lay-skin="primary" title="沙发">
                    <input type="checkbox" name="furniture[餐桌]" lay-skin="primary" title="餐桌">
                    <input type="checkbox" name="furniture[椅子]" lay-skin="primary" title="椅子">
                    <input type="checkbox" name="furniture[WIFI]" lay-skin="primary" title="WIFI">
                    <input type="checkbox" name="furniture[空调]" lay-skin="primary" title="空调">
                    <input type="checkbox" name="furniture[洗衣机]" lay-skin="primary" title="洗衣机">
                    <input type="checkbox" name="furniture[冰箱]" lay-skin="primary" title="冰箱">
                    <input type="checkbox" name="furniture[微波炉]" lay-skin="primary" title="微波炉">
                    <input type="checkbox" name="furniture[暖气]" lay-skin="primary" title="暖气">
                    <input type="checkbox" name="furniture[电烤箱]" lay-skin="primary" title="电烤箱">
                    <input type="checkbox" name="furniture[洗碗机]" lay-skin="primary" title="洗碗机">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>车位</label>
                <div class="layui-input-block">
                    <input type="radio" name="car" value="0" title="0" checked>
                    <input type="radio" name="car" value="1" title="1">
                    <input type="radio" name="car" value="2" title="2">
                    <input type="radio" name="car" value="3" title="3">
                    <input type="radio" name="car" value="4" title="4">
                    <input type="radio" name="car" value="5" title="5">
                    <input type="radio" name="car" value="6" title="6">
                    <input type="radio" name="car" value="7" title="7">
                    <input type="radio" name="car" value="8" title="8">
                    <input type="radio" name="car" value="9" title="9">
                </div>
            </div>
            <div class="layui-form-item" pane="">
                <label class="layui-form-label">设施</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="home[游泳池]" lay-skin="primary" title="游泳池">
                    <input type="checkbox" name="home[健身房]" lay-skin="primary" title="健身房">
                    <input type="checkbox" name="home[停车位]" lay-skin="primary" title="停车位">
                    <input type="checkbox" name="home[电影院]" lay-skin="primary" title="电影院">
                    <input type="checkbox" name="home[花园]" lay-skin="primary" title="花园">
                </div>
            </div>

            <div class="layui-form-item" pane="">
                <label class="layui-form-label">交通</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="sation[巴士站]" lay-skin="primary" title="巴士站">
                    <input type="checkbox" name="sation[火车站]" lay-skin="primary" title="火车站">
                    <input type="checkbox" name="sation[地铁站]" lay-skin="primary" title="地铁站">
                </div>
            </div>
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>联系方式</legend>
            </fieldset>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>姓名</label>
                <div class="layui-input-block">
                    <input type="text" name="real_name" lay-verify="required|title" placeholder="请输入姓名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>电话</label>
                <div class="layui-input-block">
                    <input type="text" name="tel" lay-verify="required|phone" placeholder="请输入电话" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>微信号</label>
                <div class="layui-input-block">
                    <input type="text" name="wchat" lay-verify="required|title" placeholder="请输入微信号" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>邮箱</label>
                <div class="layui-input-block">
                    <input type="text" name="email" lay-verify="required|email" placeholder="请输入邮箱" autocomplete="off" class="layui-input">
                </div>
            </div>
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>图片和视频</legend>
            </fieldset>
            <div class="layui-form-item" id="pics">
                <div class="layui-form-label">房源图片</div>
                <div class="layui-input-block" style="width: 70%;">
                    <div class="layui-upload">
                        <button type="button" class="layui-btn layui-btn pull-left" id="slide-pc">选择多图</button>
                        <div class="pic-more">
                            <ul class="pic-more-upload-list" id="slide-pc-priview">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="layui-form-mid layui-word-aux">请上传1-8张图片，默认第一个为封面图。</div>
            </div>
            <div class="layui-form-item one-pan">
                <label class="layui-form-label">房源视频</label>
                <div class="layui-upload-drag" id="uploadLogo">
                    <video id="logoPre">
                        <input type="hidden" name="video" id="video" value=""/>
                    </video>
                    <div id="display">
                        <i class="layui-icon"></i>
                        <p>请点击此处上传房源视频</p>
                    </div>
                </div>
                <br/>
                <div class="layui-form-mid layui-word-aux">视频仅限一个视频，大小控制在10M以内。</div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">房源简介</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入房源简介" name="content" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit>发布</button>
                    <a class="layui-btn layui-btn-primary" href="<?=url('house/index')?>">返回</a>
                </div>
            </div>
        </form>

    </div>
</div>
<script>
    layui.link('/layui/src/autocomplete/autocomplete.css');
    layui.config({
        base: '/layui/src/autocomplete/'
        , version: false,
        debug: false,
    });
    layui.use(['form', 'jquery','upload','laydate', 'autocomplete'], function(){
        var form = layui.form
            ,upload = layui.upload
            , laydate = layui.laydate
            ,$ = layui.jquery,
            autocomplete = layui.autocomplete;

        autocomplete.render({
            elem: $('#end'),
            cache: true,
            url:"<?=url('house/getAdd')?>",
            response: {code: 'code', data: 'data'},
            template_val: '{{d.name}}',
            template_txt: '{{d.name}}',
            onselect: function (resp) {
                console.log(resp);
                $('#content1').html("NEW RENDER: " + JSON.stringify(resp));
            }
        });
        let APP_ID_HERE = "QuHxU6ypXzp37Dci84o8";
        let APP_CODE_HERE = "TDu_enlm0QIblRnIl33buw";

        function addressAC(query, callback) {
            console.log(query);
            $.getJSON("https://autocomplete.geocoder.api.here.com/6.2/suggest.json?query=" + query.term + "&app_id=" + APP_ID_HERE + "&app_code=" + APP_CODE_HERE+ "&country=AUS", function (data) {
                var addresses = data.suggestions;
                addresses = addresses.map(addr => {
                    return {
                        title: addr.label.split(",").reverse().join().trim(),
                        value: addr.label.split(",").reverse().join().trim(),
                        id: addr.locationId
                    };
                });

                return callback(addresses);
            });
        }
        //日期
        laydate.render({
            elem: '#date'
        });
        //监听指定开关
        form.on('switch(switchTest)', function(data){
            if(this.checked){
                $('#date').val('');
                $('#date').hide();
            }else{
                $('#date').show();
            }
        });
        //自定义验证规则
        form.verify({
            title: function(value){
                if(value.length < 2){
                    return '标题至少得2个字符啊';
                }
            }
            ,imgRegCaseType:function (value) {
                if(value.length <= 0){
                    return '请上传户型图';
                }
            }
            ,urlTest:function(value){
                if(value.length >0 ){
                    var Expression=/http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
                    if(Expression.test(value)){
                    }else{
                        return "请输入正确的链接！";
                    }
                }
            }
            ,des_tanlent:function () {
                if (!$(".h_config").is(":checked")) {
                    return "一个房屋配置都没有嘛？";
                }
            }
        });
        form.on('select(bu_p_id)', function(data){
            console.log(data.elem); //得到select原始DOM对象
            console.log(data.value); //得到被选中的值
            console.log(data.date); //得到美化后的DOM对象
            var id=data.value;
            $.ajax({
                type: 'POST',
                url: "<?=url('house/getSchool')?>",
                data: {id:id},
                dataType:  'json',
                success: function(data){
                    console.log(data);
                    var code=data.data;
                    $("#school").html("<option value=''>请选择校区</option>");
                    $.each(code, function(i, val) {
                        var option1 = $("<option>").val(val.name).text(val.name);
                        $("#school").append(option1);
                        form.render('select');
                    });
                    $("#school").get(0).selectedIndex=0;
                }
            });
        });
        //户型图片上传
        upload.render({
            elem: '#uploadLogo'
            ,url: '<?php echo url("house/upload"); ?>'
            ,size:10240 //限制文件大小，单位 KB
            ,ext: 'mp4'
            ,accept: 'video' //限制文件大小，单位 KB
            ,before: function(input){
                loading = layer.load(2, {
                    shade: [0.2,'#000']
                });
            }
            ,done: function(res){
                $('#logoPre').removeAttr('src');
                $('#video').val('');
                console.log(res);
                layer.close(loading);
                $('#video').val(res.filepath);
                $('#uploadLogo').removeClass('layui-upload-drag');
                $('#logoPre').css('width','216px');
                $('#logoPre').css('height','150px');
                $('#logoPre').attr('src',"../../../"+res.filepath);
                $('#display').hide();
                layer.msg(res.msg, {icon: 1, time: 1000});
            }
            ,error: function(res){
                layer.msg(res.msg, {icon: 2, time: 1000});
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
<script>
    layui.use('upload', function(){
        var $ = layui.jquery;
        var upload = layui.upload;
        upload.render({
            elem: '#slide-pc',
            url: '<?php echo url("house/upload"); ?>',
            size: 5120,
            exts: 'jpg|png|jpeg',
            multiple: true,
            before: function(obj) {
                layer.msg('图片上传中...', {
                    icon: 16,
                    shade: 0.01,
                    time: 0
                })
            },
            done: function(res) {
                layer.close(layer.msg());//关闭上传提示窗口
                if(res.status == 0) {
                    return layer.msg(res.message);
                }
                console.log(res);
                $('#slide-pc-priview').append('' +
                    '<li class="item_img"><div class="operate"><i  class="close layui-icon"></i></div><img src="../../../' + res.filepath + '" class="img" ><input type="hidden" name="images[]" value="' + res.filepath + '" /></li>');
            }
        });
    });
    //点击多图上传的X,删除当前的图片
    $("body").on("click",".close",function(){
        $(this).closest("li").remove();
    });
</script>