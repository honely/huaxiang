<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:90:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\house\edit.html";i:1591343167;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591172124;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1583744281;}*/ ?>
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
    .item_img img{ width:277px; height: 177px}
</style>
<div class="layui-body">
    <div style="margin: 20px;">
    <span class="layui-breadcrumb" lay-separator=">">
       <a>房源管理</a>
        <?php if($type == 1): ?>
         <a href="<?=url('house/index')?>">房源列表</a>
        <?php else: ?>
         <a href="<?=url('house/myhouse')?>">我的房源</a>
        <?php endif; ?>
        <a><cite>修改房源</cite></a>
    </span>
        <div style="float:right;">
            <a href="javascript:history.go(-1);" class="layui-btn layui-btn-primary layui-btn-sm">
                <i class="layui-icon layui-icon-return"></i>
                返回列表</a>
        </div>
    </div>
    <hr/>
    <div style="margin: 10px">
        <div style="padding: 15px;">
            <form class="layui-form" action="<?=url('house/edit')?>?id=<?php echo $house['id']; ?>&type=<?php echo $type; ?>" method="post">
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend>基础信息</legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>房源名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" lay-verify="required|title" placeholder="请输入房源名称" maxlength="50"  autocomplete="off" value="<?php echo $house['title']; ?>" class="layui-input">
                        <input type="hidden" value="<?php echo $house['id']; ?>" id="id" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>地址</label>
                    <div class="layui-input-block" id="input">
                        <input type="text" name="address" id="end" autocomplete="off" class="layui-input" placeholder="请注入地址" value="<?php echo $house['address']; ?>" >
                        <input type="hidden" name="x" id="x" autocomplete="off" class="layui-input" value="<?php echo $house['x']; ?>" >
                        <input type="hidden" name="y" id="y" autocomplete="off" class="layui-input" value="<?php echo $house['y']; ?>" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">房源链接</label>
                    <div class="layui-input-block">
                        <input type="text" name="http"  placeholder="请输入房源链接" autocomplete="off" value="<?php echo $house['http']; ?>" class="layui-input" id="orderHouse" onblur="checkHouseUrl()">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>租金</label>
                    <div class="layui-input-block">
                        <input type="number" name="price" lay-verify="required|title" placeholder="请输入租金" autocomplete="off" value="<?php echo $house['price']; ?>" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>城市校区</label>
                    <div class="layui-input-inline">
                        <select name="city" lay-verify="required" lay-filter="bu_p_id">
                            <option value="">请选择城市</option>
                            <?php if(is_array($city) || $city instanceof \think\Collection || $city instanceof \think\Paginator): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vo['id']; ?>" <?php if($house['city'] == $vo['name']): ?>selected<?php endif; ?>><?php echo $vo['name']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <select name="school" lay-verify="required" id="school">
                            <option value="">请选择校区</option>
                            <?php if(is_array($school) || $school instanceof \think\Collection || $school instanceof \think\Paginator): $i = 0; $__LIST__ = $school;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vo['name']; ?>" <?php if($house['school'] == $vo['name']): ?>selected<?php endif; ?>><?php echo $vo['name']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend>租约相关</legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>入住时间</label>
                    <div class="layui-input-inline">

                        <input type="text" name="live_date" id="date" lay-verify="date" lay-verify="required" style="display:<?php if($house['live_date_show'] == 1): ?>none<?php else: ?>block<?php endif; ?>" placeholder="请选择入住时间" value="<?php echo $house['live_date']; ?>" autocomplete="off" class="layui-input">

                    </div>
                    <div class="layui-input-inline">
                        <input type="checkbox" lay-skin="switch" lay-filter="switchTest" lay-text="随时|随时" <?php if($house['live_date_show'] == 1): ?>checked<?php else: endif; ?> >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>房屋来源</label>
                    <div class="layui-input-block">
                        <input type="radio" name="source" value="中介" title="中介" <?php if($house['source'] == '中介'): ?>checked<?php endif; ?>>
                        <input type="radio" name="source" value="学生公寓" title="学生公寓" <?php if($house['source'] == '学生公寓'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>出租方式</label>
                    <div class="layui-input-block">
                        <input type="radio" name="type" value="整租" title="整租" <?php if($house['type'] == '整租'): ?>checked<?php endif; ?>>
                        <input type="radio" name="type" value="单间" title="单间" <?php if($house['type'] == '单间'): ?>checked<?php endif; ?>>
                        <input type="radio" name="type" value="厅卧" title="厅卧" <?php if($house['type'] == '厅卧'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>性别限制</label>
                    <div class="layui-input-block">
                        <input type="radio" name="sex" value="男女不限" title="男女不限" <?php if($house['sex'] == '男女不限'): ?>checked<?php endif; ?>>
                        <input type="radio" name="sex" value="限男性" title="限男性" <?php if($house['sex'] == '限男性'): ?>checked<?php endif; ?>>
                        <input type="radio" name="sex" value="限女性" title="限女性" <?php if($house['sex'] == '限女性'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>宠物</label>
                    <div class="layui-input-block">
                        <input type="radio" name="pet" value="接受" title="接受" <?php if($house['pet'] == '接受'): ?>checked<?php endif; ?>>
                        <input type="radio" name="pet" value="不接受" title="不接受" <?php if($house['pet'] == '不接受'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">Bill相关</label>
                    <div class="layui-input-block">
                        <?php if(is_array($all_bill) || $all_bill instanceof \think\Collection || $all_bill instanceof \think\Paginator): $i = 0; $__LIST__ = $all_bill;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" lay-skin="primary" name="bill[<?php echo $vo['bill']; ?>]" title="<?php echo $vo['bill']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">租期</label>
                    <div class="layui-input-block">

                        <input type="radio" name="lease_term" value="12个月起租" title="12个月起租" <?php if($house['lease_term'] == '12个月起租'): ?>checked<?php endif; ?>>

                        <input type="radio" name="lease_term" value="6个月起租" title="6个月起租" <?php if($house['lease_term'] == '6个月起租'): ?>checked<?php endif; ?>>

                        <input type="radio" name="lease_term" value="3个月起租" title="3个月起租" <?php if($house['lease_term'] == '3个月起租'): ?>checked<?php endif; ?>>

                        <input type="radio" name="lease_term" value="1个月起租" title="1个月起租" <?php if($house['lease_term'] == '1个月起租'): ?>checked<?php endif; ?>>


                        <input type="radio" name="lease_term" value="1周起租" title="1周起租" <?php if($house['lease_term'] == '1周起租'): ?>checked<?php endif; ?>>
                        <input type="radio" name="lease_term" value="灵活" title="灵活" <?php if($house['lease_term'] == '灵活'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend>房屋相关</legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>户型</label>
                    <div class="layui-input-block">
                        <input type="radio" name="house_room" value="一室" title="一室" <?php if($house['house_room'] == '一室'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" value="两室" title="两室" <?php if($house['house_room'] == '两室'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" value="三室" title="三室" <?php if($house['house_room'] == '三室'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" value="四室" title="四室" <?php if($house['house_room'] == '四室'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" value="四室以上" title="四室以上" <?php if($house['house_room'] == '四室以上'): ?>checked<?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>卫生间</label>
                    <div class="layui-input-block">
                        <input type="radio" name="toilet" value="0" title="0" <?php if($house['toilet'] == '0'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" value="1" title="1" <?php if($house['toilet'] == '1'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" value="2" title="2" <?php if($house['toilet'] == '2'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" value="3" title="3" <?php if($house['toilet'] == '3'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" value="4" title="4" <?php if($house['toilet'] == '4'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" value="5" title="5" <?php if($house['toilet'] == '5'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" value="6" title="6" <?php if($house['toilet'] == '6'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" value="7" title="7" <?php if($house['toilet'] == '7'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" value="8" title="8" <?php if($house['toilet'] == '8'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" value="9" title="9" <?php if($house['toilet'] == '9'): ?>checked<?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>家具</label>
                    <div class="layui-input-block">
                        <?php if(is_array($all_four) || $all_four instanceof \think\Collection || $all_four instanceof \think\Paginator): $i = 0; $__LIST__ = $all_four;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" lay-skin="primary" name="home[<?php echo $vo['furn']; ?>]" title="<?php echo $vo['furn']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>车位</label>
                    <div class="layui-input-block">
                        <input type="radio" name="car" value="0" title="0" <?php if($house['car'] == '0'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" value="1" title="1" <?php if($house['car'] == '1'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" value="2" title="2" <?php if($house['car'] == '2'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" value="3" title="3" <?php if($house['car'] == '3'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" value="4" title="4" <?php if($house['car'] == '4'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" value="5" title="5" <?php if($house['car'] == '5'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" value="6" title="6" <?php if($house['car'] == '6'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" value="7" title="7" <?php if($house['car'] == '7'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" value="8" title="8" <?php if($house['car'] == '8'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" value="9" title="9" <?php if($house['car'] == '9'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">楼宇设施</label>
                    <div class="layui-input-block">
                        <?php if(is_array($all_set) || $all_set instanceof \think\Collection || $all_set instanceof \think\Paginator): $i = 0; $__LIST__ = $all_set;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" lay-skin="primary" name="furniture[<?php echo $vo['set']; ?>]" title="<?php echo $vo['set']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>

                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">周边</label>
                    <div class="layui-input-block">
                        <?php if(is_array($all_trans) || $all_trans instanceof \think\Collection || $all_trans instanceof \think\Paginator): $i = 0; $__LIST__ = $all_trans;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" lay-skin="primary" name="sation[<?php echo $vo['trans']; ?>]" title="<?php echo $vo['trans']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">特色</label>
                    <div class="layui-input-block">
                        <?php if(is_array($tags) || $tags instanceof \think\Collection || $tags instanceof \think\Paginator): $i = 0; $__LIST__ = $tags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox tags"  lay-verify="required|des_tanlent" lay-skin="primary" name="tags[<?php echo $vo['name']; ?>]" title="<?php echo $vo['name']; ?>" <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend>联系方式</legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>姓名</label>
                    <div class="layui-input-block">
                        <input type="text" name="real_name" lay-verify="required|title" placeholder="请输入姓名" value="<?php echo $house['real_name']; ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>电话</label>
                    <div class="layui-input-block">
                        <input type="text" name="tel" lay-verify="required" placeholder="请输入电话" value="<?php echo $house['tel']; ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">微信号</label>
                    <div class="layui-input-block">
                        <input type="text" name="wchat" placeholder="请输入微信号" value="<?php echo $house['wchat']; ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">邮箱</label>
                    <div class="layui-input-block">
                        <input type="text" name="email" lay-verify="emails" placeholder="请输入邮箱" value="<?php echo $house['email']; ?>" autocomplete="off" class="layui-input">
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
                                    <?php if($house['images'] != null): if(is_array($house['images1']) || $house['images1'] instanceof \think\Collection || $house['images1'] instanceof \think\Paginator): $k = 0; $__LIST__ = $house['images1'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($k % 2 );++$k;?>
                                    <li class="item_img">
                                        <div class="operate">
                                            <i class="close layui-icon"></i>
                                        </div>
                                        <img src="../../../<?php echo $item; ?>" class="img" >
                                        <input type="hidden" name="images[]" value="<?php echo $item; ?>" class="img_url" lay-verify="required|imgRegCaseType" />
                                    </li>
                                    <?php endforeach; endif; else: echo "" ;endif; else: ?>
                                    未上传
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-mid layui-word-aux">请上传1-8张图片，默认第一个为封面图。</div>
                </div>
                <div class="layui-form-item one-pan">
                    <label class="layui-form-label">房源视频</label>
                    <ul class="pic-more-upload-list" id="slide-pc-priview1">
                        <?php if($house['video'] != null): ?>
                        <li class="item_img">
                            <div class="operate">
                                <i class="close layui-icon"></i>
                            </div>
                            <video style="width:277px; height: 177px" class="item_img" controls="controls" autobuffer="autobuffer" id="videoss" loop="loop" src="../../../<?php echo $house['video']; ?>" class="img" ></video>
                            <input type="hidden" name="video" id="video" value="<?php echo $house['video']; ?>" />
                        </li>
                        <?php else: ?>
                        未上传
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <span class="layui-btn" id="uploadLogo">更新视频</span>
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">房源简介</label>
                    <div class="layui-input-block">
                        <textarea placeholder="请输入房源简介" maxlength="500" name="content" class="layui-textarea"><?php echo $house['content']; ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit>发布</button>
                        <a class="layui-btn layui-btn-primary" href="javascript:history.go(-1);">返回</a>
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
        layui.use(['form', 'jquery','upload','laydate','autocomplete'], function(){
            var form = layui.form
                ,upload = layui.upload
                , laydate = layui.laydate
                ,autocomplete = layui.autocomplete
                ,$ = layui.jquery;
            autocomplete.render({
                elem: $('#end'),
                cache: true,
                response: {code: 'code', data: 'suggestions'},
                template_val: '{{d.label}}',
                template_txt: '{{d.label}}',
                onselect: function (resp) {
                    var address = resp.label;
                    locationAD(address);
                }
            });
            let APP_ID_HERE = "QuHxU6ypXzp37Dci84o8";
            let APP_CODE_HERE = "TDu_enlm0QIblRnIl33buw";
            function locationAD(query) {
                $.getJSON("https://geocoder.api.here.com/6.2/geocode.json?gen=9&searchtext=" + query + "&app_id=" + APP_ID_HERE + "&app_code=" + APP_CODE_HERE, function (data) {
                    console.log(data);
                    var lati = data["Response"]["View"][0]["Result"][0]["Location"]["DisplayPosition"]["Latitude"];
                    var longi = data["Response"]["View"][0]["Result"][0]["Location"]["DisplayPosition"]["Longitude"];
                    $('#x').val(lati);
                    $('#y').val(longi);
                });
            }
            //日期
            laydate.render({
                elem: '#date'
            });
            //监听指定开关
            //监听指定开关
            form.on('switch(switchTest)', function(data){
                if(this.checked){
                    $('#date').val('0000-00-00');
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
                ,imgRegCaseType:function () {
                    var len = $(".img_url").length;
                    if (len > 8) {
                        return "房源图片不超过8个？";
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
                    var len = $(".tags:checked").length;
                    if (len > 6) {
                        return "房源标签选择数不超过6个？";
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
                    $('#video').val('');
                    console.log(res);
                    layer.close(loading);
                    $('#video').val(res.filepath);
                    $('#videoss').css('width','216px');
                    $('#videoss').css('height','150px');
                    $('#videoss').attr('src',"../../../"+res.filepath);
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
        function checkHouseUrl(){
            var order_id = $('#orderHouse').val();
            var id = $('#id').val();
            if(order_id != '') {
                $.ajax({
                    type: "post",
                    url: "<?=url('house/checkHouseUrl')?>",
                    dataType: 'json',
                    data: {'order_id': order_id, 'id': id},
                    success: function (data) {
                        console.log(data);
                        if (data.code > 1) {
                            layer.alert(data.msg, {icon: 2});
                        } else if (data.code <= 1) {
                            layer.alert(data.msg, {icon: 1, time: 1000});
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                })
            }
        }
        layui.use('upload', function(){
            var $ = layui.jquery;
            var upload = layui.upload;
            upload.render({
                elem: '#slide-pc',
                url: '<?php echo url("house/upload"); ?>',
                size: 1024*1024*10,
                exts: 'jpg|png|jpeg|gif|bmp|JPG',
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
                        '<li class="item_img"><div class="operate"><i  class="close layui-icon"></i></div><img src="../../../' + res.filepath + '" class="img" ><input type="hidden" name="images[]" lay-verify="required|imgRegCaseType"  class="img_url"  value="' + res.filepath + '" /></li>');
                }
            });
        });
        //点击多图上传的X,删除当前的图片
        $("body").on("click",".close",function(){
            $(this).closest("li").remove();
        });
    </script>