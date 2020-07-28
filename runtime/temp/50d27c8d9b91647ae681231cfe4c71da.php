<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:91:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\index\index.html";i:1595929821;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $lable['sysname']; ?></title>
    <link rel="stylesheet" href="../../../layui/src/css/layui.css">
    <script src="../../../static/jquery-1.10.2.min.js"></script>
    <script src="../../../layui/src/layui.js"></script>
    <style>
        .layui-nav-tree .layui-nav-child a {
            height: 40px;
            line-height: 40px;
            margin-left: 15px;
        }
        .friend-count{
            margin-left: 63px;
        }
    </style>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo"><?php echo $lable['sysname']; ?></div>
        <ul class="layui-nav layui-layout-left">
            <div style="line-height: 60px;">
                <span><?php echo $lable['welcome']; ?>，<?php echo $admin['r_name']; ?>&nbsp;&nbsp;&nbsp;<?php echo $admin['ad_realname']; ?></span>
            </div>
        </ul>
        <?php if($onlineable == true): ?>
            <ul class="layui-nav layui-layout-left" style="margin-left: 280px;">
                <li class="layui-nav-item">
                    <a href='javascript:' onclick="toUser(this)" style="padding-left: 10px !important;"  data-url="/xcx/user/newui.html"><?php echo $lable['zhanneixin']; ?></a>
                    <span style="margin-left: 63px;display: none" id="unread" class="layui-badge"><?php echo $unread; ?></span>
                </li>
            </ul>
        <?php endif; ?>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a style="padding-left: 10px !important;" href="javascript:void()" data-lang="<?php echo $langs; ?>" id="changeLang">
                    <?php if($langs == 'Cn'): ?>
                    Language（ENG）
                    <?php else: ?>
                    Language（CHN）
                    <?php endif; ?>
                </a>
            </li>
            <li class="layui-nav-item"><a style="padding-left: 10px !important;" href="javascript:location.reload();" ><?php echo $lable['homepage']; ?></a></li>
            <li class="layui-nav-item"><a style="padding-left: 10px !important;"  href="<?=url('login/loginOut')?>"><?php echo $lable['logout']; ?></a></li>
        </ul>
    </div>
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll" >
            <ul class="layui-nav layui-nav-tree" lay-filter="test">
                <?php if($menuList != null): if(is_array($menuList) || $menuList instanceof \think\Collection || $menuList instanceof \think\Paginator): $i = 0; $__LIST__ = $menuList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;if(isset($menu['child']) && $menu['child']): if($menu['m_name'] != "站内信"): ?>
                <li class="layui-nav-item">
                    <a href="javascript:;">
                        <?php if($langs == 'En'): if($menu['m_ename'] == null): ?>
                        <?php echo $menu['m_name']; else: endif; ?>
                        <?php echo $menu['m_ename']; else: ?>
                        <?php echo $menu['m_name']; endif; ?>
                    </a>
                    <?php if(isset($menu['child']) && $menu['child'] != null): if(is_array($menu['child']) || $menu['child'] instanceof \think\Collection || $menu['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $menu['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;if($child['m_id'] != 284): ?>
                    <dl class="layui-nav-child">
                        <dd><a href='javascript:' data-url="/xcx/<?php echo $child['m_control']; ?>/<?php echo $child['m_action']; ?>.html">
                            <?php if($langs == 'En'): if($child['m_ename'] == null): ?>
                            <?php echo $child['m_name']; else: endif; ?>
                            <?php echo $child['m_ename']; else: ?>
                            <?php echo $child['m_name']; endif; ?>
                        </a></dd>
                    </dl>
                    <?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
                </li>
                <?php endif; endif; endforeach; endif; else: echo "" ;endif; endif; ?>
            </ul>
        </div>
    </div>
	<div class='layui-body' style="">
		<iframe id='option' <?php if($ad_role == 1): ?>src="<?=url('index/welcome')?>"<?php else: ?>src="<?=url('house/myhouse')?>"<?php endif; ?>  frameborder='no' width='100%' height='99%'>
        </iframe>
	</div>
</div>
<script>
    $('#changeLang').click(function () {
        var lang = $(this).data('lang');
        console.log(lang);
        $.ajax({
            type: 'POST',
            url: "<?=url('index/changelang')?>?lang="+lang,
            dataType:  'json',
            success: function(data){
                if(data.code == 1){
                    layer.msg(data.msg);
                    window.location.reload();
                }else{
                    layer.msg(data.msg);
                }
            }
        });
    });
</script>
<script>
    //JavaScript代码区域
    layui.use(['element','jquery','layer'], function(){
        var element = layui.element,
		$ = layui.jquery;
		element.on('nav(test)',function(elem){
			var $url = $(elem).eq(0).attr('data-url');
			$("#option").attr('src',$url)
		})
    });
    function toUser(e) {
        var $url = $(e).attr('data-url');
        $("#option").attr('src',$url)
    }
    function hello(){
        $.ajax({
            type:"post",
            async:false,
            url:"<?=url('index/unread')?>",
            dataType:"json",
            success:function(result){
               if (result) {
                    $('#unread').show();
                    $('#unread').html(result);
                }else{
                    $('#unread').hide();
                }
            }
        });
    }
    //重复执行某个方法
    var t1 = window.setInterval(hello,1000);
    var t2 = window.setInterval("hello()",10000);
    //去掉定时器的方法
    window.clearInterval(t1);
</script>
</body>
</html>