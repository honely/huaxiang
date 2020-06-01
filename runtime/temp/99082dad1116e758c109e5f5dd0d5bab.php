<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:94:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\admin\editrole.html";i:1591003787;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1587691504;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1583744281;}*/ ?>
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
    .fr{
        float: right;
    }
    .layui-form-item .layui-input-inline{
        width: 130px;
    }
    .layui-form-item{
        margin-bottom: 0;
    }
</style>
<div class="layui-body">
    <div style="margin: 20px;">
    <span class="layui-breadcrumb" lay-separator=">">
        <a>员工管理</a>
        <a href="<?=url('admin/role')?>">角色列表</a>
        <a><cite>编辑角色</cite></a>
    </span>
        <div style="float:right;">
            <a href="<?=url('admin/role')?>" class="layui-btn layui-btn-primary layui-btn-sm">
                <i class="layui-icon layui-icon-return"></i>
                返回列表</a>
        </div>
    </div>
    <hr/>
    <div style="padding: 15px;">
        <form class="layui-form" id="addRoles" method="post">
            <div class="layui-form-item" style="margin-bottom: 15px;">
                <label class="layui-form-label"><span style="color: red;">*</span>角色名称</label>
                <div class="layui-input-block">
                    <input type="text" name="r_name" value="<?php echo $roleInfo['r_name']; ?>" id="r_name" lay-verify="required|title" placeholder="请输入角色名称" autocomplete="off" class="layui-input">
                </div>
            </div>
            <?php if(is_array($menuList) || $menuList instanceof \think\Collection || $menuList instanceof \think\Paginator): $i = 0; $__LIST__ = $menuList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?>
            <div class="layui-collapse">
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">系统 ><?php echo $menu['m_name']; ?></h2>
                    <div class="layui-colla-content">
                        <?php if(is_array($menu['child']) || $menu['child'] instanceof \think\Collection || $menu['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $menu['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?>
                        <div class="layui-form-item">
                            <div class="layui-form-label"><?php echo $child['m_name']; ?>：</div>
                            <?php if(is_array($child['children']) || $child['children'] instanceof \think\Collection || $child['children'] instanceof \think\Paginator): $i = 0; $__LIST__ = $child['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$children): $mod = ($i % 2 );++$i;?>
                            <div class="layui-input-inline">
                                <input lay-skin="primary" class="layui-input xuan checks" type="checkbox" title="<?php echo $children['m_name']; ?>"
                                    <?php if(is_array($m_ids) || $m_ids instanceof \think\Collection || $m_ids instanceof \think\Paginator): $i = 0; $__LIST__ = $m_ids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;if($item == $children['m_id']): ?>checked<?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                    value="<?php echo $child['m_fid']; ?>,<?php echo $children['m_fid']; ?>,<?php echo $children['m_id']; ?>" >
                            </div>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                            <div class="fr qx">
                                <input type="checkbox" lay-filter="qunaxuan" class="checks"
                                   <?php if(is_array($m_ids) || $m_ids instanceof \think\Collection || $m_ids instanceof \think\Paginator): $i = 0; $__LIST__ = $m_ids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$it): $mod = ($i % 2 );++$i;if($it == $child['m_id']): ?>checked<?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                   value="<?php echo $child['m_fid']; ?>,<?php echo $child['m_id']; ?>" name="" title="选则" lay-skin="primary">
                            </div>
                        </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <div class="layui-form-item" style="margin-top: 15px;">
                <div class="layui-input-block">
                    <span class="layui-btn" lay-filter="saveInfo" id="saveInfo">修改</span>
                    <a class="layui-btn layui-btn-primary" href="<?=url('admin/role')?>">返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    layui.use(['form', 'jquery','element'], function(){
        var form = layui.form
            ,$ = layui.jquery;
        //选中某一模块，模块下面的菜单和方法都选中
        // 全选
        form.on('checkbox(qunaxuan)', function (data) {
            var _this = $(data.elem);
            var child = $(data.elem).parents('.qx').siblings('.layui-input-inline').children('input')
            child.each(function (index,item) {
                item.checked = data.elem.checked;

            })
            form.render('checkbox')
        })
        form.on('submit(saveInfo)', function(data){


        });
    });
    $('#saveInfo').click(function () {
        //1.获取选中的id；
        var ids = "";
        var icheck=document.getElementsByClassName('checks');
        for(var i=0;i<icheck.length;i++){
            if(icheck.item(i).checked){
                ids+=icheck.item(i).value;
                ids+=",";
            }
        }
        var r_name=$('#r_name').val();
        var r_id=<?php echo $roleInfo['r_id']; ?>;
        $.ajax({
            type:"post",
            url: "<?=url('admin/editmenuids')?>",
            data:{'ids':ids,'r_name':r_name,'r_id':r_id},
            success:function (result) {
                console.log(result);
                if(result.code == '1'){
                    layer.alert('修改角色成功！', {
                        icon: 1,
                        skin: 'layer-ext-moon',
                        time: 2000,
                        end: function(){
                            window.location.href='<?=url("admin/role")?>';
                        }
                    });
                }else{
                    layer.alert('修改角色成功！', {
                        icon: 2,
                        skin: 'layer-ext-moon',
                        time: 2000,
                        end: function(){
                            window.location.href='<?=url("admin/editrole")?>?r_id='+r_id;
                        }
                    });
                }
            },
            'error':function (error) {
                console.log(error);
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