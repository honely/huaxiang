<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:91:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\help\review.html";i:1586858299;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1587691504;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1583744281;}*/ ?>
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

<div class="layui-body">
    <div style="margin: 10px">
        <div style="padding: 15px;">
            <form class="layui-form" id="logForm">
                <div class="layui-form-item">
                    <label class="layui-form-label">客户预算</label>
                    <div class="layui-input-block">
                        <input type="text" value="<?php echo (isset($help['h_price_min']) && ($help['h_price_min'] !== '')?$help['h_price_min']:''); ?>" readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">房型</label>
                    <div class="layui-input-block">
                        <input type="text" value="<?php echo (isset($help['h_house_type']) && ($help['h_house_type'] !== '')?$help['h_house_type']:''); ?>" readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">户型</label>
                    <div class="layui-input-block">
                        <input type="text" value="<?php echo (isset($help['h_room_type']) && ($help['h_room_type'] !== '')?$help['h_room_type']:''); ?>" readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">租房方式</label>
                    <div class="layui-input-block">
                        <input type="text" value="<?php echo (isset($help['h_house_style']) && ($help['h_house_style'] !== '')?$help['h_house_style']:''); ?>" readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">租房区域</label>
                    <div class="layui-input-block">
                        <input type="text" value="<?php echo (isset($help['h_regin']) && ($help['h_regin'] !== '')?$help['h_regin']:''); ?>" readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">租房需求</label>
                    <div class="layui-input-block">
                        <input type="text" value="<?php echo (isset($help['h_need']) && ($help['h_need'] !== '')?$help['h_need']:''); ?>" readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">提交时间</label>
                    <div class="layui-input-block">
                        <input type="text" value="<?php echo (isset($help['h_addtime']) && ($help['h_addtime'] !== '')?$help['h_addtime']:''); ?>" readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">是否接机</label>
                    <div class="layui-input-block">
                        <input type="text" value="<?php echo (isset($help['h_air']) && ($help['h_air'] !== '')?$help['h_air']:''); ?>" readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">微信号</label>
                    <div class="layui-input-block">
                        <input type="text" value="<?php echo (isset($help['h_wechat']) && ($help['h_wechat'] !== '')?$help['h_wechat']:''); ?>" readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">联系电话</label>
                    <div class="layui-input-block">
                        <input type="text" value="<?php echo (isset($help['h_phone']) && ($help['h_phone'] !== '')?$help['h_phone']:''); ?>" readonly class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">回访备注</label>
                    <div class="layui-input-block">
                        <textarea placeholder="请输入回访备注" name="h_review" class="layui-textarea"><?php echo (isset($help['h_review']) && ($help['h_review'] !== '')?$help['h_review']:''); ?></textarea>
                        <input type="hidden" name="h_id" value="<?php echo $help['h_id']; ?>"/>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <span class="layui-btn" id="saveInfo">
                            保存
                            </span>
                        <span class="layui-btn layui-btn-primary" onclick="closeAlls()">关闭</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    layui.use(['form', 'jquery','upload','laydate'], function(){
        var form = layui.form
            ,upload = layui.upload
            ,laydate = layui.laydate
            ,layer = layui.layer
            ,$ = layui.jquery;
        laydate.render({
            elem: '#cl_date'
            ,type: 'date'
            ,trigger: 'click'
        });
    });
    function closeAlls(){
        var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
        parent.layer.close(index);
    }
    $('#saveInfo').click(function () {
        $.ajax({
            type:'post',
            url:'/xcx/help/review',
            data:$("#logForm").serialize(),
            success:function (data) {
                if(data.code == 1){
                    var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                    parent.layer.close(index);
                    parent.location.reload();
                }else{
                    var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                    parent.layer.close(index);
                    parent.location.reload();
                }
            },
            error:function (data) {
                console.log(data)
            }
        })
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