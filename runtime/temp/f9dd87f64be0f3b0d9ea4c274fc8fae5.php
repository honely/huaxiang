<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:95:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\inspect\addtime.html";i:1603708107;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
            <!--基本信息-->
            <div class="layui-tab-item layui-show">
                <form class="layui-form">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-md4">
                            <div class="grid-demo grid-demo-bg1">
                                <div class="layui-form-item">
                                    <label class="layui-form-label"><span style="color: red;">*</span>选择日期</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="hp_plandate" class="layui-input" id="hp_plandate" placeholder="yyyy-MM-dd" lay-verify="required">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="layui-col-md4">
                            <div class="grid-demo">
                                <div class="layui-form-item">
                                    <label class="layui-form-label"><span style="color: red;">*</span>开始时间</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="startime" class="layui-input" id="startime" placeholder="HH:mm:ss" lay-verify="required">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="layui-col-md4">
                            <div class="grid-demo grid-demo-bg1">
                                <div class="layui-form-item" pane>
                                    <label class="layui-form-label"><span style="color: red;">*</span>时长</label>
                                    <div class="layui-input-block">
                                        <select name="hp_chixutime" id="hp_chixutime" lay-filter="aihao" lay-verify="required">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="25">25</option>
                                            <option value="30">30</option>
                                            <option value="35">35</option>
                                            <option value="40">40</option>
                                            <option value="45">45</option>
                                            <option value="50">50</option>
                                            <option value="55">55</option>
                                            <option value="60">60</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><span style="color: red;">*</span>选择最大看房人数</label>
                        <div class="layui-input-inline">
                            <input type="number" class="layui-input" lay-verify="required" name="hp_maxnum" value="50" max="99" min="1" id="hp_maxnum">
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
<script>
    function closeAlls(){
        var hp_maxnum = $('#hp_maxnum').val();
        var hp_chixutime = $('#hp_chixutime').val();
        var startime = $('#startime').val();
        var hp_plandate = $('#hp_plandate').val();
        if(hp_plandate.length<1){
            return layer.msg('请选择看房时间！',{
                time: 2000
            });
        }
        if(startime.length<1){
            return layer.msg('请选择看房开始时间！',{
                time: 2000
            });
        }
        $.ajax({
            type: 'post',
            url: "<?=url('inspect/addtime')?>?id=<?php echo $id; ?>",
            data:{'hp_maxnum':hp_maxnum,'hp_chixutime':hp_chixutime,'startime':startime,'hp_plandate':hp_plandate},
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
    layui.use(['form', 'jquery','upload','laydate'], function(){
        var form = layui.form
            ,laydate = layui.laydate
            ,$ = layui.jquery;
        //限定可选日期
        laydate.render({
            elem: '#hp_plandate'
            ,min: 0
            ,max: '2080-10-14'
        });

        //时间范围
        //限定可选时间
        laydate.render({
            elem: '#startime'
            ,type: 'time'
            ,min: '09:00:00'
            ,max: '21:00:00'
        });

        form.on('select(aihao)', function(data){
            var cid=data.value;
            console.log(cid);
            $.ajax({
                type: 'POST',
                url: "<?=url('inspect/getAdmin')?>?cid="+cid,
                data: {cid:cid},
                dataType:  'json',
                success: function(data){
                    var admin=data.data;
                    var house=data.houses;
                    $("#b_order").html("<option value=''></option>");
                    $.each(admin, function(i, val) {
                        var option1 = $("<option>").val(val.ad_id).text(val.ad_realname);
                        $("#b_order").append(option1);
                        form.render('select');
                    });
                    $("#b_order").get(0).selectedIndex=0;
                    $("#houseTable").empty();
                    if(house.length > 0){
                        $.each(house, function(i, val) {
                            var html = "<tr>\n" +
                                "        <td><input name='hp_hid["+val.id+"]' type='checkbox' lay-skin=\"primary\" /></td>\n" +
                                "        <td>"+val.address+"</td>\n" +
                                "      </tr>";
                            $("#houseTable").append(html);
                            form.render('checkbox');
                        });
                    }else{
                        var html ="<span>暂无数据</span>";
                        $("#houseTable").append(html);
                    }

                }
            });
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