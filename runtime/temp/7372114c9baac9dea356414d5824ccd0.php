<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:92:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\house\detail.html";i:1591182071;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591172124;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1583744281;}*/ ?>
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
    <div style="margin: 10px">
        <div style="padding: 15px;">
            <form class="layui-form" action="<?=url('house/edit')?>?id=<?php echo $house['id']; ?>" method="post">
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend>基础信息</legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>房源名称</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['title']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">房源链接</label>
                    <div class="layui-input-block">
                        <input type="text" readonly value="<?php echo $house['http']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>租金</label>
                    <div class="layui-input-block">
                        <input type="text" readonly value="<?php echo $house['price']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>地址</label>
                    <div class="layui-input-block">
                        <input type="text" readonly value="<?php echo $house['address']; ?>" autocomplete="on" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>城市校区</label>
                    <div class="layui-input-inline">
                        <input type="text" readonly value="<?php echo $house['city']; ?>" class="layui-input">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" readonly value="<?php echo $house['school']; ?>" class="layui-input">
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend>租约相关</legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>入住时间</label>
                    <div class="layui-input-inline">
                        <input type="text" name="live_date" lay-verify="date" lay-verify="required" placeholder="请选择入住时间" value="<?php if($house['live_date_show'] == 1): ?>随时<?php else: ?><?php echo $house['live_date']; endif; ?>" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">时间为澳洲时间</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>房屋来源</label>
                    <div class="layui-input-block">
                        <input type="radio" name="source" disabled value="中介" title="中介" <?php if($house['source'] == '中介'): ?>checked<?php endif; ?>>
                        <input type="radio" name="source" disabled value="学生公寓" title="学生公寓" <?php if($house['source'] == '学生公寓'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>出租方式</label>
                    <div class="layui-input-block">
                        <input type="radio" name="type" disabled value="整租" title="整租" <?php if($house['type'] == '整租'): ?>checked<?php endif; ?>>
                        <input type="radio" name="type" disabled value="单间" title="单间" <?php if($house['type'] == '单间'): ?>checked<?php endif; ?>>
                        <input type="radio" name="type" disabled value="厅卧" title="厅卧" <?php if($house['type'] == '厅卧'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>性别限制</label>
                    <div class="layui-input-block">
                        <input type="radio" name="sex" disabled value="男女不限" title="男女不限" <?php if($house['sex'] == '男女不限'): ?>checked<?php endif; ?>>
                        <input type="radio" name="sex" disabled value="限男性" title="限男性" <?php if($house['sex'] == '限男性'): ?>checked<?php endif; ?>>
                        <input type="radio" name="sex" disabled value="限女性" title="限女性" <?php if($house['sex'] == '限女性'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>宠物</label>
                    <div class="layui-input-block">
                        <input type="radio" name="pet" disabled value="接受" title="接受" <?php if($house['pet'] == '接受'): ?>checked<?php endif; ?>>
                        <input type="radio" name="pet" disabled value="不接受" title="不接受" <?php if($house['pet'] == '不接受'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">Bill相关</label>
                    <div class="layui-input-block">
                        <?php if(is_array($all_bill) || $all_bill instanceof \think\Collection || $all_bill instanceof \think\Paginator): $i = 0; $__LIST__ = $all_bill;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" disabled lay-skin="primary" name="bill[<?php echo $vo['bill']; ?>]" title="<?php echo $vo['bill']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">租期</label>
                    <div class="layui-input-block">

                        <input type="radio" name="lease_term" disabled value="12个月起租" title="12个月起租" <?php if($house['lease_term'] == '12个月起租'): ?>checked<?php endif; ?>>

                        <input type="radio" name="lease_term" disabled value="6个月起租" title="6个月起租" <?php if($house['lease_term'] == '6个月起租'): ?>checked<?php endif; ?>>

                        <input type="radio" name="lease_term" disabled value="3个月起租" title="3个月起租" <?php if($house['lease_term'] == '3个月起租'): ?>checked<?php endif; ?>>

                        <input type="radio" name="lease_term" disabled value="1个月起租" title="1个月起租" <?php if($house['lease_term'] == '1个月起租'): ?>checked<?php endif; ?>>


                        <input type="radio" name="lease_term" disabled value="1周起租" title="1周起租" <?php if($house['lease_term'] == '1周起租'): ?>checked<?php endif; ?>>
                        <input type="radio" name="lease_term" disabled value="灵活" title="灵活" <?php if($house['lease_term'] == '灵活'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend>房屋相关</legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>房屋类型</label>
                    <div class="layui-input-block">
                        <input type="radio" name="house_type" disabled value="公寓" title="公寓" <?php if($house['house_type'] == '公寓'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_type" disabled value="别墅" title="别墅" <?php if($house['house_type'] == '别墅'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_type" disabled value="其他" title="其他" <?php if($house['house_type'] == '其他'): ?>checked<?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>户型</label>
                    <div class="layui-input-block">
                        <input type="radio" name="house_room" value="一室" disabled title="一室" <?php if($house['house_room'] == '一室'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" value="两室" disabled title="两室" <?php if($house['house_room'] == '两室'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" value="三室" disabled title="三室" <?php if($house['house_room'] == '三室'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" value="四室" disabled title="四室" <?php if($house['house_room'] == '四室'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" value="四室以上" disabled title="四室以上" <?php if($house['house_room'] == '四室以上'): ?>checked<?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>卫生间</label>
                    <div class="layui-input-block">
                        <input type="radio" name="toilet" disabled value="0" title="0" <?php if($house['toilet'] == '0'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" disabled value="1" title="1" <?php if($house['toilet'] == '1'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" disabled value="2" title="2" <?php if($house['toilet'] == '2'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" disabled value="3" title="3" <?php if($house['toilet'] == '3'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" disabled value="4" title="4" <?php if($house['toilet'] == '4'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" disabled value="5" title="5" <?php if($house['toilet'] == '5'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" disabled value="6" title="6" <?php if($house['toilet'] == '6'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" disabled value="7" title="7" <?php if($house['toilet'] == '7'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" disabled value="8" title="8" <?php if($house['toilet'] == '8'): ?>checked<?php endif; ?>>
                        <input type="radio" name="toilet" disabled value="9" title="9" <?php if($house['toilet'] == '9'): ?>checked<?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>家具</label>
                    <div class="layui-input-block">
                        <?php if(is_array($all_four) || $all_four instanceof \think\Collection || $all_four instanceof \think\Paginator): $i = 0; $__LIST__ = $all_four;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" disabled lay-skin="primary" name="home[<?php echo $vo['furn']; ?>]" title="<?php echo $vo['furn']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>车位</label>
                    <div class="layui-input-block">
                        <input type="radio" name="car" disabled value="0" title="0" <?php if($house['car'] == '0'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" disabled value="1" title="1" <?php if($house['car'] == '1'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" disabled value="2" title="2" <?php if($house['car'] == '2'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" disabled value="3" title="3" <?php if($house['car'] == '3'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" disabled value="4" title="4" <?php if($house['car'] == '4'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" disabled value="5" title="5" <?php if($house['car'] == '5'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" disabled value="6" title="6" <?php if($house['car'] == '6'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" disabled value="7" title="7" <?php if($house['car'] == '7'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" disabled value="8" title="8" <?php if($house['car'] == '8'): ?>checked<?php endif; ?>>
                        <input type="radio" name="car" disabled value="9" title="9" <?php if($house['car'] == '9'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">楼宇设施</label>
                    <div class="layui-input-block">
                        <?php if(is_array($all_set) || $all_set instanceof \think\Collection || $all_set instanceof \think\Paginator): $i = 0; $__LIST__ = $all_set;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" disabled lay-skin="primary" name="furniture[<?php echo $vo['set']; ?>]" title="<?php echo $vo['set']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>

                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">周边</label>
                    <div class="layui-input-block">
                        <?php if(is_array($all_trans) || $all_trans instanceof \think\Collection || $all_trans instanceof \think\Paginator): $i = 0; $__LIST__ = $all_trans;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" lay-skin="primary" name="sation[<?php echo $vo['trans']; ?>]" title="<?php echo $vo['trans']; ?>" disabled  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">特色</label>
                    <div class="layui-input-block">
                        <?php if(is_array($tags) || $tags instanceof \think\Collection || $tags instanceof \think\Paginator): $i = 0; $__LIST__ = $tags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox tags"  lay-verify="required|des_tanlent" lay-skin="primary" name="tags[<?php echo $vo['name']; ?>]" disabled title="<?php echo $vo['name']; ?>" <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend>联系方式</legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>姓名</label>
                    <div class="layui-input-block">
                        <input type="text" readonly value="<?php echo $house['real_name']; ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>电话</label>
                    <div class="layui-input-block">
                        <input type="text" readonly value="<?php echo $house['tel']; ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>微信号</label>
                    <div class="layui-input-block">
                        <input type="text" readonly value="<?php echo $house['wchat']; ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">邮箱</label>
                    <div class="layui-input-block">
                        <input type="text" readonly value="<?php echo $house['email']; ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend>图片和视频</legend>
                </fieldset>
                <div class="layui-form-item" id="pics">
                    <div class="layui-form-label">房源图片</div>
                    <div class="layui-input-block" style="width: 70%;">
                        <div class="layui-upload">
                            <div class="pic-more">
                                <ul class="pic-more-upload-list" id="slide-pc-priview">
                                    <?php if($house['images'] != null): if(is_array($house['images1']) || $house['images1'] instanceof \think\Collection || $house['images1'] instanceof \think\Paginator): $k = 0; $__LIST__ = $house['images1'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($k % 2 );++$k;?>
                                    <li class="item_img">
                                        <img src="../../../<?php echo $item; ?>" class="img" >
                                        <input type="hidden" name="images[]" value="<?php echo $item; ?>" />
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
                            <video style="width:277px; height: 177px" class="item_img" controls="controls" autobuffer="autobuffer" id="videoss" loop="loop" src="../../../<?php echo $house['video']; ?>" class="img" ></video>
                            <input type="hidden" name="video" id="video" value="<?php echo $house['video']; ?>" />
                        </li>
                        <?php else: ?>
                        未上传
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">房源简介</label>
                    <div class="layui-input-block">
                        <textarea readonly class="layui-textarea"><?php echo $house['content']; ?></textarea>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    layui.use(['form', 'jquery','upload','laydate','layedit'], function(){
        var form = layui.form
            ,upload = layui.upload
            , laydate = layui.laydate
            ,layedit = layui.layedit
            ,$ = layui.jquery;
        //日期
        laydate.render({
            elem: '#date'
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