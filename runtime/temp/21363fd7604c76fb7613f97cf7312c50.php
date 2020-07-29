<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:96:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\account\personal.html";i:1596001389;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
            <a href="<?=url('account/edit')?>" class="layui-btn layui-btn-primary layui-btn-sm">
                <i class="layui-icon">&#xe642;</i>
                <?php echo $lable['xiugaiziliao']; ?></a>
        </div>
    </div>
    <div style="padding: 15px;">
        <form class="layui-form layui-form-pane1" action="<?=url('admin/edit')?>?ad_id=<?php echo $admin['ad_id']; ?>" method="post">
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['yuangongxm']; ?></label>
                <div class="layui-input-block">
                    <input type="text" readonly value="<?php echo $admin['ad_realname']; ?>" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['yuangongjs']; ?></label>
                <div class="layui-input-block">
                    <?php if(is_array($allrole) || $allrole instanceof \think\Collection || $allrole instanceof \think\Paginator): $i = 0; $__LIST__ = $allrole;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <input type="checkbox" class="checkbox" lay-skin="primary" name="ad_role[<?php echo $vo['ad_id']; ?>]" title="<?php echo $vo['erole']; ?>" disabled  <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['email']; ?></label>
                <div class="layui-input-inline">
                    <input type="text" value="<?php echo $admin['ad_email']; ?>" readonly class="layui-input">
                </div>
                <div class="layui-input-inline">
                    <span class="layui-btn layui-btn-sm layui-btn-normal" id="changeEmail" data-href="<?=url('account/email')?>"><?php echo $lable['gengxinyouxiang']; ?></span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['phone']; ?></label>
                <div class="layui-input-inline">
                    <input type="text" name="ad_phone" value="<?php echo $admin['ad_phone']; ?>" readonly  class="layui-input">
                </div>
                <div class="layui-input-inline">
                    <span class="layui-btn layui-btn-sm layui-btn-normal" id="changePhone" data-href="<?=url('account/phone')?>"><?php echo $lable['gengxinshouji']; ?></span>
                </div>
            </div>
            <div class="layui-upload">
                <label class="layui-form-label"><?php echo $lable['avatar']; ?></label>
                <div class="layui-input-inline">
                    <img class="layui-upload-img" id="demo1" <?php if($admin['ad_img'] != null): ?>src="../../../<?php echo $admin['ad_img']; ?>"<?php endif; ?> >
                    <p id="demoText"></p>
                </div>
            </div>
            <div class="layui-form-item" pane>
                <label class="layui-form-label"><span style="color: red;">*</span><?php echo $lable['gender']; ?></label>
                <div class="layui-input-block">
                    <input type="radio" disabled name="ad_sex" value="1" title="<?php echo $lable['male']; ?>" <?php if($admin['ad_sex'] == 1): ?>checked<?php endif; ?>>
                    <input type="radio" disabled name="ad_sex" value="2" title="<?php echo $lable['female']; ?>" <?php if($admin['ad_sex'] == 2): ?>checked<?php endif; ?>>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo $lable['company']; ?> </label>
                <div class="layui-input-block">
                    <input type="text" readonly class="layui-input" value="<?php echo $admin['ad_corp']; ?>" >
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo $lable['position']; ?></label>
                <div class="layui-input-block">
                    <input type="text" readonly class="layui-input" value="<?php echo $admin['ad_job']; ?>" >
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label"><?php echo $lable['desc']; ?></label>
                <div class="layui-input-block">
                    <textarea readonly class="layui-textarea"><?php echo $admin['ad_desc']; ?></textarea>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    layui.use(['form','jquery','upload','layer'], function(){
        var form = layui.form
            ,$ = layui.jquery
            ,layer = layui.layer,
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
    $("body").on("click","#changeEmail",function(){
        var urls = $(this).attr('data-href');
        layer.open({
            type: 2,
            title: '<?php echo $lable['gengxinyouxiang']; ?>',
            shadeClose: true,
            shade: false,
            maxmin: true,
            area: ['80%', '80%'],
            content: urls
        });
    });
    $("body").on("click","#changePhone",function(){
        var urls = $(this).attr('data-href');
        layer.open({
            type: 2,
            title: '<?php echo $lable['gengxinshouji']; ?>',
            shadeClose: true,
            shade: false,
            maxmin: true,
            area: ['80%', '80%'],
            content: urls
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