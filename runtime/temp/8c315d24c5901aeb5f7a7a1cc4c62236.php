<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:91:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\house\video.html";i:1597392224;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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

<div class="layui-body">
    <hr/>
    <div style="margin: 10px">
        <div style="padding: 15px;">
            <form class="layui-form">
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend>视频下载</legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label">视频链接</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" id="url" class="layui-input">
                    </div>
                    <span class="layui-btn" id="download">一键下载</span>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    $("#download").click(function () {
        var url = $("#url").val();
        console.log(url);
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