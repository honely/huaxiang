<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:93:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\account\email.html";i:1595853914;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
        <form class="layui-form layui-form-pane1">
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['newe']; ?></label>
                <div class="layui-input-inline">
                    <input type="text" name="ad_email" id="ad_email" lay-verify="required|email" placeholder="<?php echo $lable['pleaseInput']; ?>" autocomplete="off" value="" class="layui-input">
                </div>
                <div class="layui-input-inline">
                    <span class="layui-btn layui-btn-sm layui-btn-normal" id="dyMobileButton"><?php echo $lable['fasong']; ?></span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['yanzhengma']; ?></label>
                <div class="layui-input-inline">
                    <input type="text" name="ucode" id="ucode" lay-verify="required|title" placeholder="<?php echo $lable['pleaseInput']; ?>" autocomplete="off" value="" class="layui-input">
                    <input type="text" name="code" id="code" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <span class="layui-btn" lay-submit onclick="closeAlls()"><?php echo $lable['cemail']; ?></span>
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
        //自定义验证规则
        form.verify({
            title: function(value){
                if(value.length < 2){
                    return '至少得2个字符啊';
                }
            }
        });

    });
    function closeAlls(){
        var ad_email = $('#ad_email').val();
        var code = $('#code').val();
        var ucode = $('#ucode').val();
        if(code == ''){
            return layer.msg('验证码不为空！');
        }
        $.ajax({
            type: 'get',
            url: "<?=url('account/changemail')?>?ad_email="+ad_email+ "&code="+code+ "&ucode="+ucode,
            dataType:  'json',
            success: function(data){
                layer.msg(data.msg,{
                    time: 2000
                },function () {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    parent.location.reload();
                });
            }
        });
    }
</script>
<script>
    let vercode	 = 0;
    let time = 60;
    let flag = true;   //设置点击标记，防止60内再次点击生效

    //发送验证码
    $('#dyMobileButton').click(function(){
        $(this).attr("disabled",true);
        var ad_email = $('#ad_email').val();
        var emailPat =  /^([a-zA-Z\d])(\w|\-)+@[a-zA-Z\d]+\.[a-zA-Z]{2,4}$/;
        if (!emailPat.test(ad_email)) {
            return layer.msg('邮箱格式不正确');
        }
        if(flag){
            let timer = setInterval(function () {

                if(time == 60 && flag){
                    flag = false;

                    $.ajax({
                        type : 'get',
                        async : false,
                        url : "<?=url('account/mailto')?>?email="+ad_email,
                        dataType:"json",
                        success : function(data) {
                            if(data.code > 0){
                                console.log(data);
                                layer.msg(data.msg);
                                $('#code').val(data.data.code);
                                $("#dyMobileButton").html("已发送");
                            }else {
                                layer.msg(data.msg);
                                flag = true;
                                time = 60;
                                clearInterval(timer);
                            }
                        }
                    });
                }else if(time == 0){
                    $("#dyMobileButton").removeAttr("disabled");
                    $("#dyMobileButton").html("免费获取验证码");
                    clearInterval(timer);
                    time = 60;
                    flag = true;
                }else {
                    $("#dyMobileButton").html(time + " s 重新发送");
                    time--;
                }
            },1000);
        }

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