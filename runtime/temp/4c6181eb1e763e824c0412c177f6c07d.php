<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:93:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\index\welcome.html";i:1587694899;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1587691504;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1583744281;}*/ ?>
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
    .red{
        color: red;
    }
</style>
<div class="layui-body" style="width: 97%;">
    <div class="layui-main" style="width: 97%;">
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
            <legend>网站首页</legend>
        </fieldset>
    </div>
    <div style="padding: 20px; background-color: #F2F2F2;">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md3">
                <div class="layui-card">
                    <a href="<?=url('order/order')?>?step=1">
                        <div class="layui-card-header">房源总数</div>
                        <div class="layui-card-body">
                            <h2 class="red"><?php echo $allHouse; ?></h2>
                        </div>
                    </a>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <a href="<?=url('order/order')?>?step=3">
                        <div class="layui-card-header">今日新增房源</div>
                        <div class="layui-card-body">
                            <h2 class="red"><?php echo $todayHouse; ?></h2>
                        </div>
                    </a>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <a href="<?=url('clean/export')?>">
                        <div class="layui-card-header">用户总数</div>
                        <div class="layui-card-body">
                            <h2 class="red"><?php echo $allUser; ?></h2>
                        </div>
                    </a>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <a href="<?=url('house/wait')?>">
                        <div class="layui-card-header">今日新增用户</div>
                        <div class="layui-card-body">
                            <h2 class="red"><?php echo $todayUser; ?></h2>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 20px; background-color: #F2F2F2;">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md6">
                <div id="main" style="width: 600px;height:400px;"></div>
            </div>
            <div class="layui-col-md6">
                <div id="main2" style="width: 600px;height:400px;"></div>
            </div>
        </div>
    </div>
    <div style="padding: 20px; background-color: #F2F2F2;">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md6">
                <div id="main1" style="width: 600px;height:400px;"></div>
            </div>
        </div>
    </div>
</div>
<script src="../../../echarts/echarts.min.js"></script>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));
    var myChart1 = echarts.init(document.getElementById('main1'));
    var myChart2 = echarts.init(document.getElementById('main2'));

    // 指定图表的配置项和数据
    option = {
        title: {
            text: '房源每日新增'
        },
        xAxis: {
            type: 'category',
            data: ['2020-04-17', '2020-04-18', '2020-04-19', '2020-04-20', '2020-04-21', '2020-04-22', '2020-04-23']
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [820, 932, 901, 934, 1290, 1330, 1320],
            type: 'line'
        }]
    };
    option1 = {
        title: {
            text: '用户每日新增'
        },
        xAxis: {
            type: 'category',
            data: ['2020-04-17', '2020-04-18', '2020-04-19', '2020-04-20', '2020-04-21', '2020-04-22', '2020-04-23']
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [820, 932, 901, 934, 1290, 1330, 1320],
            type: 'line',
            smooth: true
        }]
    };
    option2 = {
        title: {
            text: '房源分布图',
            left: 'center'
        },
        tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b} : {c} ({d}%)'
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data: ['墨尔本', '悉尼', '布利斯班', '霍巴特', '朗塞斯顿']
        },
        series: [
            {
                name: '访问来源',
                type: 'pie',
                radius: '55%',
                center: ['50%', '60%'],
                data: [
                    {value: 335, name: '墨尔本'},
                    {value: 310, name: '悉尼'},
                    {value: 234, name: '布利斯班'},
                    {value: 135, name: '霍巴特'},
                    {value: 1548, name: '朗塞斯顿'}
                ],
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };


    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
    myChart1.setOption(option1);
    myChart2.setOption(option2);
</script>
<script>
    layui.use(['element','jquery','layer'], function(){
        var element = layui.element,
            $ = layui.jquery,
            layer = layui.layer;
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