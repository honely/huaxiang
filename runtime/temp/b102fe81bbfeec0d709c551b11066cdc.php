<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:92:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\corp\detaila.html";i:1596610350;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
    .layui-upload-img {
        width: 92px;
        height: 92px;
    }
</style>
<div class="layui-body">
    <div style="padding: 15px;">
        <form class="layui-form layui-form-pane1" action="<?=url('admin/add')?>" method="post">
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['yuangongxm']; ?></label>
                <div class="layui-input-block">
                    <input type="text" name="ad_realname" lay-verify="required|title"  value="<?php echo $admin['ad_realname']; ?>" readonly autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['yuangongjs']; ?></label>
                <div class="layui-input-block">
                    <input type="text" value="<?php echo $admin['ad_roles']; ?>" readonly autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['email']; ?></label>
                <div class="layui-input-block">
                    <input type="text" name="ad_email" id="ad_email" onblur="checkEmail()" autocomplete="off" readonly value="<?php echo $admin['ad_email']; ?>"  class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['phone']; ?></label>
                <div class="layui-input-block">
                    <input type="text" name="ad_phone" value="<?php echo $admin['ad_phone']; ?>"  id="ad_phone" readonly autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-upload">
                <label class="layui-form-label"><?php echo $lable['avatar']; ?></label>
                <div class="layui-input-inline">
                    <img class="layui-upload-img" id="demo1" <?php if($admin['ad_img'] != null): ?>src="../../../<?php echo $admin['ad_img']; ?>"<?php endif; ?> >
                    <p id="demoText"></p>
                </div>
            </div>
            <div class="layui-form-item" pane>
                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['gender']; ?></label>
                <div class="layui-input-block">
                    <input type="radio" name="ad_sex" disabled value="1" title="<?php echo $lable['male']; ?>" <?php if($admin['ad_sex'] == 1): ?>checked<?php endif; ?>>
                    <input type="radio" name="ad_sex" disabled value="2" title="<?php echo $lable['female']; ?>" <?php if($admin['ad_sex'] == 2): ?>checked<?php endif; ?>>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo $lable['company']; ?></label>
                <div class="layui-input-block">
                    <input type="text" name="ad_corp" readonly value="<?php echo $admin['ad_corp']; ?>"  autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo $lable['position']; ?></label>
                <div class="layui-input-block">
                    <input type="text" name="ad_job" readonly value="<?php echo $admin['ad_job']; ?>"  autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label"><?php echo $lable['desc']; ?></label>
                <div class="layui-input-block">
                    <textarea readonly maxlength="500" name="ad_desc" class="layui-textarea"><?php echo $admin['ad_desc']; ?></textarea>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    layui.use(['form','jquery','upload'], function(){
        var form = layui.form
            ,$ = layui.jquery,
            upload = layui.upload;
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