<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:90:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\house\tags.html";i:1587442262;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1587553386;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1583744281;}*/ ?>
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
    <link rel="stylesheet" href="../../../layui/src/autocomplete/selectpage.css">
    <script src="../../../static/jquery-1.10.2.min.js"></script>
    <script src="../../../layui/src/layui.js"></script>
    <script src="../../../layui/src/autocomplete/selectpage.js"></script>
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
            <form class="layui-form" action="<?=url('house/tags')?>?id=<?php echo $house['id']; ?>" method="post">
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend>房源标签</legend>
                </fieldset>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">房源标签</label>
                    <div class="layui-input-block">
                        <?php if(is_array($tags) || $tags instanceof \think\Collection || $tags instanceof \think\Paginator): $i = 0; $__LIST__ = $tags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" class="checkbox" lay-skin="primary" name="tags[<?php echo $vo['name']; ?>]" title="<?php echo $vo['name']; ?>" <?php echo !empty($vo['is_checked'])?'checked' : ''; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn">提交</button>
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