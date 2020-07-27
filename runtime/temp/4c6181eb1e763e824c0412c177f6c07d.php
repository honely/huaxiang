<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:93:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\public/../application/xcx\view\index\welcome.html";i:1595847947;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\header.html";i:1591180794;s:82:"D:\phpStudy\PHPTutorial\WWW\newxcx\huaxiang\application\xcx\view\index\footer.html";i:1577269681;}*/ ?>
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
    .red{
        color: red;
    }
    .layui-card{
        width: 100%;
    }
</style>
<div class="layui-body" style="width: 97%;">
    <div class="layui-main" style="width: 97%;">
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
            <legend><?php echo $lable['homepage']; ?></legend>
        </fieldset>
    </div>
    <div style="padding: 10px; background-color: #F2F2F2;">
        <div class="layui-row layui-col-space15" style="width: 100% !important;">
            <div class="layui-col-md3" style="width: 24% !important;">
                <div class="layui-card">
                    <a>
                        <div class="layui-card-header"><?php echo $lable['totalHouse']; ?></div>
                        <div class="layui-card-body">
                            <h2 class="red"><?php echo $allHouse; ?></h2>
                        </div>
                    </a>
                </div>
            </div>
            <div class="layui-col-md3"  style="width: 24% !important;">
                <div class="layui-card">
                    <a>
                        <div class="layui-card-header"><?php echo $lable['todayIncHouse']; ?></div>
                        <div class="layui-card-body">
                            <h2 class="red"><?php echo $todayHouse; ?></h2>
                        </div>
                    </a>
                </div>
            </div>
            <div class="layui-col-md3"  style="width: 24% !important;">
                <div class="layui-card">
                    <a>
                        <div class="layui-card-header"><?php echo $lable['totalUser']; ?></div>
                        <div class="layui-card-body">
                            <h2 class="red"><?php echo $allUser; ?></h2>
                        </div>
                    </a>
                </div>
            </div>
            <div class="layui-col-md3"  style="width: 24% !important;">
                <div class="layui-card">
                    <a>
                        <div class="layui-card-header"><?php echo $lable['todayIncUser']; ?></div>
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
                <div id="main1" style="width: 600px;height:400px;"></div>
            </div>
            <div class="layui-col-md6">
                <div id="main" style="width: 600px;height:400px;"></div>
            </div>
        </div>
    </div>
    <div style="padding: 20px; background-color: #F2F2F2;">
        <div class="layui-row layui-col-space15">

            <div class="layui-col-md6">
                <div id="main2" style="width: 600px;height:400px;"></div>
            </div>
           <div class="layui-col-md6">
                <div id="main3" style="width: 600px;height:400px;"></div>
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
    var myChart3 = echarts.init(document.getElementById('main3'));
    var arr1=[],arr2=[],arr3=[];
    var names = [];
    var statusname = [];
    var brower = [];
    var numbs = [];
    function arrTest(){
        $.ajax({
            type:"post",
            async:false,
            url:"<?=url('index/getHouse')?>",
            data:{},
            dataType:"json",
            success:function(result){
                if (result) {
                    for (var i = 0; i < result.length; i++) {
                        arr1.push(result[i].date);
                        arr2.push(result[i].nums);
                        arr3.push(result[i].users);
                    }
                }
            }
        });$.ajax({
            type:"post",
            async:false,
            url:"<?=url('index/getHousePie')?>",
            data:{},
            dataType:"json",
            success:function(result){
                if (result) {
                    $.each(result, function(index, item) {
                        names.push(item.name); //挨个取出类别并填入类别数组
                        brower.push({
                            name: item.name,
                            value: item.value
                        });
                    });
                }
            }
        });
        $.ajax({
            type:"post",
            async:false,
            url:"<?=url('index/getHousePieStatus')?>",
            data:{},
            dataType:"json",
            success:function(result){
                console.log(result);
                if (result) {
                    $.each(result, function(index, item) {
                        statusname.push(item.name); //挨个取出类别并填入类别数组
                        numbs.push({
                            name: item.name,
                            value: item.value
                        });
                    });
                }
            }
        });
        return arr1,arr2,arr3,names,brower,statusname,numbs;
    }
    arrTest();

    // 指定图表的配置项和数据
    option = {
        title: {
            text: '<?php echo $lable['dayIncHouse']; ?>'
        },
        xAxis: {
            type: 'category',
            data: arr1
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: arr2,
            type: 'line'
        }]
    };
    option1 = {
        title: {
            text: '<?php echo $lable['dayIncUser']; ?>'
        },
        xAxis: {
            type: 'category',
            data: arr1
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: arr3,
            type: 'line',
            smooth: true
        }]
    };
    option2 = {
        title: {
            text: '<?php echo $lable['PieHouse']; ?>',
            left: 'center'
        },
        tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b} : {c} ({d}%)'
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data: names
        },
        series: [
            {
                name: 'Percent',
                type: 'pie',
                radius: '55%',
                center: ['50%', '60%'],
                data: brower,
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
 //房源状态分布图
    option3 = {
        title: {
            text: '<?php echo $lable['statusPieHouse']; ?>',
            left: 'center'
        },
        tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b} : {c} ({d}%)'
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data: statusname
        },
        series: [
            {
                name: 'Percent',
                type: 'pie',
                radius: '55%',
                center: ['50%', '60%'],
                data: numbs,
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
   myChart3.setOption(option3);
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