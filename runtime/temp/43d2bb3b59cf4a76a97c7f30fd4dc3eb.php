<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:91:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\banner\edit.html";i:1599617660;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
        <a>广告管理</a>
        <a href="<?=url('banner/index')?>">banner列表</a>
        <a><cite>修改banner</cite></a>
    </span>
        <div style="float:right;">
            <a href="<?=url('banner/index')?>" class="layui-btn layui-btn-primary layui-btn-sm">
                <i class="layui-icon layui-icon-return"></i>
                返回列表</a>
        </div>
    </div>
    <hr/>
    <div class="layui-tab">
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <div style="margin: 10px">
                    <div style="padding: 15px;">
                        <form class="layui-form" action="<?=url('banner/edit')?>?b_id=<?php echo $ban['b_id']; ?>" method="post">
                            <div class="layui-form-item">
                                <label class="layui-form-label"><span style="color: red;">*</span>banner主题</label>
                                <div class="layui-input-block">
                                    <input type="text" name="b_title" lay-verify="required|title" placeholder="请输入banner主题" value="<?php echo $ban['b_title']; ?>" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item" pane>
                                <label class="layui-form-label">广告位置</label>
                                <div class="layui-input-block">
                                    <input type="radio" name="b_class" value="1" title="首页轮播" <?php if($ban['b_class'] == 1): ?> checked<?php endif; ?>>
                                    <input type="radio" name="b_class" value="2" title="详情页广告" <?php if($ban['b_class'] == 2): ?> checked<?php endif; ?>>
                                    <input type="radio" name="b_class" value="3" title="列表广告" <?php if($ban['b_class'] == 3): ?> checked<?php endif; ?>>
                                </div>
                            </div>
                            <div class="layui-form-item" pane>
                                <label class="layui-form-label"><span style="color: red;">*</span>跳转到</label>
                                <div class="layui-input-block">
                                    <input type="radio" name="b_type" lay-filter="b_type" value="1" title="内部固定富文本" <?php if($ban['b_type'] == 1): ?> checked<?php endif; ?>>
                                    <input type="radio" name="b_type" lay-filter="b_type" value="2" title="外部链接" <?php if($ban['b_type'] == 2): ?> checked<?php endif; ?>>
                                    <input type="radio" name="b_type" lay-filter="b_type" value="3" title="其他小程序" <?php if($ban['b_type'] == 3): ?> checked<?php endif; ?>>
                                    <input type="radio" name="b_type" lay-filter="b_type" value="4" title="只展示不跳转" <?php if($ban['b_type'] == 4): ?> checked<?php endif; ?>>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"><span style="color: red;">*</span>基础信息</label>
                                <div class="layui-input-inline">
                                    <select name="b_order" lay-verify="required" lay-filter="aihao">
                                        <option value="">请选择排列顺序</option>
                                        <option value="1" <?php if($ban['b_order'] == 1): ?>selected<?php endif; ?>>1</option>
                                        <option value="2" <?php if($ban['b_order'] == 2): ?>selected<?php endif; ?>>2</option>
                                        <option value="3" <?php if($ban['b_order'] == 3): ?>selected<?php endif; ?>>3</option>
                                        <option value="4" <?php if($ban['b_order'] == 4): ?>selected<?php endif; ?>>4</option>
                                        <option value="5" <?php if($ban['b_order'] == 5): ?>selected<?php endif; ?>>5</option>
                                    </select>
                                </div>
                                <div class="layui-form-mid layui-word-aux">数字越大越靠前，默认排序为时间倒序！</div>
                            </div>
                            <div class="layui-form-item one-pan">
                                <label class="layui-form-label"><span style="color: red;">*</span>封面图片</label>

                                <div <?php if($ban['b_cover'] == null): ?>class="layui-upload-drag"<?php endif; ?> id="uploadLogo" style="display:inline-block;" >
                                <image id="logoPre"
                                       <?php if($ban['b_cover'] == null): else: ?>
                                src="../../../<?php echo $ban['b_cover']; ?>"
                                class="logoPre"
                                <?php endif; ?>
                                >
                                <input type="hidden" lay-verify="imgReg" name="b_cover" id="b_cover" value="<?php echo $ban['b_cover']; ?>"/>
                                </image>
                            </div>
                            <div class="one">
                                <div class="layui-form-mid layui-word-aux" style="margin-left: 39px; ">图片要求，最大800KB，支持JPG/JEPG/PNG格式</div>
                            </div>
                    </div>
                    <div class="layui-form-item" id="b_url" style="display:<?php if($ban['b_type'] == 2): ?>block<?php else: ?>none<?php endif; ?>">
                        <label class="layui-form-label"><span style="color: red;">*</span>跳转链接</label>
                        <div class="layui-input-block">
                            <input type="text" name="b_url" id="urls" placeholder="请输入banner图片跳转链接。" value="<?php echo $ban['b_url']; ?>" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux" style="color:red !important;">1.链接域名需是在ICP通过备案的域名。2.域名需要在小程序后台配置业务域名后才能正确跳转。</div>
                    </div>
                    <div class="layui-form-item" id="b_appid" style="display:<?php if($ban['b_type'] == 3): ?>block<?php else: ?>none<?php endif; ?>">
                        <label class="layui-form-label"><span style="color: red;">*</span>Appid</label>
                        <div class="layui-input-block">
                            <input type="text" name="b_appid" id="appid" placeholder="请输入要打开的小程序 appId。" autocomplete="off" value="<?php echo $ban['b_appid']; ?>" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item" id="b_path" style="display:<?php if($ban['b_type'] == 3): ?>block<?php else: ?>none<?php endif; ?>">
                        <label class="layui-form-label">页面路径</label>
                        <div class="layui-input-block">
                            <input type="text" name="b_path" id="path" placeholder="请输入小程序页面路径,如果为空则打开首页。" autocomplete="off" value="<?php echo $ban['b_path']; ?>" class="layui-input">
                        </div>
                    </div>
                            <div class="layui-form-item" pane>
                                <label class="layui-form-label">是否显示</label>
                                <div class="layui-input-block">
                                    <input type="radio" name="b_status" value="1" title="是" <?php if($ban['b_status'] == 1): ?> checked<?php endif; ?>>
                                    <input type="radio" name="b_status" value="2" title="否" <?php if($ban['b_status'] == 2): ?> checked<?php endif; ?>>
                                </div>
                            </div>
                        <div class="layui-form-item" id="b_content" style="display: <?php if($ban['b_type'] == 1): ?>block<?php else: ?>none<?php endif; ?>">
                            <label class="layui-form-label"><span style="color: red;">*</span>广告内容</label>
                            <div class="layui-input-block">
                                <script id="container" name="b_content"  style="width:1024px;height:500px;" type="text/plain"><?php echo $ban['b_content']; ?></script>
                            </div>
                        </div>
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button class="layui-btn" lay-submit lay-filter="saveInfo">修改</button>
                                    <a class="layui-btn layui-btn-primary" href="<?=url('banner/index')?>">返回</a>
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
        form.on('radio(b_type)', function(data){
            var type = data.value;
            if(type == 1){
                console.log(1);
                $('#b_content').show();
                $('#b_appid').hide();
                $('#b_path').hide();
                $('#b_url').hide();
                $('#urls').removeAttr('lay-verify');
                $('#appid').removeAttr('lay-verify');
            }else if(type == 2){
                $('#b_content').hide();
                $('#b_appid').hide();
                $('#b_path').hide();
                $('#b_url').show();
                $('#appid').removeAttr('lay-verify');
                $('#urls').attr('lay-verify','required|url');
            }else if(type == 3){
                $('#b_content').hide();
                $('#b_url').hide();
                $('#b_appid').show();
                $('#b_path').show();
                $('#urls').removeAttr('lay-verify');
                $('#appid').attr('lay-verify','required');
            }else if(type == 4){
                $('#b_content').hide();
                $('#b_url').hide();
                $('#b_appid').hide();
                $('#b_path').hide();
                $('#urls').removeAttr('lay-verify');
                $('#b_content').removeAttr('lay-verify');
                $('#appid').removeAttr('lay-verify');
            }
        });
        //自定义验证规则
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
            ,url: '<?php echo url("xcx/banner/upload"); ?>'
            ,exts: 'PNG|JPG'
            ,size: '30000'
            ,done: function(res){
                layer.close(layer.msg());//关闭上传提示窗口
                if(res.status == 0) {
                    return layer.msg(res.message);
                }
                $('#uploadLogo').removeClass('layui-upload-drag');
                $('#logoPre').css('width','216px');
                $('#logoPre').css('height','150px');
                $('#logoPre').attr('src',"../../../"+res.path);
                console.log(res);
                $('#b_cover').val('' +res.path + '');
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