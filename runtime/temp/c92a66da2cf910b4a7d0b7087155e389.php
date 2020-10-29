<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:90:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\user\newui.html";i:1601366554;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
   .friend-img{
       width: 40px;
       height: 40px;
       border-radius: 100%;
   }
    .friend-nick{
        width: 100px;
        padding-left: 10px;
        font-size: 16px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .layim-friend{
        position: relative;
        margin: 5px;
        padding: 5px 30px 5px 5px;
        line-height: 40px;
        cursor: pointer;
        border-radius: 3px;
    }
    .current-img{
        position: relative;
        left: 0;
        top: 0;
        width: 50px;
        height: 50px;
        border-radius: 100%;
    }
    .myMsg{
        text-align: right;
        padding-left: 0;
        padding-right: 60px;
        position: relative;
        font-size: 0;
        margin-bottom: 10px;
        padding-left: 60px;
        min-height: 68px;
    }
   .user-div{
       position: absolute;
       left: 3px;
       vertical-align: top;
       font-size: 14px;
   }
   .user-div-l{
       position: absolute;
       vertical-align: top;
       font-size: 14px;
       display: inline-block;
       text-align: right;
   }
   .m-img{
       width: 40px;
       height: 40px;
       border-radius: 100%;
   }
    .user-div-l img{
        width: 40px;
        height: 40px;
        border-radius: 100%;
    }
    .user-div-l cite{
        position: absolute;
        left: 60px;
        top: -2px;
        width: 500px;
        line-height: 24px;
        font-size: 12px;
        white-space: nowrap;
        color: #999;
        text-align: left;
        font-style: normal;
    }
    .user-div cite{
        left: auto;
        right: 60px;
        text-align: right;
        position: absolute;
        /*left: 60px;*/
        top: -2px;
        width: 500px;
        line-height: 24px;
        font-size: 12px;
        white-space: nowrap;
        color: #999;
        font-style: normal;
    }
    .layim-chat-text{
        margin-right: 0;
        text-align: right;
        background-color: #5FB878;
        color: #fff;
        position: relative;
        line-height: 22px;
        margin-top: 25px;
        padding: 8px 15px;
        border-radius: 3px;
        word-break: break-all;
        vertical-align: top;
        font-size: 14px;
        display: inline-block;
    }
    .ulayim-chat-text{
        margin-right: 0;
        text-align: left;
        background-color: #e2e2e2;
        color: #333;
        position: relative;
        line-height: 22px;
        margin-top: 25px;
        margin-left: 60px;
        padding: 8px 15px;
        border-radius: 3px;
        word-break: break-all;
        vertical-align: top;
        font-size: 14px;
        display: inline-block;
    }
    .li{
        position: relative;
        font-size: 0;
        margin-bottom: 10px;
        min-height: 68px;
    }
    .layim-chat-user{
        position: absolute;
        left: auto;
        right: 3px;
        vertical-align: top;
        font-size: 14px;
        text-align: right;
    }
    .mycite{
        left: auto;
        right: 60px;
        text-align: right;
        position: absolute;
        top: -2px;
        width: 500px;
        line-height: 24px;
        font-size: 12px;
        white-space: nowrap;
        color: #999;
        font-style: normal;
    }
    .layim-chat-main{
        padding: 15px 15px 5px;
        overflow-x: hidden;
        overflow-y: auto;
        height: auto;
        min-height: 299px;
    }
    .layim-this{
        background-color: #F3F3F3;
    }
    .layui-left-chat{
        width: 20%;
        float:left;
        display: block;
        background-color: #d9d9d9;
        overflow-x: hidden;
        overflow-y: auto;
        height: 582px;
    }
    .imgs{
        width: 150px;
        height: 150px;
    }
</style>
<div style="margin: 20px;">
    <span class="layui-breadcrumb" lay-separator=">">
        <a><cite>站内信</cite></a>
    </span>
</div>
<div>
    <div>
        <div class="layui-left-chat">
            <ul class="layui-unselect layim-chat-list" id="chat-list">
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
                    <li class="layim-friend layim-chatlist-friend" data-id="<?php echo $item['mp_id']; ?>">
                        <img class="friend-img" src="<?php echo $item['avaurl']; ?>" alt="">
                        <span class="friend-nick"><?php echo $item['nickname']; ?></span>
                        <?php if($item['count'] != 0): if($item['count'] > 100): ?>
                        <span class="friend-count layui-badge">99+</span>
                        <?php else: ?>
                        <span class="friend-count layui-badge"><?php echo $item['count']; ?></span>
                        <?php endif; endif; ?>
                    </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <div style="width: 79%;float:left;display: block">
            <div class="layim-chat-other" style="height: 80px;width: 100%;background-color: #ececec;padding: 8px;">
                <img src="https://wx.huaxiangxiaobao.com/static/logo.png" alt="" class="current-img" id="current-img">
                <span class="layim-chat-username" id="current-nick">花香小宝</span>
                <input type="hidden" id="avatar" value="<?php echo $avatar; ?>">
                <input type="hidden" id="nickname" value="<?php echo $nickname; ?>">
                <p style="margin-top: 10px;" id="houseInfo">房源标题：<span style="color: #00a2d4" id="houseName">South Yarra 阳光大床房转租 赠送家具</span> <span class="layui-btn layui-btn-xs" id="showDetail" data-id="0">查看详情</span></p>
            </div>
            <div class="layim-chat-main">
                <ul id="msglist">
                    <li>在这里你可以和客户沟通！</li>
                </ul>
            </div>
            <div class="foooter" style="display: none" id="foooter">
                <div class="layui-form-item layui-form-text" style="position: fixed;bottom: 0;width: 100%;height: 25px;">
                    <div class="layui-input-inline" style="width: 60%">
                        <input type="text" placeholder="请输入你想说的话..." class="layui-input" id="content" style="border-radius: 105px;">
                        <input type="text" class="layui-input" id="msgType" style="border-radius: 105px;" value="1">
                    </div>
                    <div class="layui-input-inline">
                        <span class="layui-btn" id="send" data-id="0" style="border-radius: 50px;">发送</span>
                        <span class="layui-btn" id="uploadImg" data-id="0" style="border-radius: 50px;">选择图片</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .foooter{
        border-top: 1px solid #F1F1F1;
        position: fixed;
        width: 100%;
        bottom: 0;
    }
</style>
<script>
    layui.use(['form', 'jquery','upload'], function(){
        var form = layui.form
            ,upload = layui.upload
            ,$ = layui.jquery;
        //封面图上传

        upload.render({
            elem: '#uploadImg'
            ,url: "<?=url('user/upload')?>?"
            ,exts: 'jpg|png|jpeg|gif|bmp|JPG'
            ,size: 1024*5
            ,multiple: true
            ,done: function(res){
                var mpid = $('#send').attr('data-id');
                var content = res.filepath;
                $.ajax({
                    type: 'POST',
                    url: "<?=url('user/sendmsg')?>",
                    data: {mpid:mpid,content:content,type:2},
                    dataType:  'json',
                    success: function(data){
                        layer.msg(data.msg);
                        var avatar = $('#avatar').val();
                        var nickname = $('#nickname').val();
                        var now = new Date();
                        var year = now.getFullYear(); //得到年份
                        var month = now.getMonth()+1;//得到月份
                        var date = now.getDate();//得到日期
                        var hour = now.getHours();//得到小时
                        var minu = now.getMinutes();//得到分钟
                        var sec = now.getSeconds();//得到秒
                        var nowDate = year+'-'+month+'-'+date+' '+hour+':'+minu+':'+sec;
                        var html ='<li class="myMsg li">\n' +
                            '                        <div class="layim-chat-user">\n' +
                            '                            <img class="m-img" src="'+avatar+'" alt="">\n' +
                            '                            <cite class="mycite">\n' +
                            '                                <i>'+nowDate+'</i>\n' +
                            '                                '+nickname+'\n' +
                            '                            </cite>\n' +
                            '                        </div><img class="layim-chat-text imgs" src="../../../'+content+'"  onclick="previewImg(this)">\n' +
                                '                    </li>';
                        $('#msglist').append(html);
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).keyup(function(event){
        if(event.keyCode ==13){
            var mpid = $('#send').attr('data-id');
            var avatar = $('#avatar').val();
            var nickname = $('#nickname').val();
            var content = $('#content').val();
            var now = new Date();
            var year = now.getFullYear(); //得到年份
            var month = now.getMonth()+1;//得到月份
            var date = now.getDate();//得到日期
            var hour = now.getHours();//得到小时
            var minu = now.getMinutes();//得到分钟
            var sec = now.getSeconds();//得到秒
            var type =$("#msgType").val();
            var nowDate = year+'-'+month+'-'+date+' '+hour+':'+minu+':'+sec;
            var html ='<li class="myMsg li">\n' +
                '                        <div class="layim-chat-user">\n' +
                '                            <img class="m-img" src="'+avatar+'" alt="">\n' +
                '                            <cite class="mycite">\n' +
                '                                <i>'+nowDate+'</i>\n' +
                '                                '+nickname+'\n' +
                '                            </cite>\n' +
                '                        </div>\n';
            if(type == 1){
                html +='<div class="layim-chat-text">\n' +
                    '                            '+content+'\n' +
                    '                        </div>\n' +
                    '                    </li>';
            }else{
                html +='<img class="layim-chat-text imgs" src="../../../'+content+'"  onclick="previewImg(this)">\n' +
                    '                    </li>';
            }
            $('#msglist').append(html);
            $('#content').val('');
            $.ajax({
                type: 'POST',
                url: "<?=url('user/sendmsg')?>",
                data: {mpid:mpid,content:content,type:type},
                dataType:  'json',
                success: function(data){
                    layer.msg(data.msg);
                }
            });
        }
    });
    $($(".layim-chat-main")).height(document.documentElement.clientHeight-225);
    $($(".layui-left-chat")).height(document.documentElement.clientHeight-65);
    $($("#houseInfo")).hide();
    $('#send').click(function () {
        var mpid = $('#send').attr('data-id');
        var avatar = $('#avatar').val();
        var nickname = $('#nickname').val();
        var content = $('#content').val();
        var now = new Date();
        var year = now.getFullYear(); //得到年份
        var month = now.getMonth();//得到月份
        var date = now.getDate();//得到日期
        var hour = now.getHours();//得到小时
        var minu = now.getMinutes();//得到分钟
        var sec = now.getSeconds();//得到秒
        var type =$("#msgType").val();
        var nowDate = year+'-'+month+'-'+date+' '+hour+':'+minu+':'+sec;
        var html ='<li class="myMsg li">\n' +
            '                        <div class="layim-chat-user">\n' +
            '                            <img class="m-img" src="'+avatar+'" alt="">\n' +
            '                            <cite class="mycite">\n' +
            '                                <i>'+nowDate+'</i>\n' +
            '                                '+nickname+'\n' +
            '                            </cite>\n' +
            '                        </div>\n' ;
        if(type == 1){
            html +='<div class="layim-chat-text">\n' +
                '                            '+content+'\n' +
                '                        </div>\n' +
                '                    </li>';
        }else{
            html +='<img class="layim-chat-text imgs" src="../../../'+content+'"  onclick="previewImg(this)">\n' +
                '                    </li>';
        }
        $('#msglist').append(html);
        $('#content').val('');
        $.ajax({
            type: 'POST',
            url: "<?=url('user/sendmsg')?>",
            data: {mpid:mpid,content:content,type:type},
            dataType:  'json',
            success: function(data){
                layer.msg(data.msg);
            }
        });
    });
    $('#showDetail').click(function () {
        layui.use(['layer'], function(){
            var layer = layui.layer;
            var id = $('#showDetail').attr('data-id');
            layer.open({
                type: 2,
                title: '查看详情',
                shadeClose: true,
                shade: false,
                maxmin: true,
                area: ['80%', '80%'],
                content: "<?=url('house/detail')?>?id="+id
            });
        })
    });
    $("#chat-list li").click(function(){
        $(this).addClass("layim-this").siblings().removeClass("layim-this");
        $('#foooter').show();
        $("#msglist").empty();
        $("#houseInfo").show();
        //假装消除未读
        $(this).children('.friend-count').remove();
        var img = $(this).children('.friend-img').attr('src');
        var nick = $(this).children('.friend-nick').html();
        $('#current-img').attr('src',img);
        $('#current-nick').html(nick);
        var mp_id = $(this).attr('data-id');
        $('#send').attr('data-id',mp_id);
        //根据mp_id异步获取消息内容
        $.ajax({
            type: 'POST',
            url: "<?=url('user/getmsgcon')?>",
            data: {mp_id:mp_id},
            dataType:  'json',
            success: function(data){
                if(data.code == 1 ){
                    var msgs = data.data;
                    console.log(msgs);
                    var user = data.user;
                    console.log(user);
                    var house = data.house;
                    console.log(house);
                    var str = '';
                    for (var i = 0; i <msgs.length; i++) {
                        if(msgs[i].postit == 'message-r'){
                            //消息是我的消息在右边
                            str +='<li class="myMsg li">\n' +
                                '                        <div class="layim-chat-user">\n' +
                                '                            <img class="m-img" src="'+user.avatar+'" alt="">\n' +
                                '                            <cite class="mycite">\n' +
                                '                                <i>'+msgs[i].xcx_msg_add_time+'</i>\n' +
                                '                                '+user.nickname+'\n' +
                                '                            </cite>\n' +
                                '                        </div>\n';
                            if(msgs[i].xcx_msg_type == 1){
                                str +='<div class="layim-chat-text">\n' +
                                    '                            '+msgs[i].xcx_msg_content+'\n' +
                                    '                        </div>\n' +
                                    '                    </li>';
                            }else{
                                str +='<img class="layim-chat-text imgs" src="../../../'+msgs[i].xcx_msg_content+'"  onclick="previewImg(this)">\n' +
                                    '                    </li>';
                            }
                        }else{
                            //消息是你的消息在左边
                            str +='<li class="u-msg li">\n' +
                                '                        <div class="user-div-l">\n' +
                                '                            <img src="'+user.uavatar+'" alt="">\n' +
                                '                            <cite class="ucite">\n' +
                                '                                <i>'+msgs[i].xcx_msg_add_time+'</i>\n' +
                                '                               '+user.unickname+'\n' +
                                '                            </cite>\n' +
                                '                        </div>\n';
                            ;
                            if(msgs[i].xcx_msg_type == 1){
                                str +='<div class="ulayim-chat-text">\n' +
                                    '                            '+msgs[i].xcx_msg_content+'\n' +
                                    '                        </div>\n' +
                                    '                    </li>';
                            }else{
                                str +='<img class="ulayim-chat-text imgs" src="../../../'+msgs[i].xcx_msg_content+'"  onclick="previewImg(this)">\n' +
                                    '                    </li>';
                            }

                        }
                    }
                    $("#msglist").html(str);
                    $("#houseName").html(house.title);
                    $("#showDetail").attr('data-id',house.id);
                }else{

                }
            }
        });
    });
    function previewImg(obj) {
        var img = new Image();
        img.src = obj.src;
        var imgHtml = "<img src='" + obj.src + "' />";
        layui.use(['layer'], function(){
            var layer = layui.layer;
            layer.open({
                type: 1,
                shade: false,
                title: false, //不显示标题
                area: [600+'px', 480+'px'],
                content: imgHtml,
                cancel: function () {
                }
            });
        });
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