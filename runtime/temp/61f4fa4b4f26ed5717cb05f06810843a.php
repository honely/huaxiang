<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:89:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\house\add.html";i:1598977635;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
        left:380px;
        top:0;
    }
    .logoPreimg{
        height: 251px;width: 91%;padding: 8px;
    }
    .inner-class{
        display:inline-block;padding: 0px;border: 0px;width: 100%;
    }
    .right{
        width: 68%;float:left;display: block;height: 400px;
    }
    .layui-form-onswitch i {
        left: 98px;
        background-color: #fff;
    }
    .layui-form-switch {
        width: 110px;
    }
    .layui-form-switch em {
        width: 90px;
    }
    .roomate{
        display: none;
    }
</style>
<style>
    .dragPic{
        width:704px;
        margin:50px auto;
    }
    .dragPicBox{
        width:704px;
        background-color:#c0ebd7;
        position:relative;
    }
    .dragPic .item{
        display: inline;
        float: left;
        height: 86px;
        width: 86px;
        cursor: move;

    }
    .dragPic .item span{
        width:80px;
        height:80px;
        display:block;
        margin:3px;
        border: 1px solid #CDCDCB;
    }
    .dragPic .item:hover span,.dragPic .selected span{
        border-color:#FF0000;
    }
    .dragPic .item.selected{
        border-color:#FF0000;
    }
    .dragPic span img{
        display: block;
        height: 80px;
        width: 80px;
    }
    .dragPic .spacing{
        position:absolute;
        width:6px;
        height:82px;
        background-color:#1ABC9C;
        margin-top:3px;
    }
    #slide-pc-priview .close:hover{ display: block;cursor:pointer;}

</style>
<div class="layui-body">
    <div style="margin: 20px;">
