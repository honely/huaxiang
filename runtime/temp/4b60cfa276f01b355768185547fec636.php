<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:91:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\login\login.html";i:1595934702;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>小宝小程序后台</title>
<!--    <link rel="stylesheet" href="__PUBLIC/static/admin.css">-->
    <link rel="stylesheet" href="../../../layui/src/css/layui.css">
    <script src="../../../layui/src/layui.js"></script>
    <style>
        html,body{
            width: 100%;
            height: 100%;
        }
        #login{
            background: #179898;
            widht:100%;
            height: 100%;
            position: relative;
        }
        .login{
            width: 260px;
            position: absolute;
            background: #fff;
            padding: 60px 80px;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin:  auto;
            height: 320px;
        }
        .login h2 {
            font-size: 28px;
            font-weight: 100;
            color: #333;
            text-align: center;
            margin-bottom: 25px;
        }
        .login h4 {
            font-size: 28px;
            font-weight: 100;
            color: #333;
            text-align: center;
            margin-bottom: 25px;
        }
    </style>
</head>
<body id="login">

<div class="login">
    <h2>小宝经纪人平台</h2>
    <h4>Welhome Agent Platform</h4>
    <form class="layui-form" method="post" action="<?=url('login/login')?>">
        <div class="layui-form-item">
            <input type="username" name="username" placeholder="请输入邮箱Input Email" lay-verify="required|email" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-item">
            <input type="password" name="password" placeholder="请输入密码 Password" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-item">
            <button style="padding: 0 113px;" class="layui-btn" lay-submit lay-filter="formDemo">Login</button>
        </div>
        <div class="layui-form-item" style="margin-top: 30px;">
            <div class="layui-word-aux" style="text-align: center !important;">技术支持微信：honely1234</div>
        </div>
    </form>
    <script>
        layui.use('form', function(){
            var form = layui.form;
        });
    </script>
</div>
</body>
</html>