<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:93:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\account\phone.html";i:1591358421;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591172124;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1583744281;}*/ ?>
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
                <label class="layui-form-label"><span style="color: red;">*</span>新手机号</label>
                <div class="layui-input-inline">
                    <input type="text" name="ad_phone" lay-verify="required|title" placeholder="请输入手机号" autocomplete="off" id="ad_phone" class="layui-input">
                </div>
                <div class="layui-input-inline">
                    <span class="layui-btn layui-btn-sm layui-btn-normal" id="dyMobileButton" >发送验证码</span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>验证码</label>
                <div class="layui-input-inline">
                    <input type="text" name="ucode" id="ucode" lay-verify="required|title" placeholder="请输入验证码" autocomplete="off" value="" class="layui-input">
                    <input type="text" name="code" id="code" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <span class="layui-btn" lay-submit onclick="closeAlls()">修改</span>
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
        var ad_phone = $('#ad_phone').val();
        var code = $('#code').val();
        var ucode = $('#ucode').val();
        if(code == ''){
            return layer.msg('验证码不为空！');
        }
        $.ajax({
            type: 'get',
            url: "<?=url('account/changePhone')?>?&ad_phone="+ad_phone+ "&code="+code+ "&ucode="+ucode,
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
        var phone = $('#ad_phone').val();
        if(flag){
            let timer = setInterval(function () {

                if(time == 60 && flag){
                    flag = false;

                    $.ajax({
                        type : 'get',
                        async : false,
                        url : "<?=url('account/sendMsg')?>?phone="+phone,
                        dataType:"json",
                        success : function(data) {
                            if(data.code > 0){
                                console.log(data);
                                layer.msg(data.msg);
                                $('#code').val(data.data);
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

    //手机号注册
    $('input[name= "submit_phone"]').click(function(){
        var  reader_com_check  = $('#reader-me').attr("checked");
//            if(reader_com_check != true) {
//                alert("请先点击确认商城服务协议再进行注册");
//                return false;
//			}
        var code = $('#code').val();
        if(vercode != code) {
            alert("请输入正确的验证码");
            $('#code').val("");
        }else {
            var phone = $('#phone').val();
            var password = $('#password1').val();
            var passwordRepeat = $('#passwordRepeat1').val();
            if(password != passwordRepeat){
                alert("您输入的密码不一致，请从新输入");
                $('#password1').val("");
                $('#passwordRepeat1').val("");
                return false;
            }
            var form = new FormData();
            form.append("phone", phone);
            form.append("password", password);

            $.ajax({
                url:"register.do",
                type:"post",
                data:form,
                processData:false,
                contentType:false,
                success:function(data){
                    if(data.status == 0){
                        alert(data.msg);
                        window.location.href = "init_login_page.do";
                    }else if(data.status == 1){
                        alert(data.msg);
                    }

                },
                error:function(e){
                    alert("错误提交！");

                }
            });
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