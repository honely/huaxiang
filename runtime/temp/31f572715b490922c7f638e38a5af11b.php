<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:90:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\apply\edit.html";i:1602742766;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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

<!-- 配置文件 -->
<script type="text/javascript" src="../../../ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="../../../ueditor/ueditor.all.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
</script>
<style>
    .one-pan{
        position: relative;
    }
    .one{
        position: absolute;
        left:300px;
        top:0;
    }
    .logoPre{
        width: 216px;
        height: 150px;
    }
    .casePre{
        display:none;
    }
</style>
<div class="layui-body">
    <div style="margin: 20px;">
    <span class="layui-breadcrumb" lay-separator=">">
        <a>tickrent</a>
        <a href="<?=url('apply/guide')?>">申请指南</a>
        <a><cite>修改</cite></a>
    </span>
        <div style="float:right;">
            <a href="<?=url('apply/guide')?>" class="layui-btn layui-btn-primary layui-btn-sm">
                <i class="layui-icon layui-icon-return"></i>
                返回列表</a>
        </div>
    </div>
    <hr/>
    <div class="layui-tab">
        <div class="layui-tab-content">
            <!--基本信息-->
            <div class="layui-tab-item layui-show">
                <div style="margin: 10px">
                    <div style="padding: 15px;">
                        <form class="layui-form" action="<?=url('apply/edit')?>?id=<?php echo $apply['id']; ?>" method="post">
                            <div class="layui-form-item">
                                <label class="layui-form-label"><span style="color: red;">*</span>标题</label>
                                <div class="layui-input-block">
                                    <input type="text" name="title" lay-verify="required|title" placeholder="请输入标题" value="<?php echo $apply['title']; ?>" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item one-pan">
                                <label class="layui-form-label"><span style="color: red;">*</span>封面图片</label>

                                <div <?php if($apply['images'] == null): ?>class="layui-upload-drag"<?php endif; ?> id="uploadLogo" style="display:inline-block;" >
                                <image id="logoPre"
                                       <?php if($apply['images'] == null): else: ?>
                                src="../../../<?php echo $apply['images']; ?>"
                                class="logoPre"
                                <?php endif; ?>
                                >
                                <input type="hidden" lay-verify="imgReg" name="images" id="images" value="<?php echo $apply['images']; ?>"/>
                                </image>
                            </div>
                            <div class="one">
                                <div class="layui-form-mid layui-word-aux" style="margin-left: 39px; ">图片要求，最大800KB，支持JPG/JEPG/PNG格式</div>
                            </div>
                    </div>
                            <div class="layui-form-item" id="b_content">
                                <label class="layui-form-label"><span style="color: red;">*</span>内容</label>
                                <div class="layui-input-block">
                                    <script id="container" name="content"  style="width:1024px;height:500px;" type="text/plain"><?php echo $apply['content']; ?></script>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button class="layui-btn" lay-submit lay-filter="saveInfo">修改</button>
                                    <a class="layui-btn layui-btn-primary" href="<?=url('apply/guide')?>">返回</a>
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
    layui.use(['form', 'jquery','upload'], function(){
        var form = layui.form
            ,upload = layui.upload
            ,$ = layui.jquery;
        form.verify({
            title: function(value){
                if(value.length < 2){
                    return '至少得2个字符啊';
                }
            }
            ,imgReg:function (value) {
                if(value.length <= 0){
                    return '请上传图片';
                }
            }
        });
        upload.render({
            elem: '#uploadLogo'
            ,url: '<?php echo url("xcx/apply/upload"); ?>'
            ,exts: 'PNG|JPG'
            ,size: '30000'
            ,done: function(res){
                layer.close(layer.msg());//关闭上传提示窗口
                if(res.status == 0) {
                    return layer.msg(res.message);
                }
                $('#uploadLogo').removeClass('layui-upload-drag');
                $('#logoPre').css('width','216px');
                $('#display').hide();
                $('#logoPre').css('height','150px');
                $('#logoPre').attr('src',"../../../"+res.path);
                console.log(res);
                $('#images').val('' +res.path + '');
            }
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