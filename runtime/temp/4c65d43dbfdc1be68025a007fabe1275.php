<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:90:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\house\edit.html";i:1600741289;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
    .notclick{
        pointer-events: none;
    }
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
        <?php if($type == 1): ?>
         <a href="<?=url('house/index')?>"><?php echo $lable['houselist']; ?></a>
        <?php else: ?>
         <a href="<?=url('house/myhouse')?>"><?php echo $lable['myhouse']; ?></a>
        <?php endif; ?>
        <a><cite><?php echo $lable['edit']; ?></cite></a>
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
            <form class="layui-form" id="myForm" action="<?=url('house/edit')?>?id=<?php echo $house['id']; ?>&type=<?php echo $type; ?>" method="post">
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['basicInfo']; ?></legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['houseName']; ?></label>
                    <div class="layui-input-block">
                        <input type="text" name="title" lay-verify="required|title" placeholder="<?php echo $lable['houseNameP']; ?>" maxlength="100"  autocomplete="off" value="<?php echo $house['title']; ?>" class="layui-input">
                        <input type="hidden" value="<?php echo $house['id']; ?>" id="id" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['houseAddr']; ?></label>
                    <div class="layui-input-inline" style="width: 120px;margin-right: 0px;">
                        <input type="text" class="layui-input" name="street" placeholder="Room Number" value="<?php echo $house['street']; ?>" >
                    </div>
                    <div class="layui-input-inline" style="width: 450px;">
                        <input type="text" name="address" id="end" autocomplete="off" class="layui-input" placeholder="<?php echo $lable['houseAddP']; ?>" lay-verify="required|addresss"  value="<?php echo $house['address']; ?>" >
                        <input type="text" name="address" id="address" style="display: none" readonly class="layui-input" lay-verify="required|addresss" value="<?php echo $house['address']; ?>"  placeholder="目的地取值">

                        <input type="hidden" name="x" id="x" lay-verify="addres"  autocomplete="off" class="layui-input" value="<?php echo $house['x']; ?>" >
                        <input type="hidden" name="y" id="y" lay-verify="addres"  autocomplete="off" class="layui-input" value="<?php echo $house['y']; ?>" >
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
                        <input type="text" name="http"  placeholder="<?php echo $lable['houseUrlP']; ?>" autocomplete="off" value="<?php echo $house['http']; ?>" class="layui-input" id="orderHouse" onblur="checkHouseUrl()">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['city']; ?></label>
                    <div class="layui-input-inline">
                        <input type="text" id="city" lay-verify="required|title" value="<?php echo $house['citys']; ?>" readonly class="layui-input">
                        <input type="hidden" name="city" id="citys" lay-verify="required|title" value="<?php echo $house['city']; ?>" readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['rent']; ?></label>
                    <div class="layui-input-inline" style="width: 230px !important;">
                        <input type="number" <?php if($house['price'] == -1): ?>min="-1"<?php else: ?>min="0"<?php endif; ?>  max="9999" name="price" lay-verify="required|prices" placeholder="<?php echo $lable['rentPriceP']; ?>" style="display:<?php if($house['price'] == -1): ?>none<?php else: ?>block<?php endif; ?>" id="price" onblur="checkprice()" value="<?php echo $house['price']; ?>" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline">
                        <input type="checkbox" lay-skin="switch" lay-filter="switchRent" lay-text="<?php echo $lable['zujinkeyi']; ?>|<?php echo $lable['zujinkeyi']; ?>" <?php if($house['price'] == -1): ?>checked<?php else: endif; ?>>
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['rendetail']; ?></legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['livetime']; ?></label>
                    <div class="layui-input-inline">
                        <input type="text" readonly name="live_date" id="date" lay-verify="date" lay-verify="required" style="display:<?php if($house['live_date_show'] == 1): ?>none<?php else: ?>block<?php endif; ?>" placeholder="<?php echo $lable['liveDateP']; ?>" value="<?php echo $house['live_date']; ?>" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline">
                        <input type="checkbox" lay-skin="switch" lay-filter="switchTest" lay-text="<?php echo $lable['anytime']; ?>|<?php echo $lable['anytime']; ?>" <?php if($house['live_date_show'] == 1): ?>checked<?php else: endif; ?> >
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label" style="width: 90px !important;"><?php echo $lable['liveterm']; ?></label>
                    <div class="layui-input-block">
                        <?php if(is_array($all_term) || $all_term instanceof \think\Collection || $all_term instanceof \think\Paginator): $i = 0; $__LIST__ = $all_term;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" lay-skin="primary" name="lease_term[<?php echo $vo['term']; ?>]" title="<?php echo $vo['term']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['source']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="source" value="中介" title="<?php echo $lable['inter']; ?>" <?php if($house['source'] == '中介'): ?>checked<?php endif; ?>>
                        <input type="radio" name="source" value="学生公寓" title="<?php echo $lable['studentApt']; ?>" <?php if($house['source'] == '学生公寓'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['rentype']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="type" value="整租" title="<?php echo $lable['zhengzu']; ?>" <?php if($house['type'] == '整租'): ?>checked<?php endif; ?>>
                        <input type="radio" name="type" value="合租" title="<?php echo $lable['hezu']; ?>" <?php if($house['type'] == '合租'): ?>checked<?php endif; ?>>
                        <input type="hidden" id="roomate" value="<?php if($house['type'] == '整租'): ?>1<?php else: ?>2<?php endif; ?>">
                    </div>
                </div>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['xingbie']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="sex" value="不限" title="<?php echo $lable['xingbiebuxian']; ?>" <?php if($house['sex'] == '不限'): ?>checked<?php endif; ?>>
                        <input type="radio" name="sex" value="男" title="<?php echo $lable['xiannanxing']; ?>" <?php if($house['sex'] == '男'): ?>checked<?php endif; ?>>
                        <input type="radio" name="sex" value="女" title="<?php echo $lable['xiannvxing']; ?>" <?php if($house['sex'] == '女'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['pet']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="pet" value="不接受" title="<?php echo $lable['petDis']; ?>" <?php if($house['pet'] == '不接受'): ?>checked<?php endif; ?>>
                        <input type="radio" name="pet" value="接受" title="<?php echo $lable['petAcc']; ?>" <?php if($house['pet'] == '接受'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['shifoujiaju']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="is_fur" value="否" title="<?php echo $lable['bujiaju']; ?>" <?php if($house['is_fur'] == '否'): ?>checked<?php endif; ?>>
                        <input type="radio" name="is_fur" value="是" title="<?php echo $lable['baojiaju']; ?>" <?php if($house['is_fur'] == '是'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span>可否吸烟</label>
                    <div class="layui-input-block">
                        <input type="radio" name="smoke" value="不可" title="不可" <?php if($house['smoke'] == '不可'): ?>checked<?php endif; ?>>
                        <input type="radio" name="smoke" value="可以" title="可以" <?php if($house['smoke'] == '可以'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span>接受情侣</label>
                    <div class="layui-input-block">
                        <input type="radio" name="is_couple" value="不接受" title="不接受" <?php if($house['is_couple'] == '不接受'): ?>checked<?php endif; ?>>
                        <input type="radio" name="is_couple" value="接受" title="接受" <?php if($house['is_couple'] == '接受'): ?>checked<?php endif; ?>>

                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label"><?php echo $lable['bill']; ?></label>
                    <div class="layui-input-block">
                        <?php if(is_array($all_bill) || $all_bill instanceof \think\Collection || $all_bill instanceof \think\Paginator): $i = 0; $__LIST__ = $all_bill;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" lay-skin="primary" name="bill[<?php echo $vo['bill']; ?>]" title="<?php echo $vo['billtitle']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['housedetail']; ?></legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['houseType']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="house_type" value="公寓" title="<?php echo $lable['apt']; ?>" <?php if($house['house_type'] == '公寓'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_type" value="别墅" title="<?php echo $lable['bieshu']; ?>"  <?php if($house['house_type'] == '别墅'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_type" value="联排别墅" title="<?php echo $lable['lianpaibieshu']; ?>"  <?php if($house['house_type'] == '联排别墅'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['huxing']; ?></label>
                    <div class="layui-input-block">
                        <input type="radio" name="house_room" value="Studio" title="Studio" <?php if($house['house_room'] == 'Studio'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" value="1" title="1" <?php if($house['house_room'] == '1'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" value="2" title="2" <?php if($house['house_room'] == '2'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" value="3" title="3" <?php if($house['house_room'] == '3'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" value="4" title="4" <?php if($house['house_room'] == '4'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" value="5" title="5" <?php if($house['house_room'] == '5'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" value="6" title="6" <?php if($house['house_room'] == '6'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" value="7" title="7" <?php if($house['house_room'] == '7'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" value="8" title="8" <?php if($house['house_room'] == '8'): ?>checked<?php endif; ?>>
                        <input type="radio" name="house_room" value="9" title="9" <?php if($house['house_room'] == '9'): ?>checked<?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['weishengjian']; ?></label>
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
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['car']; ?></label>
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
                <div class="layui-form-item entire">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['jiaju']; ?></label>
                    <div class="layui-input-block">
                        <?php if(is_array($all_four) || $all_four instanceof \think\Collection || $all_four instanceof \think\Paginator): $i = 0; $__LIST__ = $all_four;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" lay-skin="primary" name="home[<?php echo $vo['furn']; ?>]" title="<?php echo $vo['transtitle']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>

                <div class="layui-form-item entire" pane="">
                    <label class="layui-form-label"><?php echo $lable['sheshi']; ?></label>
                    <div class="layui-input-block">
                        <?php if(is_array($all_set) || $all_set instanceof \think\Collection || $all_set instanceof \think\Paginator): $i = 0; $__LIST__ = $all_set;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" lay-skin="primary" name="furniture[<?php echo $vo['set']; ?>]" title="<?php echo $vo['setitle']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label"><?php echo $lable['biaoqian']; ?></label>
                    <div class="layui-input-block">
                        <?php if(is_array($tags) || $tags instanceof \think\Collection || $tags instanceof \think\Paginator): $i = 0; $__LIST__ = $tags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox tags"  lay-verify="required|des_tanlent" lay-skin="primary" name="tags[<?php echo $vo['name']; ?>]" title="<?php echo $vo['sname']; ?>" <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span>室友数量</label>
                    <div class="layui-input-block">
                        <input type="radio" name="roomates" value="0" title="0" <?php if($house['roomates'] == '0'): ?>checked<?php endif; ?>>
                        <input type="radio" name="roomates" value="1" title="1" <?php if($house['roomates'] == '1'): ?>checked<?php endif; ?>>
                        <input type="radio" name="roomates" value="2" title="2" <?php if($house['roomates'] == '2'): ?>checked<?php endif; ?>>
                        <input type="radio" name="roomates" value="3" title="3" <?php if($house['roomates'] == '3'): ?>checked<?php endif; ?>>
                        <input type="radio" name="roomates" value="4" title="4" <?php if($house['roomates'] == '4'): ?>checked<?php endif; ?>>
                        <input type="radio" name="roomates" value="5" title="5" <?php if($house['roomates'] == '5'): ?>checked<?php endif; ?>>
                        <input type="radio" name="roomates" value="6" title="6" <?php if($house['roomates'] == '6'): ?>checked<?php endif; ?>>
                        <input type="radio" name="roomates" value="7" title="7" <?php if($house['roomates'] == '7'): ?>checked<?php endif; ?>>
                        <input type="radio" name="roomates" value="8" title="8" <?php if($house['roomates'] == '8'): ?>checked<?php endif; ?>>
                        <input type="radio" name="roomates" value="9" title="9" <?php if($house['roomates'] == '9'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title roomate" style="margin-top: 20px;">
                    <legend>房东概况</legend>
                </fieldset>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['loadJob']; ?></label>
                    <div class="layui-input-block">
                        <input type="text" name="loard_job" value="<?php echo $house['loard_job']; ?>" maxlength="10" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span>房东性别</label>
                    <div class="layui-input-block">
                        <input type="radio" name="loard_sex" value="1" title="男" <?php if($house['loard_sex'] == 1): ?>checked<?php endif; ?>>
                        <input type="radio" name="loard_sex" value="2" title="女" <?php if($house['loard_sex'] == 2): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span>是否吸烟</label>
                    <div class="layui-input-block">
                        <input type="radio" name="loard_smoke" value="否" title="否" <?php if($house['loard_smoke'] == '否'): ?>checked<?php endif; ?>>
                        <input type="radio" name="loard_smoke" value="是" title="是" <?php if($house['loard_smoke'] == '是'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item roomate">
                    <label class="layui-form-label"><span style="color: red;">*</span>可有宠物</label>
                    <div class="layui-input-block">
                        <input type="radio" name="loard_pet" value="无" title="无" <?php if($house['loard_pet'] == '无'): ?>checked<?php endif; ?>>
                        <input type="radio" name="loard_pet" value="有" title="有" <?php if($house['loard_pet'] == '有'): ?>checked<?php endif; ?>>
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['jianjie']; ?></legend>
                </fieldset>
                <div style="margin:0 auto !important;color: red !important;clear:both;text-align: center"><?php echo $lable['transNoticNew']; ?></div>
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
                                <textarea placeholder="<?php echo $lable['transPlaceEn']; ?>" style="height: 400px;" maxlength="4000" name="econtent"  lay-verify="required" id="english" class="layui-textarea"><?php echo $house['econtent']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-xs6">
                        <div class="grid-demo">
                            <div class="layui-input-block" style="margin-left: 25px !important;">
                                <textarea placeholder="<?php echo $lable['transPlaceCn']; ?>" lay-verify="required"  style="height: 400px;" maxlength="800" name="content" id="chinese" class="layui-textarea"><?php echo $house['content']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $lable['lianxi']; ?></legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>Company</label>
                    <div class="layui-input-inline">
                        <select name="corp" lay-filter="selectPm"  lay-search="" >
                            <option value="">Please Select</option>
                            <?php if(is_array($corp) || $corp instanceof \think\Collection || $corp instanceof \think\Paginator): $i = 0; $__LIST__ = $corp;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vo['cp_id']; ?>"  <?php if($house['corp'] == $vo['cp_id']): ?>selected<?php endif; ?>><?php echo $vo['cp_name']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <label class="layui-form-label" style="width: 150px !important;"><span style="color: red;">*</span>PM</label>
                    <div class="layui-input-inline" style="width: 250px !important;">
                        <select name="pm" lay-verify="required" lay-filter="selectPmInfo"  id="pm"  lay-search="">
                            <option value="">Please Select</option>
                            <?php if(is_array($pminfo) || $pminfo instanceof \think\Collection || $pminfo instanceof \think\Paginator): $i = 0; $__LIST__ = $pminfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vo['ad_id']; ?>"  <?php if($house['pm'] == $vo['ad_id']): ?>selected<?php endif; ?>><?php echo $vo['ad_realname']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['xingming']; ?></label>
                    <div class="layui-input-block">
                        <input type="text" name="real_name" id="real_name" lay-verify="required|title"  value="<?php echo $house['real_name']; ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['dianhua']; ?></label>
                    <div class="layui-input-block">
                        <input type="text" name="tel" id="tel" lay-verify="required" value="<?php echo $house['tel']; ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><?php echo $lable['youxiang']; ?></label>
                    <div class="layui-input-block">
                        <input type="text" name="email" id="email" lay-verify="emails" value="<?php echo $house['email']; ?>" autocomplete="off" class="layui-input">
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
                                <image id="logoPreimg" class="logoPreimg" style="width: 91%;height: 251px;" <?php if($house['thumnail'] == null): else: ?>
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
                                                <?php if($house['images'] != null): if(is_array($house['images1']) || $house['images1'] instanceof \think\Collection || $house['images1'] instanceof \think\Paginator): $k = 0; $__LIST__ = $house['images1'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($k % 2 );++$k;?>
                                                <div class="item" node-type="imgW" ><div class="operate"><i  class="close layui-icon"></i></div>
                                                    <span>
                                                        <img src="../../../<?php echo $item; ?>" />
                                                        <input type="hidden" name="images[]" value="<?php echo $item; ?>" lay-verify="required|imgRegCaseType"  class="img_url" />
                                                    </span>
                                                </div>
                                                <?php endforeach; endif; else: echo "" ;endif; else: ?>
                                                NoData
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                <div class="layui-btn upBtn <?php if($house['video'] != null): ?>notclick<?php endif; ?>" style="margin-left: 40px;">Upload</div>
                <div class="layui-btn layui-btn-primary urlBtn <?php if($house['video'] != null): ?>notclick<?php endif; ?>" style="margin-left: 40px;">Video Url</div>
                <br>
                <div class="layui-form-mid layui-word-aux upNotice" style="margin-left: 40px;"><?php echo $lable['otherNotic']; ?></div>
                <div class="layui-form-mid layui-word-aux urlNotice" style="margin-left: 40px;display: none">5 minutes maxsize，40MB maximum Size</div>

                <div class="layui-form-item one-pan one-video" style="margin-left: 40px;">
                    <div class="layui-upload-drag" id="uploadLogo" style="padding: 50px;display: inline-block;">
                        <?php if($house['video'] != null): ?>
                        <video id="logoPre" controls="controls" autobuffer="autobuffer" style="width: 335px;height: 215px;" autoplay="autoplay" loop="loop" src="<?php if($house['video'] != null): ?>../../../<?php echo $house['video']; else: endif; ?>">
                            <input type="hidden" name="video" id="video" value="<?php if($house['video'] != null): ?><?php echo $house['video']; else: endif; ?>"/>
                        </video>
                        <div id="vidDel" style="position: absolute;left: 60px;top: 18px;color: red;cursor: pointer;"><?php echo $lable['delete']; ?></div>
                        <div id="display" style="display: none">
                            <i class="layui-icon"></i>
                            <p><?php echo $lable['xuanzeshipim']; ?></p>
                        </div>
                        <?php else: ?>
                        <video id="logoPre" style="display: none" controls="controls" autobuffer="autobuffer"  autoplay="autoplay" loop="loop" src="">
                            <input type="hidden" name="video" id="video" value=""/>
                        </video>
                        <div id="jdT" style="width:200px;height:18px;position: absolute;top: 157px;left: 113px;display:none;">
                            <div class="layui-progress layui-progress-big" lay-showPercent="true" lay-filter="demo">
                                <div class="layui-progress-bar layui-bg-red" lay-percent="0%"></div>
                            </div>
                        </div>
                        <div id="vidDel" style="position: absolute;left: 60px;top: 18px;color: red;display: none;cursor: pointer;"><?php echo $lable['delete']; ?></div>
                        <div id="display">
                            <i class="layui-icon"></i>
                            <p><?php echo $lable['xuanzeshipim']; ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="layui-btn layui-btn-sm uploadLogo" style="margin-left: 20px;<?php if($house['video'] != null): ?>display: none<?php endif; ?>" id="choiceVid" ><?php echo $lable['shangchuan']; ?></div>
                    <div class="layui-btn layui-btn-sm" id="upload-video" style="margin-left: 20px;display: none" ><?php echo $lable['shangchuan']; ?></div>
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
                            <input type="text" id="urlUpload"  placeholder="Youtube link or Bilibili link" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-btn layui-btn-sm urlUploadLogo" style="margin-left: 20px;" id="uChoiceVid" ><?php echo $lable['shangchuan']; ?></div>
                    <br/>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-inline" style="width: 270px;margin-left: 40px;">
                        <button class="layui-btn" lay-submit><?php echo $lable['fabu']; ?></button>
                        <span class="layui-btn layui-btn-primary" id="saveinfo" ><?php echo $lable['baocun']; ?></span>
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
                        $(".upBtn").addClass("notclick");
                        $(".urlBtn").addClass("notclick");
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
            $(".upBtn").removeClass("notclick");
            $(".urlBtn").removeClass("notclick");
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
            //upload.render();
            //event.stopPropagation();                                           //禁止冒泡
        });
        //保存不更新状态
        $('#saveinfo').click(function () {
            $.ajax({
                type: 'POST',
                url: "<?=url('house/edit')?>?status=1&id=<?php echo $house['id']; ?>&type=<?php echo $type; ?>",
                data:$('#myForm').serialize(),
                dataType:  'json',
                success: function(data){
                    if(data.code == 1){
                        console.log(data);
                        layer.msg(data.msg);
                        window.location.href=data.url;
                    }else{
                        layer.msg(data.msg);
                    }
                }
            });
        });
        $('.transLate').click(function () {
            var type = $('#isTrans').val();
            var to = $(this).data('type');
            var contents = '';
            if(type == 1){
                contents = $("#contents").val();
            }else{
                if(to == 'en'){
                    contents = $("#chinese").val();
                }else{
                    contents = $("#english").val();
                }
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
                    $('#preTrans').hide();
                    $('#isTrans').val(2);
                    $('#translate').show();
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
                    $('#price').val('-1');
                    $('#price').removeAttr('min');
                    $('#price').hide();
                }else{
                    $('#price').show();
                }
            });
            //自定义验证规则
            form.verify({
                title: function(value){
                    if(value.length < 2){
                        return 'Minimum 2 letters';
                    }
                },addres: function(value){
                    if(!value){
                        return 'Please enter correct Address and Select form options！';
                    }
                },prices: function(value){
                    if(value <-1){
                        return 'Price is more than 0！';
                    }
                },addresss: function(value){
                    var values = value.split(',');
                    if(values.length < 3){
                        return 'Please enter correct Address！';
                    }
                }
                ,imgReg:function (value) {
                    if(value.length <= 0){
                        return 'Please Upload Cover Images';
                    }
                }
                ,imgRegCaseType:function () {
                    var len = $(".img_url").length;
                    var types = $("#roomate").val();
                    if(types == 2){
                        if (len < 2) {
                            return "至少上传3张房源图片";
                        }
                    }
                    if (len > 16) {
                        return "房源图片不超过16张";
                    }
                }
                ,urlTest:function(value){
                    if(value.length >0 ){
                        var Expression=/http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
                        if(Expression.test(value)){
                        }else{
                            return "Please enter Correct Urls！";
                        }
                    }
                }
                ,des_tanlent:function () {
                    var len = $(".tags:checked").length;
                    if (len > 6) {
                        return "Maxinum 6 tags？";
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
                    layer.close(layer.msg());//关闭上传提示窗口
                    if(res.code == 0) {
                        return layer.msg(res.msg, {icon: 2});
                    }
                    $('#uploadImg').removeClass('layui-upload-drag');
                    $('#logoPreimg').css('width','91%');
                    $('#logoPreimg').css('height','251px');
                    $('#logoPreimg').attr('src',"../../../"+res.filepath);
                    $('#displayImg').hide();
                    console.log(res);
                    $('#thumnail').val('' +res.filepath + '');
                }
            });

            //视频上传
            upload.render({
                elem: '.uploadLogo'
                ,auto:false
                ,url: '<?php echo url("house/upload"); ?>'
                ,size:25600 //限制文件大小，单位 KB
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
                    console.log("执行上传视频选择");
                    obj.preview(function(index, file, result){
                        console.log("预览视频");
                        let url = URL.createObjectURL(file);
                        $('#logoPre').show();
                        // 删除显示
                        $('#vidDel').show();
                        $(".upBtn").addClass("notclick");
                        $(".urlBtn").addClass("notclick");
                        // 上传显示，选择隐藏
                        // $('#upload-video').show();
                        $('#choiceVid').hide();
                        $('#display').hide();
                        $('#uploadLogo').removeClass('layui-upload-drag');
                        $('#logoPre').css('width','335px');
                        $('#logoPre').css('height','251px');
                        $('#logoPre').attr('src', url);
                        let timer = setTimeout(function(){
                            console.log(1111111);
                            layer.close(layer.index);
                            let video_time = document.getElementById("logoPre").duration;
                            console.log(video_time);
                            if(video_time >= 90) {
                                $('#vidDel').hide();                                               //删除按钮隐藏
                                $(".upBtn").removeClass("notclick");
                                $(".urlBtn").removeClass("notclick");
                                $("#jdT").hide();
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
                                return layer.msg('上传视频不能超过120秒', {icon: 2});
                            }else{
                                $("#jdT").show();
                                $('#logoPre').attr('autoplay', 'autoplay');
                                console.log("定时器执行，上传点击事件");
                                $('#upload-video').click();
                            }
                            clearTimeout(timer);
                        },1000);
                    });
                }
                ,before: function(input){
                    loading = layer.load(2, {
                        shade: [0.2,'#000']
                    });
                    console.log(input)
                }
                ,done: function(res){
                    console.log(res);
                    if(res.code == 1){
                        layer.msg(res.msg);
                        console.log(res.filepath);
                        $('#logoPre').removeAttr('src');
                        $('#video').val('');
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
                    }else{
                        $('#vidDel').hide();                                               //删除按钮隐藏
                        $(".upBtn").removeClass("notclick");
                        $(".urlBtn").removeClass("notclick");
                        $("#jdT").hide();
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
                        layer.close(loading);
                        return layer.msg('shangchuancuowu', {icon: 2});
                    }
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

        // 视频删除,样式重置，上传视频初始化
        $('#vidDel').click(function(event){
            layui.use(['upload'], function(){
                var upload = layui.upload;
                console.log("执行删除");
                $('#vidDel').hide();                                               //删除按钮隐藏
                $(".upBtn").removeClass("notclick");
                $(".urlBtn").removeClass("notclick");
                $("#jdT").hide();
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
                event.stopPropagation();
            })
        });
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
        
         function checkprice(){
            var price = $('#price').val();
            if(price > 9999){
               layer.alert('租金不超过9999', {icon: 2});
               $('#price').val('');
            }

        }
        layui.use('upload', function(){
            var $ = layui.jquery;
            var upload = layui.upload;
            upload.render({
                elem: '#slide-pc',
                url: '<?php echo url("house/upload"); ?>',
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
                    console.log(res);
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
            var houseType = '<?php echo $house['type']; ?>';
            if(houseType == '合租'){
                $('.roomate').show();
                $('.entire').hide();
            }else{
                $('.roomate').hide();
                $('.entire').show();
            }
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