<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:90:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\user\touch.html";i:1589447153;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591172124;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1583744281;}*/ ?>
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
    .notification .main .message-show li {
        margin-bottom: 15px;
        overflow: hidden;
    }
    ul{
        margin: 0;
        padding: 10px 0 110px;
        list-style: none;
        box-sizing: border-box;
        display: block;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        padding-inline-start: 40px;
    }
    li {
        height: 74px;
        width: 100%;
        display: block;
        line-height: 20px;
    }
    .message-r a{
        float: right;
    }
    .message-r div{
        float: right;
        position: relative;
        display: block;
        margin: 4px 56px 0;
        min-height: 39px;
    }
    .message-l a{
        float: left;
    }
    .message-l div{
        position: relative;
        display: block;
        margin: 4px 56px 0;
        min-height: 39px;
        float: left;
    }
    .content{
        min-height: 39px;
        background-color: #e7f1fc;
        border-color: #bad0e9;
        border-radius: 0 4px 4px 4px;
        position: relative;
        padding: 8px 12px;
        font-size: 14px;
        word-break: break-word!important;
        word-break: break-all;
        line-height: 1.5;
        display: table-cell;
    }

    .time{
        margin-top: 2px;
        font-size: 12px;
        color: #d9d9d9;
    }
    .avatar{
        width: 40px;height: 40px;border-radius: 50%
    }
</style>
<div class="layui-body">
    <div style="margin: 10px">
        <div style="padding: 15px;">
            <form class="layui-form" action="" method="post">
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend><?php echo $titleMsg; ?></legend>
                </fieldset>
                <ul id="msg-list">
                    <?php if(is_array($msgList) || $msgList instanceof \think\Collection || $msgList instanceof \think\Paginator): $i = 0; $__LIST__ = $msgList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$msg): $mod = ($i % 2 );++$i;?>
                    <li class="<?php echo $msg['postit']; ?>">
                        <a href="">
                            <img src="<?php echo $msg['uavatar']; ?>" alt="<?php echo $msg['nickname']; ?>" class="avatar">
                        </a>
                        <div>
                            <span class="content"><?php echo $msg['xcx_msg_content']; ?></span>
                            <span class="time"><?php echo $msg['xcx_msg_add_time']; ?></span>
                        </div>

                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <div class="layui-form-item layui-form-text">
                    <div class="layui-input-block">
                        <textarea placeholder="请输入房源简介" id="contne" maxlength="500" name="content" class="layui-textarea"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <span class="layui-btn" id="send">发送</span>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    $('#send').click(function () {
        var mpid = <?php echo $mpid; ?>;
        var content = $('#contne').val();
        var now = new Date();
        var year = now.getFullYear(); //得到年份
        var month = now.getMonth();//得到月份
        var date = now.getDate();//得到日期
        var hour = now.getHours();//得到小时
        var minu = now.getMinutes();//得到分钟
        var sec = now.getSeconds();//得到秒
        var nowDate = year+'-'+month+'-'+date+' '+hour+':'+minu+':'+sec;
        var html ='<li class="message-r">\n' +
            '                        <a href="">\n' +
            '                            <img src="<?php echo $uavatar; ?>" alt="<?php echo $unickname; ?>" class="avatar">\n' +
            '                        </a>\n' +
            '                        <div>\n' +
            '                            <span class="content">'+content+'</span>\n' +
            '                            <span class="time">'+nowDate+'</span>\n' +
            '                        </div>\n' +
            '\n' +
            '                    </li>';
        $('#msg-list').append(html);
        $('#contne').val('')
        $.ajax({
            type: 'POST',
            url: "<?=url('user/sendmsg')?>",
            data: {mpid:mpid,content:content},
            dataType:  'json',
            success: function(data){
            }
        });
    })
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