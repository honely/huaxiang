<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:92:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\mate\details.html";i:1587035206;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
    <div style="margin: 10px">
        <div style="padding: 15px;">
            <form class="layui-form" action="" method="post">
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>标题</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['title']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>城市</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['city']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">帖子编号</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['dsn']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">昵称</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['real_name']; ?>" class="layui-input">
                        <img src="<?php echo $house['avaurl']; ?>" alt="" style="width: 100px;height: 100px;">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">性别</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['sex']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">年龄</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['age']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">是否接受宠物</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['pet']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">是否接受吸烟</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['smoke']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">生活习惯</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['habit']; ?>" class="layui-input">
                    </div>
                </div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend>理想房源</legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label">预算</label>
                    <div class="layui-input-block">
                        <input type="text" readonly value="<?php echo $house['price']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">入住时间</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['live_date']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">租期</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['lease_term']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">微信号</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['wchat']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">手机号</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['tel']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">是否有房</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['if_house']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">邮箱</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['email']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">个性签名</label>
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