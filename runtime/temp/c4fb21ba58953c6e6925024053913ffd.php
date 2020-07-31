<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:89:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\admin\add.html";i:1596186921;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
    <div style="margin: 20px;">
    <span class="layui-breadcrumb" lay-separator=">">
        <a>员工管理</a>
        <a href="<?=url('admin/admin')?>">员工列表</a>
        <a><cite>添加员工</cite></a>
    </span>
        <div style="float:right;">
            <a href="<?=url('admin/admin')?>" class="layui-btn layui-btn-primary layui-btn-sm">
                <i class="layui-icon layui-icon-return"></i>
                返回列表</a>
        </div>
    </div>
    <hr/>
    <div style="padding: 15px;">
        <form class="layui-form layui-form-pane1" action="<?=url('admin/add')?>" method="post">
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>员工姓名</label>
                <div class="layui-input-block">
                    <input type="text" name="ad_realname" lay-verify="required|title" placeholder="请输入管理员姓名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>员工角色</label>
                <div class="layui-input-block">
                    <?php if(is_array($role) || $role instanceof \think\Collection || $role instanceof \think\Paginator): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <input type="checkbox" name="ad_role[<?php echo $vo['r_id']; ?>]" lay-skin="primary" title="<?php echo $vo['r_name']; ?>">
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>电子邮箱</label>
                <div class="layui-input-block">
                    <input type="text" name="ad_email" id="ad_email" lay-verify="required|email"  onblur="checkEmail()" placeholder="请输入电子邮箱" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>手机号码</label>
                <div class="layui-input-block">
                    <input type="text" name="ad_phone" id="ad_phone" lay-verify="required|phones" placeholder="请输入手机号码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>初始密码</label>
                <div class="layui-input-block">
                    <input type="text" name="ad_password" placeholder="请输入密码" autocomplete="off" value="123456" class="layui-input">
                </div>
            </div>
            <div class="layui-upload">
                <label class="layui-form-label">头像</label>
                <div class="layui-input-inline">
                    <img class="layui-upload-img" id="demo1">
                    <p id="demoText"></p>
                </div>
                <input type="hidden" name="ad_img" id="ad_img">
                <span class="layui-btn" id="test1">上传图片</span>
            </div>
            <div class="layui-form-item" pane>
                <label class="layui-form-label"><span style="color: red;">*</span>性别</label>
                <div class="layui-input-block">
                    <input type="radio" name="ad_sex" value="1" title="男" checked>
                    <input type="radio" name="ad_sex" value="2" title="女">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">公司</label>
                <div class="layui-input-block">
                    <?php if(is_array($crop) || $crop instanceof \think\Collection || $crop instanceof \think\Paginator): $i = 0; $__LIST__ = $crop;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <input type="checkbox" class="checkbox" lay-skin="primary" name="ad_corp[<?php echo $vo['cp_id']; ?>]" title="<?php echo $vo['cp_name']; ?>" >
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">职位</label>
                <div class="layui-input-block">
                    <input type="text" name="ad_job" placeholder="请输入职位" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">个人简介</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入个人简介" maxlength="500" name="ad_desc" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="saveInfo">添加</button>
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
            }, phones: function(value){
                var myreg = /^(\+?0?86\-?)?1[345789]\d{9}$/;
                var au = /^(\+?61|0)4\d{8}$/;
                if(!myreg.test(value) && !au.test(value)){
                    return '请输入正确的手机号';
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