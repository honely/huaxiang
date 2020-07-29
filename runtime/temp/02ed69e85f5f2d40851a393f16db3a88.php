<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:92:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\admin\fenpei.html";i:1591953340;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
        margin: 0 10px 10px 0;
        float: left;
    }
    .user-info {
        height: 130px;
        width: 130px;
        display: block;
        float: left;
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
                        <input type="text" name="ad_realname" id="phone" placeholder="请输入手机号" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline">
                        <span class="layui-btn layui-btn-sm layui-btn-normal" id="querys">发起搜索</span>
                    </div>
                </div>
                <div class="layui-upload">
                    <div class="layui-upload-list" id="userContent" style="height: 140px;">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input type="hidden" id="ad_id" value="<?php echo $ad_id; ?>">
                        <input type="hidden" id="ad_wechat" value="">
                        <span class="layui-btn" onclick="closeAlls()">提交</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function closeAlls(){
        var ad_id = $('#ad_id').val();
        var ad_wechat = $('#ad_wechat').val();
        if(ad_wechat == ''){
            return layer.msg('请选择用户！');
        }
        $.ajax({
            type: 'get',
            url: "<?=url('admin/fenPro')?>?&ad_id="+ad_id+ "&ad_wechat="+ad_wechat,
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
    });
</script>
<script>
    layui.use(['form', 'jquery','laydate','layer'], function(){
        var form = layui.form
            ,laydate = layui.laydate
            ,layer = layui.layer
            ,$ = layui.jquery;
        form.on('radio(delete)', function (data) {
            console.log(data.value);
           var id= data.value;
           $('#ad_wechat').val(id);

        });
    $('#querys').click(function(){
        $("#userContent").empty();
        var phone = $('#phone').val();
        if (phone.length < 4) {
            return layer.msg('请至少输入4位数 的电话号码！');
        }
        $.ajax({
            type : 'post',
            async : false,
            url : "<?=url('admin/searchuser')?>",
            data:{phone:phone},
            dataType:"json",
            success : function(data) {
                if(data.code > 0){
                    console.log(data);
                    var  code = data.data;
                    layer.msg('为您查询到总共'+code.length+'条记录。');
                    var html ='';
                    for (var i = 0; i <code.length; i++) {
                        html += '<div class="user-info">\n' +
                            '                            <img class="layui-upload-img" src='+code[i].avaurl+' alt="">\n' +
                            '                            <input type="radio" lay-skin="primary" lay-filter="delete" value='+code[i].id+' name="tel" title='+code[i].phone+'>\n' +
                            '                        </div>'
                    }
                    $("#userContent").append(html);
                    form.render();
                }else {
                     layer.msg('暂无查询结果，请更换手机号尝试！');
                }
            }
        });
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