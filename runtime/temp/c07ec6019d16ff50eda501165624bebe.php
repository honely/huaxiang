<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:93:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\account\index.html";i:1595932065;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
        <div style="margin: 20px;">
        <span class="layui-breadcrumb" lay-separator=">">
            <a><?php echo $lable['zhanghuguanli']; ?></a>
            <a><cite><?php echo $lable['gerenziliao']; ?></cite></a>
        </span>
        </div>
    <form class="layui-form bform" style="margin-top: 20px;" id="reform" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" class="layui-input" name="ad_id" value="<?php echo $admin_id; ?>">
        <div class="layui-form-item">
            <label class="layui-form-label"><?php echo $lable['yuanmima']; ?></label>
            <div class="layui-input-inline">
                <input type="password" name="oldPwd" id="oldPwd" lay-verify="require|pass" placeholder="<?php echo $lable['pleaseInput']; ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><?php echo $lable['xinmima']; ?></label>
            <div class="layui-input-inline">
                <input type="password" name="newPwd" id="newPwd" lay-verify="require|pass" placeholder="<?php echo $lable['pleaseInput']; ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><?php echo $lable['rexinmima']; ?></label>
            <div class="layui-input-inline">
                <input type="password" name="newPwd2" id="newPwd2" lay-verify="require|pass" placeholder="<?php echo $lable['pleaseInput']; ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <span class="layui-btn" onclick="resetPwd(this)" id="sub"><?php echo $lable['querenxiugai']; ?></span>
            </div>
        </div>
    </form>
    </div>
</div>
<script>
    layui.use(['element','jquery','layer'], function(){
        var element = layui.element,
            $ = layui.jquery,
            layer = layui.layer;
    });
    function resetPwd(e) {
        $.ajax({
            'type':"post",
            'url':"<?=url('index/resetpass')?>",
            'data':$("#reform").serialize(),
            'success':function (result) {
                if(result.code < 1){
                    layer.msg(result.msg);
                }else {
                    layer.msg(result.msg);
                    layer.open({
                        title: '信息'
                        ,content: result.msg
                        ,yes: function(index, layero){
                            layer.close(index);
                            window.parent.location.reload();
                        }
                        ,cancel:function (index, layero) {
                            layer.close(index);
                            window.parent.location.reload();
                        }
                    });
                }
            },
            'error':function () {
                console.log('error');
            }
        })
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