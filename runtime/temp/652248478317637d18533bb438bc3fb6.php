<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:91:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\corp\detail.html";i:1596183550;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
    .logoPre{
        width: 216px;
        height: 150px;
    }
    .casePre{
        display:none;
    }
</style>
<div class="layui-body">
    <div class="layui-tab">
        <div class="layui-tab-content">
            <!--基本信息-->
            <div class="layui-tab-item layui-show">
                <div style="margin: 10px">
                    <div style="padding: 15px;">
                        <form class="layui-form" method="post">
                            <div class="layui-form-item">
                                <label class="layui-form-label"><span style="color: red;">*</span>公司名称</label>
                                <div class="layui-input-block">
                                    <input type="text" name="cp_name" lay-verify="required|title" readonly placeholder="请输入公司名称" value="<?php echo $corp['cp_name']; ?>" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"><span style="color: red;">*</span>ABN</label>
                                <div class="layui-input-block">
                                    <input type="text" name="cp_identity" lay-verify="required|title" placeholder="请输入ABN" readonly value="<?php echo $corp['cp_identity']; ?>"  autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"><span style="color: red;">*</span>公司地址</label>
                                <div class="layui-input-block">
                                    <input type="text" readonly name="cp_address" lay-verify="required|title" placeholder="请输入公司地址" value="<?php echo $corp['cp_address']; ?>"  autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item one-pan">
                                <label class="layui-form-label"><span style="color: red;">*</span>公司logo</label>
                                <div <?php if($corp['cp_logo'] == null): ?>class="layui-upload-drag"<?php endif; ?> style="display:inline-block;" >
                                <image id="logoPre"
                                       <?php if($corp['cp_logo'] == null): else: ?>
                                src="../../../<?php echo $corp['cp_logo']; ?>"
                                class="logoPre"
                                <?php endif; ?>
                                >
                                <input type="hidden" lay-verify="imgReg" name="b_cover" id="b_cover" value="<?php echo $corp['cp_logo']; ?>"/>
                                </image>
                            </div>
                                <div class="one">
                                    <div class="layui-form-mid layui-word-aux" style="margin-left: 39px; ">图片要求，最大800KB，支持JPG/JEPG/PNG格式</div>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"><span style="color: red;">*</span>邮箱</label>
                                <div class="layui-input-block">
                                    <input type="text" readonly name="cp_email" lay-verify="required|title" placeholder="请输入公司邮箱" value="<?php echo $corp['cp_email']; ?>"  autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"><span style="color: red;">*</span>电话</label>
                                <div class="layui-input-block">
                                    <input type="text" readonly name="cp_tel" lay-verify="required|title" placeholder="请输入电话" value="<?php echo $corp['cp_tel']; ?>"  autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item layui-form-text">
                                <label class="layui-form-label">公司简介</label>
                                <div class="layui-input-block">
                                    <textarea placeholder="请输入公司简介" readonly maxlength="500" name="cp_desc" class="layui-textarea"><?php echo $corp['cp_desc']; ?></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    //JavaScript代码区域
    layui.use('element', function(){
        var element = layui.element;

    });
</script>
</body>
</html>