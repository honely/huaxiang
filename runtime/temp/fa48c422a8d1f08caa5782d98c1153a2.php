<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:97:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\account\bindemail.html";i:1591169624;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1587691504;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1583744281;}*/ ?>
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
    <title>小宝租房后台管理系统</title>
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
    <div style="margin: 20px;">
    <span class="layui-breadcrumb" lay-separator=">">
        <a>账户管理</a>
        <a><cite>修改资料</cite></a>
    </span>
        <div style="float:right;">
            <a href="<?=url('account/personal')?>" class="layui-btn layui-btn-primary layui-btn-sm">
                <i class="layui-icon layui-icon-return"></i>
                返回</a>
        </div>
    </div>
    <hr/>
    <div style="padding: 15px;">
        <form class="layui-form layui-form-pane1" action="<?=url('account/edit')?>" method="post">
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>员工姓名</label>
                <div class="layui-input-block">
                    <input type="text" name="ad_realname" lay-verify="required|title" placeholder="请输入管理员姓名" autocomplete="off" value="<?php echo $admin['ad_realname']; ?>" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>员工角色</label>
                <div class="layui-input-block">
                    <?php if(is_array($allrole) || $allrole instanceof \think\Collection || $allrole instanceof \think\Paginator): $i = 0; $__LIST__ = $allrole;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <input type="checkbox" class="checkbox" lay-skin="primary" name="ad_role[<?php echo $vo['ad_id']; ?>]" title="<?php echo $vo['ad_role']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>电子邮箱</label>
                <div class="layui-input-block">
                    <input type="text" name="ad_email" id="ad_email" value="<?php echo $admin['ad_email']; ?>"  onblur="checkEmail()" placeholder="请输入电子邮箱" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>手机号码</label>
                <div class="layui-input-block">
                    <input type="text" name="ad_phone" value="<?php echo $admin['ad_phone']; ?>" id="ad_phone" placeholder="请输入手机号码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-upload">
                <label class="layui-form-label">头像</label>
                <div class="layui-input-inline">
                    <img class="layui-upload-img" id="demo1" <?php if($admin['ad_img'] != null): ?>src="../../../<?php echo $admin['ad_img']; ?>"<?php endif; ?> >
                    <p id="demoText"></p>
                </div>
                <input type="hidden" name="ad_img" id="ad_img" value="<?php echo $admin['ad_img']; ?>" >
                <span class="layui-btn" id="test1">上传图片</span>
            </div>
            <div class="layui-form-item" pane>
                <label class="layui-form-label"><span style="color: red;">*</span>性别</label>
                <div class="layui-input-block">
                    <input type="radio" name="ad_sex" value="1" title="男" <?php if($admin['ad_sex'] == 1): ?>checked<?php endif; ?>>
                    <input type="radio" name="ad_sex" value="2" title="女" <?php if($admin['ad_sex'] == 2): ?>checked<?php endif; ?>>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">公司</label>
                <div class="layui-input-block">
                    <input type="text" name="ad_corp" readonly placeholder="请输入公司" autocomplete="off" class="layui-input" value="<?php echo $admin['ad_corp']; ?>" >
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">职位</label>
                <div class="layui-input-block">
                    <input type="text" name="ad_job" readonly placeholder="请输入职位" autocomplete="off" class="layui-input" value="<?php echo $admin['ad_job']; ?>" >
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">工号</label>
                <div class="layui-input-block">
                    <input type="text" name="ad_bid" readonly value="<?php echo $admin['ad_bid']; ?>" placeholder="请输入工号" autocomplete="off"  class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">微信号码</label>
                <div class="layui-input-block">
                    <input type="text" name="ad_weixin" value="<?php echo $admin['ad_weixin']; ?>" placeholder="请输入微信" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">个人简介</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入个人简介" maxlength="500" name="ad_desc" class="layui-textarea"><?php echo $admin['ad_desc']; ?></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="saveInfo">更新</button>
                    <a class="layui-btn layui-btn-primary" href="<?=url('admin/admin')?>">返回</a>
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
        //普通图片上传
        var uploadInst = upload.render({
            elem: '#test1'
            ,url: '<?php echo url("admin/upload"); ?>' //改成您自己的上传接口
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#demo1').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){
                console.log(res);
                //如果上传失败
                if(res.code > 0){
                    layer.msg(res.msg);
                    $('#demo1').attr('src',"../../../"+res.filepath);
                    $('#ad_img').val(res.filepath);
                }else{
                    return layer.msg(res.msg);
                }
                //上传成功
            }
            ,error: function(){
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function(){
                    uploadInst.upload();
                });
            }
        });

    });

    function checkPhone(){
        var ad_bid=$('#ad_bid').val();
        $.ajax({
            type:"post",
            url:"<?=url('admin/checkPhone')?>",
            dataType: 'json',
            data:{'ad_bid':ad_bid,'ad_id':'0'},
            success:function (data) {
                console.log(data);
                if(data.code >1){
                    layer.msg(data.msg, {icon: 2, time: 1000});
                }else if(data.code <= 1){
                    layer.msg(data.msg, {icon: 1, time: 1000});
                }
            },
            error:function (error) {
                console.log(error);
            }
        })
    }

    function checkEmail(){
        var ad_email=$('#ad_email').val();
        $.ajax({
            type:"post",
            url:"<?=url('admin/checkEmail')?>",
            dataType: 'json',
            data:{'ad_email':ad_email,'ad_id':'0'},
            success:function (data) {
                console.log(data);
                if(data.code >1){
                    layer.msg(data.msg, {icon: 2, time: 1000});
                }else if(data.code <= 1){
                    layer.msg(data.msg, {icon: 1, time: 1000});
                }
            },
            error:function (error) {
                console.log(error);
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