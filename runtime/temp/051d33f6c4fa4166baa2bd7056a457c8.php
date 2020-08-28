<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:94:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\forent\details.html";i:1598524447;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
                    <label class="layui-form-label"><span style="color: red;">*</span>地区</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['area']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: red;">*</span>学校</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['school']; ?>" class="layui-input">
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
                    <label class="layui-form-label">入住时间</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['livedate']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">租期</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['leaseterm']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">包含家具</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['isfur']; ?>" class="layui-input">
                    </div>
                </div>   <div class="layui-form-item">
                    <label class="layui-form-label">是否为留学生</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['istudent']; ?>" class="layui-input">
                    </div>
                </div>   <div class="layui-form-item">
                    <label class="layui-form-label">发布人职业</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['myjob']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">微信号</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['wechat']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">类型</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['type']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">微信号</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['wechat']; ?>" class="layui-input">
                    </div>
                </div><div class="layui-form-item">
                    <label class="layui-form-label">点赞量</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['likes']; ?>" class="layui-input">
                    </div>
                </div><div class="layui-form-item">
                    <label class="layui-form-label">浏览量</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['view']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">我的标签</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['mytags']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">户型</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['room']; ?>" class="layui-input">
                    </div>
                </div> <div class="layui-form-item">
                    <label class="layui-form-label">创建时间</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['cdate']; ?>" class="layui-input">
                    </div>
                </div> <div class="layui-form-item">
                    <label class="layui-form-label">修改时间</label>
                    <div class="layui-input-block">
                        <input type="text" readonly lay-verify="required|title" value="<?php echo $house['mdate']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">描述</label>
                    <div class="layui-input-block">
                        <textarea readonly class="layui-textarea"><?php echo $house['desc']; ?></textarea>
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