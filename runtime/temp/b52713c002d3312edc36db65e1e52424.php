<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:93:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\ruser\details.html";i:1602657429;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="../../../layui/src/css/layui.css">
    <script src="../../../static/jquery-1.10.2.min.js"></script>
    <script src="../../../layui/src/layui.js"></script>
</head>
<form class="layui-form" action="" id="cusInfo" method="post">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>用户信息</legend>
    </fieldset>
    <div class="layui-form-item" style="margin:50px">
        <div class="layui-form-item">
        <div class="layui-form-mid layui-word-aux">id: <?php echo $cus['id']; ?></div>
        </div>
        <div class="layui-form-item">
        <div class="layui-form-mid layui-word-aux">昵称: <?php echo $cus['nickname']; ?></div>
        </div>
        <div class="layui-form-item">
        <div class="layui-form-mid layui-word-aux">图像:
            <img style="width: 60px;height: 60px;" src="<?php echo $cus['avaurl']; ?>" alt="<?php echo $cus['nickname']; ?>">
        </div>
        </div>
        <div class="layui-form-item">
        <div class="layui-form-mid layui-word-aux">性别:<?php echo $cus['sex']; ?></div>
        </div>
        <div class="layui-form-item">
            <div class="layui-form-mid layui-word-aux">微信:<?php echo $cus['wchat']; ?></div>
        </div>
      <div class="layui-form-item">
            <div class="layui-form-mid layui-word-aux">电话:<?php echo $cus['tel']; ?></div>
        </div>
        <div class="layui-form-item">
        <div class="layui-form-mid layui-word-aux">生日:<?php echo $cus['birth']; ?></div>
        </div>
        <div class="layui-form-item">
        <div class="layui-form-mid layui-word-aux">邮箱:<?php echo $cus['email']; ?></div>
        </div>
        <div class="layui-form-item">
        <div class="layui-form-mid layui-word-aux">注册日期：<?php echo $cus['cdate']; ?></div>
        </div>
        <div class="layui-form-item">
        <div class="layui-form-mid layui-word-aux">上次登录：<?php echo $cus['mdate']; ?></div>
        </div>
    </div>
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>用户行为分析</legend>
    </fieldset>
</form>
</html>
<script>
    layui.use(['form', 'laydate','layer', 'jquery'], function(){
        var form = layui.form
            ,laydate = layui.laydate
            ,layer=layui.layer
            ,$ = layui.jquery;

        //日期
        laydate.render({
            elem: '#date'
        });
        //自定义验证规则
        form.verify({
            title: function(value){
                if(value.length < 2){
                    return '标题至少得2个字符啊';
                }
            }
            ,pass: [/(.+){6,12}$/, '密码必须6到12位']
            ,content: function(value){
                layedit.sync(editIndex);
            }
        });
        form.on('select(cus_provid)', function(data){
            var p_id=data.value;
            $.ajax({
                type: 'POST',
                url: "<?=url('user/getCityName')?>?p_id="+p_id,
                data: {p_id:p_id},
                dataType:  'json',
                success: function(data){
                    var code=data.data;
                    $("#cityName").html("<option value=''>请选择市</option>");
                    $.each(code, function(i, val) {
                        var option1 = $("<option>").val(val.c_id).text(val.c_name);
                        $("#cityName").append(option1);
                        form.render('select');
                    });
                    $("#cityName").get(0).selectedIndex=0;
                }
            });
        });
        //ajax提交表单数据
        form.on('submit(editCus)', function(data){
            $.ajax({
                'type':"post",
                'url':"<?=url('user/editUser')?>?cus_id=",
                'data':$("#cusInfo").serialize(),
                'success':function (result) {
                   if(result.code == '1'){
                       var index=parent.layer.getFrameIndex(window.name);
                       parent.layer.close(index);
                       window.parent.location.reload();
                   }
                },
                'error':function (error) {
                    console.log(error);
                }
            })
        });
    });
</script>