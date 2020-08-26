<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:92:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\house\detail.html";i:1597370674;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
    .logoPre{
        width: 216px;
        height: 150px;
    }.logoPreimg{
         width: 216px;
         height: 150px;
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
                    <legend><?php echo $lable['basicInfo']; ?></legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['houseName']; ?></label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['title']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><?php echo $lable['houseUrl']; ?></label>
                    <div class="layui-input-block">
                        <input type="text" readonly value="<?php echo $house['http']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['houseAddr']; ?></label>
                    <div class="layui-input-block">
                        <input type="text" readonly value="<?php echo $house['address']; ?>" autocomplete="on" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['city']; ?>&& <?php echo $lable['school']; ?></label>
                    <div class="layui-input-inline">
                        <input type="text" readonly value="<?php echo $house['city']; ?>" class="layui-input">
                    </div>
                    <div class="layui-input-inline" style="width: 350px;">
                        <input type="text" readonly value="<?php echo $house['school']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['rent']; ?></label>
                    <div class="layui-input-inline">
                        <input type="text" name="price" readonly value="<?php if($house['price'] == -1): ?><?php echo $lable['zujinkeyi']; else: ?><?php echo $house['price']; endif; ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['rendetail']; ?></legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['livetime']; ?></label>
                    <div class="layui-input-inline">
                        <input type="text" name="live_date" lay-verify="date" lay-verify="required" placeholder="<?php echo $lable['liveDateP']; ?>" value="<?php if($house['live_date_show'] == 1): ?><?php echo $lable['anytime']; else: ?><?php echo $house['live_date']; endif; ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label"><?php echo $lable['liveterm']; ?></label>
                    <div class="layui-input-block">
                        <?php if(is_array($all_term) || $all_term instanceof \think\Collection || $all_term instanceof \think\Paginator): $i = 0; $__LIST__ = $all_term;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" disabled lay-skin="primary" name="lease_term[<?php echo $vo['term']; ?>]" title="<?php echo $vo['term']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['source']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="source" disabled value="中介" title="<?php echo $lable['inter']; ?>" <?php if($house['source'] == '中介'): ?>checked<?php endif; ?>>
                        <input type="radio" name="source" disabled value="学生公寓" title="<?php echo $lable['studentApt']; ?>" <?php if($house['source'] == '学生公寓'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['rentype']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="type" disabled value="整租" title="<?php echo $lable['zhengzu']; ?>" <?php if($house['type'] == '整租'): ?>checked<?php endif; ?>>
                        <input type="radio" name="type" disabled value="合租" title="<?php echo $lable['hezu']; ?>" <?php if($house['type'] == '合租'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['xingbie']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="sex" disabled value="不限" title="<?php echo $lable['xingbiebuxian']; ?>" <?php if($house['sex'] == '不限'): ?>checked<?php endif; ?>>
                        <input type="radio" name="sex" disabled value="限男性" title="<?php echo $lable['xiannanxing']; ?>" <?php if($house['sex'] == '限男性'): ?>checked<?php endif; ?>>
                        <input type="radio" name="sex" disabled value="限女性" title="<?php echo $lable['xiannvxing']; ?>" <?php if($house['sex'] == '限女性'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['pet']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="pet" disabled value="不限" title="<?php echo $lable['petbuxian']; ?>" <?php if($house['pet'] == '不限'): ?>checked<?php endif; ?>>
                        <input type="radio" name="pet" disabled value="接受" title="<?php echo $lable['petAcc']; ?>" <?php if($house['pet'] == '接受'): ?>checked<?php endif; ?>>
                        <input type="radio" name="pet" disabled value="不接受" title="<?php echo $lable['petDis']; ?>" <?php if($house['pet'] == '不接受'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['shifoujiaju']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="is_fur" disabled value="否" title="<?php echo $lable['bujiaju']; ?>" <?php if($house['is_fur'] == '否'): ?>checked<?php endif; ?>>
                        <input type="radio" name="is_fur" disabled value="是" title="<?php echo $lable['baojiaju']; ?>" <?php if($house['is_fur'] == '是'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label"><?php echo $lable['bill']; ?></label>
                    <div class="layui-input-block">
                        <?php if(is_array($all_bill) || $all_bill instanceof \think\Collection || $all_bill instanceof \think\Paginator): $i = 0; $__LIST__ = $all_bill;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" disabled lay-skin="primary" name="bill[<?php echo $vo['bill']; ?>]" title="<?php echo $vo['billtitle']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['housedetail']; ?></legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['houseType']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" disabled name="house_type" value="公寓" title="<?php echo $lable['apt']; ?>" <?php if($house['house_type'] == '公寓'): ?>checked<?php endif; ?>>
                        <input type="radio" disabled name="house_type" value="别墅" title="<?php echo $lable['bieshu']; ?>"  <?php if($house['house_type'] == '别墅'): ?>checked<?php endif; ?>>
                        <input type="radio" disabled name="house_type" value="联排别墅" title="<?php echo $lable['lianpaibieshu']; ?>"  <?php if($house['house_type'] == '联排别墅'): ?>checked<?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['huxing']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="house_room" disabled value="Studio" title="Studio" <?php if($house['house_room'] == 'Studio'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" disabled value="1" title="1" <?php if($house['house_room'] == '1'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" disabled value="2" title="2" <?php if($house['house_room'] == '2'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" disabled value="3" title="3" <?php if($house['house_room'] == '3'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" disabled value="4" title="4" <?php if($house['house_room'] == '4'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" disabled value="5" title="5" <?php if($house['house_room'] == '5'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" disabled value="6" title="6" <?php if($house['house_room'] == '6'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" disabled value="7" title="7" <?php if($house['house_room'] == '7'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" disabled value="8" title="8" <?php if($house['house_room'] == '8'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" disabled value="9" title="9" <?php if($house['house_room'] == '9'): ?>checked<?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['weishengjian']; ?></label>
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
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['car']; ?></label>
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
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['jiaju']; ?></label>
                    <div class="layui-input-block">
                        <?php if(is_array($all_four) || $all_four instanceof \think\Collection || $all_four instanceof \think\Paginator): $i = 0; $__LIST__ = $all_four;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" disabled lay-skin="primary" name="home[<?php echo $vo['furn']; ?>]" title="<?php echo $vo['transtitle']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label"><?php echo $lable['sheshi']; ?></label>
                    <div class="layui-input-block">
                        <?php if(is_array($all_set) || $all_set instanceof \think\Collection || $all_set instanceof \think\Paginator): $i = 0; $__LIST__ = $all_set;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" disabled lay-skin="primary" name="furniture[<?php echo $vo['set']; ?>]" title="<?php echo $vo['setitle']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>

                <div class="layui-form-item" pane="">
                    <label class="layui-form-label"><?php echo $lable['zhoubian']; ?></label>
                    <div class="layui-input-block">
                        <?php if(is_array($all_trans) || $all_trans instanceof \think\Collection || $all_trans instanceof \think\Paginator): $i = 0; $__LIST__ = $all_trans;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" lay-skin="primary" name="sation[<?php echo $vo['trans']; ?>]" title="<?php echo $vo['transtitle']; ?>" disabled  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label"><?php echo $lable['biaoqian']; ?></label>
                    <div class="layui-input-block">
                        <?php if(is_array($tags) || $tags instanceof \think\Collection || $tags instanceof \think\Paginator): $i = 0; $__LIST__ = $tags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox tags"  lay-verify="required|des_tanlent" lay-skin="primary" name="tags[<?php echo $vo['name']; ?>]" disabled title="<?php echo $vo['sname']; ?>" <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['jianjie']; ?></legend>
                </fieldset>
                <div class="layui-form-mid layui-word-aux" style="margin-left: 40px;"><?php echo $lable['transNotic']; ?>123</div>
                <?php if($house['econtent'] == null): ?>
                <div class="layui-form-item layui-form-text" id="preTrans">
                    <div class="layui-input-block">
                        <textarea placeholder="<?php echo $lable['houseDescP']; ?>" style="height: 400px;" maxlength="1500" name="content" id="contents" class="layui-textarea"><?php echo $house['content']; ?></textarea>
                    </div>
                </div>
                <?php else: ?>
                <div class="layui-row" id="translate" style="display:<?php if($house['econtent'] == null): ?>hide1{eles/}block1<?php endif; ?>">
                <div class="layui-col-xs6">
                    <div class="grid-demo grid-demo-bg1">
                        <div class="layui-input-block">
                            <textarea placeholder="<?php echo $lable['houseDescP']; ?>" style="height: 400px;" maxlength="1500" name="econtent" readonly id="english" class="layui-textarea"><?php echo $house['econtent']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="layui-col-xs6">
                    <div class="grid-demo">
                        <div class="layui-input-block" style="margin-left: 25px !important;">
                            <textarea placeholder="<?php echo $lable['houseDescP']; ?>" style="height: 400px;" maxlength="1500" name="content" readonly id="chinese" class="layui-textarea"><?php echo $house['content']; ?></textarea>
                        </div>
                    </div>
                </div>
        </div>
        <?php endif; ?>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['lianxi']; ?></legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>公司</label>
                    <div class="layui-input-inline">
                        <select name="corp" lay-filter="selectPm" disabled  lay-search="" >
                            <option value="">请选择</option>
                            <?php if(is_array($corp) || $corp instanceof \think\Collection || $corp instanceof \think\Paginator): $i = 0; $__LIST__ = $corp;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vo['cp_id']; ?>"  <?php if($house['corp'] == $vo['cp_id']): ?>selected<?php endif; ?>><?php echo $vo['cp_name']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <label class="layui-form-label" style="width: 150px !important;"><span style="color: red;">*</span>PM</label>
                    <div class="layui-input-inline" style="width: 250px !important;">
                        <select name="pm" disabled lay-verify="required" lay-filter="selectPmInfo"  id="pm"  lay-search="">
                            <option value=""></option>
                            <?php if(is_array($pminfo) || $pminfo instanceof \think\Collection || $pminfo instanceof \think\Paginator): $i = 0; $__LIST__ = $pminfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vo['ad_id']; ?>"  <?php if($house['pm'] == $vo['ad_id']): ?>selected<?php endif; ?>><?php echo $vo['ad_realname']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['xingming']; ?></label>
                    <div class="layui-input-block">
                        <input type="text" readonly value="<?php echo $house['real_name']; ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['dianhua']; ?></label>
                    <div class="layui-input-block">
                        <input type="text" readonly value="<?php echo $house['tel']; ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><?php echo $lable['youxiang']; ?></label>
                    <div class="layui-input-block">
                        <input type="text" readonly value="<?php echo $house['email']; ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['tupian']; ?></legend>
                </fieldset>
                <div style="width: 100%;">
                    <div class="left" style="width: 30%;float:left;border-right: rgba(53, 153, 153) dashed 1px;display: block">

                        <div class="layui-form-mid layui-word-aux" style="margin-left: 40px;"><?php echo $lable['tupianRemark']; ?></div>
                        <div class="layui-form-item one-pan" style="margin-left: 40px;">
                            <div class="layui-upload-drag" style="display:inline-block;padding: 0px;border: 0px;">
                                <image id="logoPreimg" class="logoPreimg" style="width: 91%;height: 237px;" <?php if($house['thumnail'] == null): else: ?>
                                src="../../../<?php echo $house['thumnail']; ?>"
                                class="logoPreimg"
                                <?php endif; ?>>

                                <input type="hidden" lay-verify="imgReg" name="thumnail" id="thumnail" value="<?php echo $house['thumnail']; ?>"/>
                                </image>
                                <div id="displayImg">
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item" id="pics">
                            <div class="layui-input-inline" style="width: 70%;margin-left: 50px;">
                                <div class="layui-upload">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right" style="width: 68%;float:left;display: block;height: 370px;">
                        <div class="layui-form-mid layui-word-aux" style="margin-left: 40px;"><?php echo $lable['tupianNotic']; ?></div>
                        <div class="layui-form-item">
                            <div class="layui-input-inline" style="width: 100%;margin-left: 50px;">
                                <div class="pic-more" style="height: 266px">
                                    <ul class="pic-more-upload-list" id="slide-pc-priview" style="width: 100%">
                                        <?php if($house['images'] != null): if(is_array($house['images1']) || $house['images1'] instanceof \think\Collection || $house['images1'] instanceof \think\Paginator): $k = 0; $__LIST__ = $house['images1'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($k % 2 );++$k;?>
                                        <li class="item_img" style="width: 24%;float: left;"><img src="../../../<?php echo $item; ?>" class="img" style="width: 100%;height: 112px;" ><input type="hidden" name="images[]" value="<?php echo $item; ?>" lay-verify="required|imgRegCaseType"  class="img_url" /></li>
                                        <?php endforeach; endif; else: echo "" ;endif; else: ?>
                                        未上传
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['shipin']; ?></legend>
                </fieldset>
                <div class="layui-form-mid layui-word-aux" style="margin-left: 40px;"><?php echo $lable['otherNotic']; ?></div>
                <div class="layui-form-item one-pan" style="margin-left: 40px;">
                    <div class="layui-upload-drag" id="uploadLogo" style="padding: 0px;display: inline-block;">
                        <?php if($house['video'] != null): ?>
                        <video id="logoPre" controls="controls" autobuffer="autobuffer" style="width: 335px;height: 215px;" autoplay="autoplay" loop="loop" src="../../../<?php echo $house['video']; ?>">
                            <input type="hidden" name="video" id="video" value="<?php echo $house['video']; ?>"/>
                        </video>
                        <div id="display" style="display: none">
                            <i class="layui-icon"></i>
                            <p><?php echo $lable['shangchuan']; ?></p>
                        </div>
                        <?php else: ?>
                        未上传
                        <?php endif; ?>
                    </div>
                    <br/>
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