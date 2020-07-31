<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:92:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\account\edit.html";i:1596193101;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
       <a><?php echo $lable['zhanghuguanli']; ?></a>
        <a><cite><?php echo $lable['gerenziliao']; ?></cite></a>
    </span>
        <div style="float:right;">
            <a href="<?=url('account/personal')?>" class="layui-btn layui-btn-primary layui-btn-sm">
                <i class="layui-icon layui-icon-return"></i>
                <?php echo $lable['fanhui']; ?></a>
        </div>
    </div>
    <hr/>
    <div style="padding: 15px;">
        <form class="layui-form layui-form-pane1" action="<?=url('account/edit')?>" method="post">
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['yuangongxm']; ?></label>
                <div class="layui-input-block">
                    <input type="text" name="ad_realname" lay-verify="required|title" placeholder="" autocomplete="off" value="<?php echo $admin['ad_realname']; ?>" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['yuangongjs']; ?></label>
                <div class="layui-input-block">
                    <?php if(is_array($allrole) || $allrole instanceof \think\Collection || $allrole instanceof \think\Paginator): $i = 0; $__LIST__ = $allrole;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <input type="checkbox" class="checkbox" lay-skin="primary" name="ad_role[<?php echo $vo['ad_id']; ?>]" title="<?php echo $vo['erole']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['email']; ?></label>
                <div class="layui-input-block">
                    <input type="text" name="ad_email" id="ad_email" disabled value="<?php echo $admin['ad_email']; ?>"  onblur="checkEmail()" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['phone']; ?></label>
                <div class="layui-input-block">
                    <input type="text" name="ad_phone" disabled value="<?php echo $admin['ad_phone']; ?>" id="ad_phone" placeholder=" " autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-upload">
                <label class="layui-form-label"><?php echo $lable['avatar']; ?></label>
                <div class="layui-input-inline">
                    <img class="layui-upload-img" id="demo1" <?php if($admin['ad_img'] != null): ?>src="../../../<?php echo $admin['ad_img']; ?>"<?php endif; ?> >
                    <p id="demoText"></p>
                </div>
                <input type="hidden" name="ad_img" id="ad_img" value="<?php echo $admin['ad_img']; ?>" >
                <span class="layui-btn" id="test1"><?php echo $lable['shangchuan']; ?></span>
            </div>
            <div class="layui-form-item" pane>
                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['gender']; ?></label>
                    <input type="radio" name="ad_sex" value="1" title="<?php echo $lable['male']; ?>" <?php if($admin['ad_sex'] == 1): ?>checked<?php endif; ?>>
                    <input type="radio" name="ad_sex" value="2" title="<?php echo $lable['female']; ?>" <?php if($admin['ad_sex'] == 2): ?>checked<?php endif; ?>>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">公司</label>
                <div class="layui-input-block">
                    <?php if(is_array($crop) || $crop instanceof \think\Collection || $crop instanceof \think\Paginator): $i = 0; $__LIST__ = $crop;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <input type="checkbox" class="checkbox" lay-skin="primary" name="ad_corp[<?php echo $vo['cp_id']; ?>]" title="<?php echo $vo['cp_name']; ?>"  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo $lable['position']; ?></label>
                <div class="layui-input-block">
                    <input type="text" name="ad_job" readonly placeholder=" " autocomplete="off" class="layui-input" value="<?php echo $admin['ad_job']; ?>" >
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label"><?php echo $lable['desc']; ?></label>
                <div class="layui-input-block">
                    <textarea placeholder=" " maxlength="500" name="ad_desc" class="layui-textarea"><?php echo $admin['ad_desc']; ?></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="saveInfo"><?php echo $lable['gengxin']; ?></button>
                    <a class="layui-btn layui-btn-primary" href="<?=url('account/personal')?>"><?php echo $lable['fanhui']; ?></a>
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