<span class="layui-breadcrumb" lay-separator=">">
   <a><?php echo $lable['houselist']; ?></a>
    <a href="<?=url('house/index')?>"><?php echo $lable['houselist']; ?></a>
        <a><cite><?php echo $lable['fabufangyuan']; ?></cite></a>
        </span>
        <div style="float:right;">
            <a href="javascript:history.go(-1);" class="layui-btn layui-btn-primary layui-btn-sm">
                <i class="layui-icon layui-icon-return"></i>
                <?php echo $lable['back']; ?></a>
        </div>
    </div>
    <hr/>
    <div style="margin: 10px">
        <div style="padding: 15px;">
            <form class="layui-form" id="myForm" action="<?=url('house/add')?>?typess=<?php echo $typess; ?>" method="post">
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['basicInfo']; ?></legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['houseName']; ?></label>
                    <div class="layui-input-block">
                        <input type="text" name="title" lay-verify="required|title" placeholder="<?php echo $lable['houseNameP']; ?>" maxlength="50" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['houseAddr']; ?></label>
                    <div  class="layui-input-inline" id="input" style="width: 450px;">
                        <input type="text" id="end" autocomplete="off" class="layui-input" placeholder="<?php echo $lable['houseAddP']; ?>">
                        <input type="text" name="address" id="address" style="display: none" readonly class="layui-input" lay-verify="required|addresss"  placeholder="目的地取值">
                        <input type="hidden" name="x" id="x" lay-verify="addres" autocomplete="off" class="layui-input" >
                        <input type="hidden" name="y" id="y" lay-verify="addres" autocomplete="off" class="layui-input" >
                    </div>
                    <div class="layui-input-inline">
                        <span id="resetAdd" class="layui-btn">Reset Address</span>
                    </div>
                    <hr style="background-color: transparent;color: transparent">
                    <div class="layui-form-mid layui-word-aux" style="margin-left: 110px;color: red !important;"><?php echo $lable['selectAddNot']; ?></div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><?php echo $lable['houseUrl']; ?></label>
                    <div class="layui-input-block">
                        <input type="text" name="http"  placeholder="<?php echo $lable['houseUrlP']; ?>" id="orderHouse" autocomplete="off" class="layui-input" onblur="checkHouseUrl()">
                    </div>
                </div>
                <div class="layui-form-item" style="display: none">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['city']; ?></label>
                    <div class="layui-input-inline">
                        <input type="text" id="city" lay-verify="required|title" value="<?php echo $lable['moerben']; ?>" readonly class="layui-input">
                        <input type="hidden" name="city" id="citys" lay-verify="required|title" value="<?php echo $lable['moerben']; ?>" readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['rent']; ?></label>
                    <div class="layui-input-inline" style="width: 230px !important;">
                        <input type="number" min="0" name="price" lay-verify="required|prices" placeholder="<?php echo $lable['rentPriceP']; ?>" id="price" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline">
                        <input type="checkbox" lay-skin="switch" lay-filter="switchRent" lay-text="<?php echo $lable['zujinkeyi']; ?>|<?php echo $lable['zujinkeyi']; ?>">
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['rendetail']; ?></legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['livetime']; ?></label>
                    <div class="layui-input-inline" style="width: 230px !important;">
                        <input type="text" readonly name="live_date" id="date" lay-verify="date" lay-verify="required" placeholder="<?php echo $lable['liveDateP']; ?>" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline">
                        <input type="checkbox" lay-skin="switch" lay-filter="switchTest" lay-text="<?php echo $lable['anytime']; ?>|<?php echo $lable['anytime']; ?>">
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label" style="width: 90px !important;"><?php echo $lable['liveterm']; ?></label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="lease_term[12+]" lay-skin="primary" title="12+" checked>
                        <input type="checkbox" name="lease_term[6-12]" lay-skin="primary" title="6-12">
                        <input type="checkbox" name="lease_term[3-6]" lay-skin="primary" title="3-6">
                        <input type="checkbox" name="lease_term[0-3]" lay-skin="primary" title="0-3">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['source']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="source" value="中介" title="<?php echo $lable['inter']; ?>" checked>
                        <input type="radio" name="source" value="学生公寓" title="<?php echo $lable['studentApt']; ?>">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['rentype']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="type" value="整租" lay-filter="isRoomate" title="<?php echo $lable['zhengzu']; ?>" checked>
                        <input type="radio" name="type" value="合租" lay-filter="isRoomate" title="<?php echo $lable['hezu']; ?>">
                         <input type="hidden" id="roomate" value="1">
                    </div>
                </div>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['xingbie']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="sex" value="不限" title="<?php echo $lable['xingbiebuxian']; ?>" checked>
                        <input type="radio" name="sex" value="男" title="<?php echo $lable['xiannanxing']; ?>">
                        <input type="radio" name="sex" value="女" title="<?php echo $lable['xiannvxing']; ?>">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['pet']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="pet" value="不接受" title="<?php echo $lable['petDis']; ?>" checked>
                        <input type="radio" name="pet" value="接受" title="<?php echo $lable['petAcc']; ?>">

                    </div>
                </div>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['shifoujiaju']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="is_fur" value="否" title="<?php echo $lable['bujiaju']; ?>" checked>
                        <input type="radio" name="is_fur" value="是" title="<?php echo $lable['baojiaju']; ?>">
                    </div>
                </div>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span>可否吸烟</label>
                    <div class="layui-input-block">
                        <input type="radio" name="smoke" value="不可" title="不可" checked>
                        <input type="radio" name="smoke" value="可以" title="可以">
                    </div>
                </div>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span>接受情侣</label>
                    <div class="layui-input-block">
                        <input type="radio" name="is_couple" value="不接受" title="不接受" checked>
                        <input type="radio" name="is_couple" value="接受" title="接受">

                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label"><?php echo $lable['bill']; ?></label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="bill[包水]" lay-skin="primary" title="<?php echo $lable['water']; ?>">
                        <input type="checkbox" name="bill[包电]" lay-skin="primary" title="<?php echo $lable['elect']; ?>">
                        <input type="checkbox" name="bill[包煤气]" lay-skin="primary" title="<?php echo $lable['gas']; ?>">
                        <input type="checkbox" name="bill[包网]" lay-skin="primary" title="<?php echo $lable['nets']; ?>">
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['housedetail']; ?></legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['houseType']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="house_type" value="公寓" title="<?php echo $lable['apt']; ?>" checked>
                        <input type="radio" name="house_type" value="别墅" title="<?php echo $lable['bieshu']; ?>">
                        <input type="radio" name="house_type" value="联排别墅" title="<?php echo $lable['lianpaibieshu']; ?>">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['huxing']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="house_room" value="Studio" title="Studio">
                        <input type="radio" name="house_room" value="1" title="1" checked>
                        <input type="radio" name="house_room" value="2" title="2">
                        <input type="radio" name="house_room" value="3" title="3">
                        <input type="radio" name="house_room" value="4" title="4">
                        <input type="radio" name="house_room" value="5" title="5">
                        <input type="radio" name="house_room" value="6" title="6">
                        <input type="radio" name="house_room" value="7" title="7">
                        <input type="radio" name="house_room" value="8" title="8">
                        <input type="radio" name="house_room" value="9" title="9">

                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['weishengjian']; ?></label>
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
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['car']; ?></label>
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
                <div class="layui-form-item entire">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['jiaju']; ?></label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="home[床]" lay-skin="primary" title="<?php echo $lable['chuang']; ?>">
                        <input type="checkbox" name="home[沙发]" lay-skin="primary" title="<?php echo $lable['shafa']; ?>">
                        <input type="checkbox" name="home[WIFI]" lay-skin="primary" title="<?php echo $lable['fWIFI']; ?>">
                        <input type="checkbox" name="home[空调]" lay-skin="primary" title="<?php echo $lable['kongtiao']; ?>">
                        <input type="checkbox" name="home[洗衣机]" lay-skin="primary" title="<?php echo $lable['xiyiji']; ?>">
                        <input type="checkbox" name="home[冰箱]" lay-skin="primary" title="<?php echo $lable['bingxiang']; ?>">
                        <input type="checkbox" name="home[微波炉]" lay-skin="primary" title="<?php echo $lable['weibolu']; ?>">
                        <input type="checkbox" name="home[暖气]" lay-skin="primary" title="<?php echo $lable['nuanqi']; ?>">
                        <input type="checkbox" name="home[电烤箱]" lay-skin="primary" title="<?php echo $lable['kaoxiang']; ?>">
                        <input type="checkbox" name="home[洗碗机]" lay-skin="primary" title="<?php echo $lable['xiwanji']; ?>">
                        <input type="checkbox" name="home[书桌]" lay-skin="primary" title="<?php echo $lable['shuzhuo']; ?>">
                        <input type="checkbox" name="home[烘干机]" lay-skin="primary" title="<?php echo $lable['hongganji']; ?>">
                        <input type="checkbox" name="home[电视]" lay-skin="primary" title="<?php echo $lable['dianshi']; ?>">
                        <input type="checkbox" name="home[天然气]" lay-skin="primary" title="<?php echo $lable['tianranqi']; ?>">
                    </div>
                </div>

                <div class="layui-form-item entire" pane="">
                    <label class="layui-form-label"><?php echo $lable['sheshi']; ?></label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="furniture[游泳池]" lay-skin="primary" title="<?php echo $lable['yongchi']; ?>">
                        <input type="checkbox" name="furniture[健身房]" lay-skin="primary" title="<?php echo $lable['jianshenfang']; ?>">
                        <input type="checkbox" name="furniture[停车位]" lay-skin="primary" title="<?php echo $lable['tingchewei']; ?>">
                        <input type="checkbox" name="furniture[电影院]" lay-skin="primary" title="<?php echo $lable['dianyingyuan']; ?>">
                        <input type="checkbox" name="furniture[门禁]" lay-skin="primary" title="<?php echo $lable['menjin']; ?>">
                        <input type="checkbox" name="furniture[前台]" lay-skin="primary" title="<?php echo $lable['qiantai']; ?>">
                        <input type="checkbox" name="furniture[桑拿]" lay-skin="primary" title="<?php echo $lable['sangna']; ?>">
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label"><?php echo $lable['biaoqian']; ?></label>
                    <div class="layui-input-block">
                        <?php if(is_array($tags) || $tags instanceof \think\Collection || $tags instanceof \think\Paginator): $i = 0; $__LIST__ = $tags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox tags" lay-verify="required|des_tanlent"  lay-skin="primary" name="tags[<?php echo $vo['name']; ?>]" title="<?php echo $vo['sname']; ?>">
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span>室友数量</label>
                    <div class="layui-input-block">
                        <input type="radio" name="roomates" value="0" title="0" checked>
                        <input type="radio" name="roomates" value="1" title="1">
                        <input type="radio" name="roomates" value="2" title="2">
                        <input type="radio" name="roomates" value="3" title="3">
                        <input type="radio" name="roomates" value="4" title="4">
                        <input type="radio" name="roomates" value="5" title="5">
                        <input type="radio" name="roomates" value="6" title="6">
                        <input type="radio" name="roomates" value="7" title="7">
                        <input type="radio" name="roomates" value="8" title="8">
                        <input type="radio" name="roomates" value="9" title="9">
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title roomate" style="margin-top: 20px;">
                    <legend>房东概况</legend>
                </fieldset>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['loadJob']; ?></label>
                    <div class="layui-input-block">
                        <input type="text" name="loard_job" maxlength="10" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span>房东性别</label>
                    <div class="layui-input-block">
                        <input type="radio" name="loard_sex" value="1" title="男" checked>
                        <input type="radio" name="loard_sex" value="2" title="女">
                    </div>
                </div>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span>是否吸烟</label>
                    <div class="layui-input-block">
                        <input type="radio" name="loard_smoke" value="否" title="否" checked>
                        <input type="radio" name="loard_smoke" value="是" title="是">
                    </div>
                </div>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span>宠物</label>
                    <div class="layui-input-block">
                        <input type="radio" name="loard_pet" value="无" title="无" checked>
                        <input type="radio" name="loard_pet" value="有" title="有">
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['jianjie']; ?></legend>
                </fieldset>
                <div style="margin:0 auto !important;color: red !important;clear:both;text-align: center"><?php echo $lable['transNoticNew']; ?></div>
                <input type="hidden" value="1" id="isTrans"/>
                <div class="layui-row">
                    <div class="layui-col-xs6">
                        <div class="grid-demo grid-demo-bg1">
                            <span class="layui-btn layui-btn-sm transLate" data-type="zh" style="float: right;margin-top: 10px;"><?php echo $lable['entocn']; ?></span>
                        </div>
                    </div>
                    <div class="layui-col-xs6">
                        <div class="grid-demo">
                            <span class="layui-btn layui-btn-primary layui-btn-sm  transLate" data-type="en" style="margin-left: 25px;margin-top: 10px;" ><?php echo $lable['cntoen']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="layui-row" id="translate" style="margin-top: 12px;">
                    <div class="layui-col-xs6">
                        <div class="grid-demo grid-demo-bg1">
                            <div class="layui-input-block">
                                <textarea lay-verify="required" placeholder="<?php echo $lable['transPlaceEn']; ?>" style="height: 400px;" maxlength="4000" name="econtent" id="english" class="layui-textarea"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-xs6">
                        <div class="grid-demo">
                            <div class="layui-input-block" style="margin-left: 25px !important;">
                                <textarea lay-verify="required" placeholder="<?php echo $lable['transPlaceCn']; ?>" style="height: 400px;" maxlength="800" id="chinese" name="content" class="layui-textarea"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['lianxi']; ?></legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>公司</label>
                    <div class="layui-input-inline">
                        <select name="corp" lay-filter="selectPm"  lay-search="" >
                            <option value="">Please Select</option>
                            <?php if(is_array($corp) || $corp instanceof \think\Collection || $corp instanceof \think\Paginator): $i = 0; $__LIST__ = $corp;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vo['cp_id']; ?>"><?php echo $vo['cp_name']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <label class="layui-form-label" style="width: 150px !important;"><span style="color: red;">*</span>PM</label>
                    <div class="layui-input-inline" style="width: 250px !important;">
                        <select name="pm" lay-verify="required" lay-filter="selectPmInfo"  id="pm"  lay-search="">
                            <option value="">Please Select</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['xingming']; ?></label>
                    <div class="layui-input-block">
                        <input type="text" name="real_name" id='real_name' lay-verify="required|title"  autocomplete="off" value="" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['dianhua']; ?></label>
                    <div class="layui-input-block">
                        <input type="text" name="tel" id="tel" lay-verify="required" autocomplete="off" value="" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><?php echo $lable['youxiang']; ?></label>
                    <div class="layui-input-block">
                        <input type="text" name="email" id="email" autocomplete="off" value="" class="layui-input">
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['tupian']; ?></legend>
                </fieldset>
                <div style="width: 100%;">
                    <div class="left" style="width: 30%;float:left;border-right: rgba(53, 153, 153) dashed 1px;display: block">

                        <div class="layui-form-mid layui-word-aux" style="margin-left: 40px;"><?php echo $lable['tupianRemark']; ?></div>
                        <div class="layui-form-item one-pan" style="margin-left: 40px;">
                            <div class="layui-upload-drag inner-class">
                                <image id="logoPreimg" class="logoPreimg">
                                    <input type="hidden" lay-verify="imgReg" name="thumnail" id="thumnail" value=""/>
                                </image>
                                <div id="displayImg">
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item" id="pics">
                            <div class="layui-input-inline" style="width: 70%;margin-left: 50px;">
                                <div class="layui-upload">
                                    <span style="color: red;padding: 8px;">*</span><button type="button" class="layui-btn layui-btn pull-left layui-btn-sm" id="uploadImg"><?php echo $lable['fengmiantu']; ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right">
                        <div class="layui-form-mid layui-word-aux" style="margin-left: 40px;"><?php echo $lable['tupianNotic']; ?></div>
                        <div class="layui-form-item">
                            <div class="layui-input-inline" style="width: 100%;margin-left: 50px;">
                                <div class="pic-more" style="height: 266px">
                                    <div class="dragPic">
                                        <div class="dragPic">
                                            <div class="dragPicBox clearfix" node-type="box" id="slide-pc-priview">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="layui-input" lay-verify="imgRegCaseType" />
                                <div class="layui-upload">
                                    <button type="button" class="layui-btn layui-btn pull-left layui-btn-sm" id="slide-pc"><?php echo $lable['qitatupian']; ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['shipin']; ?></legend>
                </fieldset>
                <div class="layui-btn upBtn" style="margin-left: 40px;">Upload</div>
                <div class="layui-btn layui-btn-primary urlBtn" style="margin-left: 40px;">Video Url</div>
                <br>
                <div class="layui-form-mid layui-word-aux upNotice" style="margin-left: 40px;"><?php echo $lable['otherNotic']; ?></div>
                <div class="layui-form-mid layui-word-aux urlNotice" style="margin-left: 40px;display: none">5 minutes maxsize，40MB maximum Size</div>


                <div class="layui-form-item one-pan one-video" style="margin-left: 40px;">
                    <div class="layui-upload-drag" id="uploadLogo" style="padding: 50px;">
                        <video id="logoPre" style="display: none" controls="controls" autobuffer="autobuffer" loop="loop" src="">
                            <input type="hidden" name="video" id="video" value=""/>
                        </video>
                        <!--进度条-->
                        <div id="jdT" style="width:200px;height:18px;position: absolute;top: 157px;left: 113px;display:none;">
                            <div class="layui-progress layui-progress-big" lay-showPercent="true" lay-filter="demo">
                                <div class="layui-progress-bar layui-bg-red" lay-percent="0%"></div>
                            </div>
                        </div>
                        <!--删除按钮-->
                        <div id="vidDel" style="position: absolute;left: 60px;top: 18px;color: red;display: none;cursor: pointer;"><?php echo $lable['delete']; ?></div>
                        <div id="display">
                            <i class="layui-icon"></i>
                            <p><?php echo $lable['xuanzeshipim']; ?></p>
                        </div>
                    </div>
                    <div class="layui-btn layui-btn-sm uploadLogo" style="margin-left: 20px;" id="choiceVid" ><?php echo $lable['shangchuan']; ?></div>
                    <div class="layui-btn layui-btn-sm" id="upload-video" style="margin-left: 20px;display:none;" ><?php echo $lable['shangchuan']; ?></div>
                    <br/>
                </div>
                <div class="layui-form-item one-pan two-video" style="margin-left: 40px;display: none">
                    <div class="layui-upload-drag" id="urlUploadLogo" style="padding: 20px;width:50%">
                        <video id="uLogoPre" style="display: none" controls="controls" autobuffer="autobuffer" loop="loop" src="">
                        </video>
                        <!--进度条-->
                        <div id="uJdT" style="width:200px;height:18px;position: absolute;top: 157px;left: 113px;display:none;">
                            <div class="layui-progress layui-progress-big" lay-showPercent="true" lay-filter="demo">
                                <div class="layui-progress-bar layui-bg-red" lay-percent="0%"></div>
                            </div>
                        </div>
                        <!--删除按钮-->
                        <div id="uVidDel" style="position: absolute;left: 60px;top: 18px;color: red;display: none;cursor: pointer;"><?php echo $lable['delete']; ?></div>
                        <div id="uDisplay">
                            <input type="text" id="urlUpload"  placeholder="Bilibili视频链接" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-btn layui-btn-sm urlUploadLogo" style="margin-left: 20px;" id="uChoiceVid" ><?php echo $lable['shangchuan']; ?></div>
                    <br/>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-inline" style="width: 270px;margin-left: 40px;">
                        <button class="layui-btn" lay-submit><?php echo $lable['fabu']; ?></button>
                        <span class="layui-btn layui-btn-primary" id="save" ><?php echo $lable['baocun']; ?></span>
                        <a class="layui-btn layui-btn-primary" href="javascript:history.go(-1);"><?php echo $lable['fanhui']; ?></a>

                    </div>
                </div>
            </form>

        </div>
    </div>
    <script>
        $('#resetAdd').click(function () {
            //清空经纬度的赋值
            $('#end').show();
            $('#address').hide();
            $('#end').val('');
            $('#address').val('');
            $('#x').val('');
            $('#y').val('');
        });
        //更改视频div显示
        $('.upBtn').click(function () {
            $(".upBtn").removeClass("layui-btn-primary ");
            $(".urlBtn").addClass("layui-btn-primary");
            $('.one-video').show();
            $('.two-video').hide();
            $('.upNotice').show();
            $('.urlNotice').hide();
        });
        $('.urlBtn').click(function () {
            $(".urlBtn").removeClass("layui-btn-primary ");
            $(".upBtn").addClass("layui-btn-primary");
            $('.one-video').hide();
            $('.two-video').show();
            $('.upNotice').hide();
            $('.urlNotice').show();
        });
        //远程上传
        $('.urlUploadLogo').click(function () {
            var url = $('#urlUpload').val();
            $.ajax({
                type: 'POST',
                url: "<?=url('house/urlUpload')?>",
                data:{'url':url},
                beforeSend: function () {
                    layer.msg('请稍等...');
                },
                success: function(data){
                    if(data.code == 1){
                        layer.msg(data.msg);
                        $('#uLogoPre').show();
                        // 删除显示
                        $('#uVidDel').show();
                        //父级样式
                        $("#urlUploadLogo").removeAttr("style","");
                        $('#urlUploadLogo').css("padding", "50px");
                        // 上传显示，选择隐藏
                        $('#uChoiceVid').hide();
                        $('#uDisplay').hide();
                        $('#uLogoPre').css('width','335px');
                        $('#uLogoPre').css('height','251px');
                        $('#uLogoPre').attr('src', data.filepath);
                        $('#video').val(data.filepath);
                    }else{
                        layer.msg(data.msg);
                    }
                }
            });
        });

        // 视频删除,样式重置，上传视频初始化
        $('#uVidDel').click(function(event){
            console.log("执行删除");
            $('#uVidDel').hide();                                               //删除按钮隐藏
            $('#uLogoPre').removeAttr('src');                                   //视频清空地址
            $('#uLogoPre').css('width','');
            $('#uLogoPre').css('height','');
            $('#video').val('');
            $('#uLogoPre').hide();                                              //视频隐藏
            $('#uDisplay').show();                                              //提示图标，文字显示
            $('#urlUploadLogo').css("padding", "20px");                 //父级初始样式
            $('#urlUploadLogo').css("width", "50%");                    //父级初始样式
            // 上传隐藏，选择显示
            $('#uChoiceVid').show();
            //初始化上传视频组件
            upload.render();
            event.stopPropagation();                                           //禁止冒泡
        });
        //保存不更新状态
        $('#save').click(function () {
            $.ajax({
                type: 'POST',
                url: "<?=url('house/add')?>?status=1&typess=<?php echo $typess; ?>",
                data:$('#myForm').serialize(),
                dataType:  'json',
                success: function(data){
                    if(data.code == 1){
                        layer.msg(data.msg);
                        window.location.href=data.url;
                    }else{
                        layer.msg(data.msg);
                    }
                }
            });
        });
        $('.transLate').click(function () {
            var to = $(this).data('type');
            var contents='';
            $('#contents').removeAttr('name');
            $('#chinese').attr('name','content');
            if(to == 'en'){
                contents = $("#chinese").val();
            }else{
                contents = $("#english").val();
            }
            contents = contents.replace(/[\r\n]/g,"~");
            if(!contents){
                return layer.msg('翻译内容不能为空！');
            }
            $.ajax({
                type: 'POST',
                url: "<?=url('translate/transto')?>",
                data:{'content':contents,'to':to},
                dataType:  'json',
                success: function(data){
                    if(to == 'en'){
                        cn = data.src.replace(/~/g,"\n");
                        en = data.dst.replace(/~/g,"\n");
                        $('#chinese').val(cn);
                        $('#english').val(en);
                    }else{
                        cn = data.src.replace(/~/g,"\n");
                        en = data.dst.replace(/~/g,"\n");
                        $('#chinese').val(en);
                        $('#english').val(cn);
                    }
                }
            });
        });
    </script>
    <script>
        layui.link('/layui/src/autocomplete/autocomplete.css');
        layui.config({
            base: '/layui/src/autocomplete/'
            , version: false,
            debug: false,
        });
        layui.use(['form', 'jquery','upload','laydate','element', 'autocomplete'], function(){
            var form = layui.form
                ,upload = layui.upload
                , laydate = layui.laydate
                ,$ = layui.jquery
                ,autocomplete = layui.autocomplete
                ,element = layui.element;
            form.on('radio(isRoomate)', function(data){
                 var isRoom = data.value;
                if(isRoom == '合租'){
                    $('.roomate').show();
                    $('#roomate').val(2);
                    $('.entire').hide();
                }else{
                    $('.roomate').hide();
                    $('#roomate').val(1);
                    $('.entire').show();
                }
            });
            var xhrOnProgress=function(fun) {
                xhrOnProgress.onprogress = fun;
                //绑定监听
                //使用闭包实现监听绑
                return function() {
                    //通过$.ajaxSettings.xhr();获得XMLHttpRequest对象
                    var xhr = $.ajaxSettings.xhr();
                    //判断监听函数是否为函数
                    if (typeof xhrOnProgress.onprogress !== 'function')
                        return xhr;
                    //如果有监听函数并且xhr对象支持绑定时就把监听函数绑定上去
                    if (xhrOnProgress.onprogress && xhr.upload) {
                        xhr.upload.onprogress = xhrOnProgress.onprogress;
                    }
                    return xhr;
                }
            }
            autocomplete.render({
                elem: $('#end'),
                response: {code: 'code', data: 'suggestions'},
                template_val: '{{d.label}}',
                template_txt: '{{d.label}}',
                onselect: function (resp) {
                    var address = resp.label;
                    $('#address').val(address);
                    $('#end').hide();
                    $('#address').show();
                    locationAD(address);
                }
            });
            let APP_ID_HERE = "QuHxU6ypXzp37Dci84o8";
            let APP_CODE_HERE = "TDu_enlm0QIblRnIl33buw";
            let city_code = [{ code: "Melbourne", name: "墨尔本" }, { code: "Sydney", name: "悉尼" },{ code: "Tasmania", name: "塔州" }, { code: "Brisbane", name:"布里斯班"}];
            function locationAD(query) {
                $.getJSON("https://geocoder.api.here.com/6.2/geocode.json?gen=9&searchtext=" + query + "&app_id=" + APP_ID_HERE + "&app_code=" + APP_CODE_HERE, function (data) {
                    console.log(data);
                    var lati = data["Response"]["View"][0]["Result"][0]["Location"]["DisplayPosition"]["Latitude"];
                    var longi = data["Response"]["View"][0]["Result"][0]["Location"]["DisplayPosition"]["Longitude"];
                    var city = data["Response"]["View"][0]["Result"][0]["Location"]["Address"]["City"];
                    $('#x').val(lati);
                    $('#y').val(longi);
                    if(city == "Hobart" || city == "Launcestion"){
                        city = "Tasmania";
                    }
                    let cityName='';
                    let cityNames='';
                    let flag =false;
                    let langs ='<?php echo $langs; ?>';
                    city_code.forEach((item,index,array)=>{
                        //执行代码
                        if(item.code == city){
                            cityNames = item.name;
                            flag = true;
                            if(langs == 'Cn'){
                                cityName = item.name;
                            }else{
                                cityName = item.code;
                            }
                            $('#city').val(cityName);
                            $('#citys').val(cityNames);
                        }
                    });
                    if(!flag){
                        $('#end').val('');
                        $('#end').show();
                        $('#address').val('');
                        $('#address').hide();
                        $('#end').focus();
                        return  layer.msg('我们尚未开展除墨尔本，悉尼，塔州，布里斯班四个地区外的业务，请重新填写地址');
                    }
                    $.ajax({
                        type: 'POST',
                        url: "<?=url('house/getSchoolss')?>",
                        data: {city:cityNames},
                        dataType:  'json',
                        success: function(data){
                            console.log(data);
                            var code=data.data;
                            $("#school").html("<option value=''><?php echo $lable['selectSchoolP']; ?></option>");
                            $.each(code, function(i, val) {
                                var option1 = $("<option>").val(val.name).text(val.sname);
                                $("#school").append(option1);
                                form.render('select');
                            });
                        }
                    });
                });

            }
            //日期
            laydate.render({
                elem: '#date'
            });
            //随时入住
            form.on('switch(switchTest)', function(data){
                if(this.checked){
                    $('#date').val('0000-00-00');
                    $('#date').hide();
                }else{
                    $('#date').show();
                }
            });
            //异步
            form.on('select(selectPm)', function(data){
                var cp_id = data.value;
                $.ajax({
                    type: 'POST',
                    url: "<?=url('house/getpm')?>",
                    data: {cp_id:cp_id},
                    dataType:  'json',
                    success: function(data){
                        console.log(data);
                        var code=data.data;
                        $("#pm").html("<option value=''>Please Select</option>");
                        $.each(code, function(i, val) {
                            var option1 = $("<option>").val(val.ad_id).text(val.ad_realname);
                            $("#pm").append(option1);
                            form.render('select');
                        });
                    }
                });
            });
            //异步
            form.on('select(selectPmInfo)', function(data){
                var pmid = data.value;
                $.ajax({
                    type: 'POST',
                    url: "<?=url('house/getpminfo')?>",
                    data: {pmid:pmid},
                    dataType:  'json',
                    success: function(data){
                        console.log(data);
                        var code=data.data;
                        if(data.code == 1){
                            $('#real_name').val(code.ad_realname);
                            $('#tel').val(code.ad_phone);
                            $('#email').val(code.ad_email);
                        }

                    }
                });
            });
            //租金可议
            form.on('switch(switchRent)', function(data){
                if(this.checked){
                    $('#price').removeAttr('min');
                    $('#price').val('-1');
                    $('#price').hide();
                }else{
                    $('#price').show();
                }
            });
            //自定义验证规则
            form.verify({
                title: function(value){
                    if(value.length < 2){
                        return '标题至少得2个字符啊';
                    }
                },addres: function(value){
                    if(!value){
                        return '请输入正确的地址信息,并在推荐地址里选择！';
                    }
                },prices: function(value){
                    if(value <-1){
                        return '价格不能小于零！';
                    }
                },addresss: function(value){
                    var values = value.split(',');
                    if(values.length < 3){
                        return '请输入正确的地址信息！';
                    }
                }
                ,imgReg:function (value) {
                    if(value.length <= 0){
                        return '请上传封面图片';
                    }
                }
                ,imgRegCaseType:function () {
                    var len = $(".img_url").length;
                    var types = $("#roomate").val();
                    if(types == 2){
                        if (len < 2) {
                            return "至少上传2张房源图片";
                        }
                    }
                    if (len > 8) {
                        return "房源图片不超过8个";
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
                        return "Maximum 6 tags!";
                    }
                }
            });
            form.on('select(bu_p_id)', function(data){
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
                        // $("#school").get(0).selectedIndex=0;
                    }
                });
            });
            //封面图上传
            upload.render({
                elem: '#uploadImg'
                ,url: '<?php echo url("house/upload"); ?>'
                ,exts: 'jpg|png|jpeg|gif|bmp|JPG'
                ,size: 1024*5
                ,done: function(res){
                    console.log(123);
                    layer.close(layer.msg());//关闭上传提示窗口
                    if(res.status == 0) {
                        return layer.msg(res.message);
                    }
                    $('#uploadImg').removeClass('layui-upload-drag');
                    $('#logoPreimg').css('width','91%');
                    $('#logoPreimg').css('height','251px');
                    $('#logoPreimg').attr('src',"../../../"+res.filepath);
                    $('#displayImg').hide();
                    $('#thumnail').val('' +res.filepath + '');
                }
            });

            //视频上传
            upload.render({
                elem: '.uploadLogo'
                ,auto:false
                ,url: '<?php echo url("house/upload"); ?>'
                ,size:10240 //限制文件大小，单位 KB
                ,acceptMime: 'video/mp4'
                ,ext: 'mp4'
                ,accept: 'video' //限制文件大小，单位 KB
                ,bindAction: '#upload-video'
                ,xhr:xhrOnProgress
                ,progress:function(value){
                    //上传进度回调 value进度值
                    element.progress('demo', value+'%');//设置页面进度条
                }
                ,choose:function(obj){
                    console.log("执行上传视频选择")
                    obj.preview(function(index, file, result){
                        console.log("预览视频")
                        let url = URL.createObjectURL(file);
                        $('#logoPre').show();
                        // 删除显示
                        $('#vidDel').show();
                        // 上传显示，选择隐藏
                        // $('#upload-video').show();
                        $('#choiceVid').hide();
                        $('#display').hide();
                        $('#uploadLogo').removeClass('layui-upload-drag');
                        $('#logoPre').css('width','335px');
                        $('#logoPre').css('height','251px');
                        $('#logoPre').attr('src', url);
                        let timer = setTimeout(function(){
                            layer.close(layer.index);
                            let video_time = document.getElementById("logoPre").duration;
                            console.log(video_time);
                            if(video_time > 125){
                                layer.msg('上传视频不能超过120秒', {icon: 2})
                            }
                            clearTimeout(timer);
                        },1000);
                        // 显示进度条
                        // 上传显示进度条
                        $("#jdT").show();
                        // 创建定时器 0.5秒后执行  然后清除定时器，让他只执行一次
                        var d1 = setInterval(function(){
                            $('#logoPre').attr('autoplay', 'autoplay');
                            console.log("定时器执行，上传点击事件")
                            $('#upload-video').click();
                            clearTimeout(d1);
                        },500);


                        // 视频删除,样式重置，上传视频初始化
                        $('#vidDel').click(function(event){
                            console.log("执行删除");
                            $('#vidDel').hide();                                               //删除按钮隐藏
                            $('#logoPre').removeAttr('src');                                   //视频清空地址
                            $('#logoPre').css('width','');
                            $('#logoPre').css('height','');
                            $('#video').val('');
                            $('#logoPre').hide();                                              //视频隐藏
                            $('#display').show();                                              //提示图标，文字显示
                            $('#uploadLogo').addClass("layui-upload-drag");                    //父级初始样式
                            // 上传隐藏，选择显示
                            $('#upload-video').hide();
                            $('#choiceVid').show();
                            //初始化上传视频组件
                            upload.render();
                            event.stopPropagation();                                           //禁止冒泡
                        });
                    });
                }
                ,before: function(input){
                    loading = layer.load(2, {
                        shade: [0.2,'#000']
                    });
                    console.log(input)
                }
                ,done: function(res){
                    $('#logoPre').removeAttr('src');
                    $('#video').val('');
                    console.log(res.filepath);
                    layer.close(loading);
                    $('#video').val(res.filepath);
                    $('#uploadLogo').removeClass('layui-upload-drag');
                    $('#logoPre').css('width','335px');
                    $('#logoPre').css('height','251px');
                    $('#logoPre').attr('src',"../../../"+res.filepath);
                    $('#display').hide();
                    layer.msg(res.msg, {icon: 1, time: 1000});
                    // 上传完成隐藏进度条  进度条重置，解决再次上传初始为100%的问题
                    $("#jdT").hide();
                    $(".layui-bg-red").css("width","");
                    $(".layui-progress-text").text("0%");
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
            if(order_id != ''){
                $.ajax({
                    type:"post",
                    url:"<?=url('house/checkHouseUrl')?>",
                    dataType: 'json',
                    data:{'order_id':order_id,'id':0},
                    success:function (data) {
                        console.log(data);
                        if(data.code >1){
                            layer.alert(data.msg, {icon: 2});
                        }else if(data.code <= 1){
                            layer.alert(data.msg, {icon: 1, time: 1000});
                        }
                    },
                    error:function (error) {
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
                url: '<?php echo url("house/upload2"); ?>',
                size: 1024*5,
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
                    if(res.code ==1){
                        var html = '<div class="item" node-type="imgW" ><div class="operate"><i  class="close layui-icon"></i></div>\n' +
                            '                                                    <span>\n' +
                            '                                                        <img src="../../../' + res.filepath + '" />\n' +
                            '                                                        <input type="hidden" name="images[]" value="' + res.filepath + '" lay-verify="required|imgRegCaseType"  class="img_url" />\n' +
                            '                                                    </span>\n' +
                            '                                                </div>';
                        $('#slide-pc-priview').append(html);
                        refersh();
                    }else{
                        return layer.msg(res.msg);
                    }

                }
            });
        });
        //点击多图上传的X,删除当前的图片
        $("body").on("click",".close",function(){
            $(this).parent().parent('.item').remove();
        });
    </script>
    <script>
        $(document).ready(function(){
            refersh();
        });
        function refersh() {
            var that={
                imgaes:{},
                box:"",
                aveWidth:86,
                aveHeight:86,
                moveObj:'',
                status:false
            }
            var spacingHtml = '<div node-type="spacing"> </div>';
            var C = {
                initState:function(){
                    that.images = $('[node-type="imgW"]');
                    that.box= $('[node-type="box"]');

                }
            }
            var bindDOMFuncs = {
                'imgMouseDown':function(e){
                    //var evt=fixEvent(e);
                    //阻止浏览器默认行为
                    var evt=e;
                    //if(evt.which && evt.button==0){
                    that.follow=true;
                    $(that.images).bind('dragstart',bindDOMFuncs['unDrag']);
                    //}else{
                    //    $(that.images).unbind('dragstart',bindDOMFuncs['unDrag']);
                    //}

                    $(that.images).removeClass('selected');

                    $(this).addClass('selected');

                    $(that.box).append(spacingHtml);
                    //获得要移动的节点
                    that.moveObj = this;

                    $(that.images).bind('mousemove',bindDOMFuncs['imgMouseMove']);
                },
                'imgMouseMove':function(e){
                    if(that.follow){
                        var disX = e.pageX-$(that.box).offset().left;//鼠标位置距离父节点左边的距离
                        var disY = e.pageY-$(that.box).offset().top;//鼠标位置距离父节点上边的距离
                        //判断第一张图片且向左移的情况
                        var posLeft = $(that.moveObj).position().left+that.aveWidth/2;
                        var posTop = $(that.moveObj).position().top;
                        if(that.moveObj){
                            if((that.moveObj == $('[node-type="imgW"]')[0]) && disX<=posLeft && disY<=posTop+that.aveHeight){
                                that.status = false;
                                return;

                            }
                            if((that.moveObj == $('[node-type="imgW"]')[that.images.length-1]) && disX>=posLeft && disY>=posTop){
                                that.status = false;
                                return;


                            }
                        }
                        //确定移动目标位置
                        var colNum = Math.round(disX/that.aveWidth);
                        var rowNum = parseInt(disY/that.aveHeight);
                        var left = colNum*that.aveWidth;
                        var top =  rowNum*that.aveHeight;

                        $('[node-type="spacing"]').css({
                            'left':left+'px',
                            'top':top+'px'
                        });
                        $('[node-type="spacing"]').addClass('spacing');
                        that.status = true;
                    }
                },
                'imgMouseUp':function(e){
                    that.follow=false;
                    if(!that.status){
                        return;
                    }
                    that.status = false;
                    $(that.images).unbind('dragstart',bindDOMFuncs['unDrag']);

                    var sLeft = $('[node-type="spacing"]').position().left;
                    var sTop = $('[node-type="spacing"]').position().top;
                    var xNum = sLeft/that.aveWidth;
                    var yNum = sTop/that.aveHeight;
                    var index = yNum*8+xNum;

                    if(index == 0){
                        var clickObj = $('[node-type="imgW"]')[index];
                        that.moveObj && $(clickObj).before(that.moveObj);
                    }else{
                        var clickObj = $('[node-type="imgW"]')[index-1];
                        that.moveObj && $(clickObj).after(that.moveObj);
                    }
                    $('[node-type="spacing"]').remove();

                    $(that.images).unbind('mousemove',bindDOMFuncs['imgMouseMove']);
                    that.moveObj = null;

                },
                'unDrag':function(e){
                    if(e.stopPropagation){
                        e.preventDefault();
                        e.stopPropagation();
                    }else{
                        e.cancelBubble = true;
                        e.returnValue = false;
                    }
                    return false;
                },
                'imgMouseLeave':function(e){
                    $('[node-type="spacing"]') && $('[node-type="spacing"]').hide();
                },
                'imgMouseEnter':function(e){
                    $('[node-type="spacing"]') && $('[node-type="spacing"]').show();
                },
                'docMouseUp':function(e){
                    $('[node-type="spacing"]') && $('[node-type="spacing"]').remove();
                },
                'imgClick':function(e){
                    if(e.ctrlKey){
                        $(this).addClass('selected');
                        that.moveObj.push(this);
                    }else{
                        //that.moveObj = null;
                        $(that.images).removeClass('selected');
                        $(this).addClass('selected');
                        //that.moveObj = this;
                    }
                }
            }
            var bindDom=function(){
                $(that.images).bind('mousedown',bindDOMFuncs['imgMouseDown']);
                $(that.box).bind('mouseup',bindDOMFuncs['imgMouseUp']);
                $(that.box).bind('mouseenter',bindDOMFuncs['imgMouseEnter']);
                $(that.box).bind('mouseleave',bindDOMFuncs['imgMouseLeave']);
                $(document).bind('mouseup',bindDOMFuncs['docMouseUp']);
                //$(that.images).bind('click',bindDOMFuncs['imgClick']);


            }
            var init = function(){
                C.initState();
                bindDom();
            }
            init();
        }
    </script>