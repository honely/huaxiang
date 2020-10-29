<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:96:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\question\review1.html";i:1587119392;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
    <div class="layui-tab">
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <div style="margin: 10px">
                    <div style="padding: 15px;">
                        <form class="layui-form" >
                            <div class="layui-form-item">
                                <label class="layui-form-label"><span style="color: red;">*</span>问</label>
                                <div class="layui-input-block">
                                    <input type="text" name="title" lay-verify="required|title" placeholder="请输入" id="title" value="<?php echo $content['title']; ?>" class="layui-input">
                                    <input type="hidden" name="id" id="id" value="<?php echo $content['id']; ?>" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item layui-form-text">
                                <label class="layui-form-label">答</label>
                                <div class="layui-input-block">
                                    <textarea placeholder="请输入" id="summary" name="summary" class="layui-textarea"><?php echo $content['summary']; ?></textarea>
                                </div>
                            </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <span class="layui-btn" onclick="closeAlls()">提交</span>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    function closeAlls(){
        var id = $('#id').val();
        var title = $('#title').val();
        var summary = $('#summary').val();
        $.ajax({
            type: 'post',
            url: "<?=url('question/review1')?>",
            data:{'id':id,'title':title,'summary':summary},
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
    layui.use(['form', 'jquery','upload'], function(){
        var form = layui.form
            ,upload = layui.upload
            ,$ = layui.jquery;
        //自定义验证规则
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