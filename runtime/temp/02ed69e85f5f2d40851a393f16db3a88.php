<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:92:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\admin\fenpei.html";i:1590570617;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1587691504;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1583744281;}*/ ?>
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
    .item_img{
        width: 120px;
        height: 105px;
        float: left;
        margin-top: 20px;
    }
</style>
<div class="layui-body">
    <div style="margin: 10px">
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote layui-text">
                后台员工绑定前端用户后可以通过小程序端和用户交流<br>
            </blockquote>
            <form class="layui-form" id="myForm">
                <div class="layui-form-item">
                    <label class="layui-form-label">绑定用户</label>
                    <div class="layui-input-inline">
                        <select name="ad_wechat" id="ad_wechat" lay-search="">
                            <option value="">输入或选择用户</option>
                            <?php if(is_array($sale) || $sale instanceof \think\Collection || $sale instanceof \think\Paginator): $i = 0; $__LIST__ = $sale;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vo['id']; ?>"><?php echo $vo['nickname']; ?>(<?php echo $vo['tel']; ?>)</option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
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
<script>
    function closeAlls(){
        var crm_id = $('#crm_id').val();
        var cl_cl_admin = $('#cl_cl_admin').val();
        var deadline = $('#deadline').val();
        if(cl_cl_admin == ''){
            return layer.msg('请选择接单人！');
        }
        if(deadline ==''){
            return layer.msg('请选择截至日期！');
        }
        $.ajax({
            type: 'get',
            url: "<?=url('order/fenPro')?>?&crm_id="+crm_id+ "&cl_cl_admin="+cl_cl_admin+ "&deadline="+deadline,
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
    layui.use(['form', 'jquery','laydate','layer'], function(){
        var form = layui.form
            ,laydate = layui.laydate
            ,layer = layui.layer
            ,$ = layui.jquery;
        laydate.render({
            elem: '#deadline'
            ,type: 'datetime'
            ,trigger: 'click'
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