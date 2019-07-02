<?php
require_once 'mysql.php';

$id = $_GET['id'];
if(!$id){
    die('id错误');
}

$mysql = new Mysql();
$details = $mysql->getOneTrack($id);
if(!$details){
    die('记录不存在');
}

if(isset($_GET['type']) && $_GET['type'] == 'sdk'){
    $data = explode(',',$details['sdk']);
}else{
    $data = explode(',',$details['browser']);
}

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
        body, html{width: 100%;height: 100%;margin:0;font-family:"微软雅黑";}
        #allmap{margin-left:20px;margin-right:20px;height:80%;width:100%;}
        #r-result{width:100%; font-size:14px;}
    </style>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=PuRL8soZmobdbOIgdGDQ0qCxdYWTGgK2"></script>
    <title>定位管理</title>
</head>
<body>
<div style="margin-left: 20px;">
    <h2>定位详情</h2>
    <h3>使用【<a href="/details.php?type=browser&id=<?php echo $id; ?>">浏览器(默认)</a>】或【<a href="/details.php?type=sdk&id=<?php echo $id; ?>">SDK</a>】查询位置(*可根据经纬度使用第三方地图查询)</h3>
    <p><b>id</b>：<?php echo $details['id']; ?> </p>
    <p><b>track_id</b>：<?php echo $details['track_id']; ?></p>
    <p><b>IP</b>：<?php echo long2ip($details['ip']); ?></p>
    <p>城市：<?php echo $details['city']; ?></p>
    <p>浏览器经纬度：<?php echo $details['browser']; ?></p>
    <p>SDK经纬度：<?php echo $details['sdk']; ?></p>
    <p>浏览器信息：<?php echo $details['user_agent']; ?></p>
    <p>访问时间：<?php echo date('Y-m-d H:i:s',$details['create_time']); ?></p>
</div>

<div id="allmap"></div>
</body>
</html>
<script type="text/javascript">

    var lng = <?php echo $data[0]; ?>;
    var lat = <?php echo $data[1]; ?>;

    // 百度地图API功能
    var map = new BMap.Map("allmap");
    map.centerAndZoom(new BMap.Point(116.331398,39.897445),11);
    map.enableScrollWheelZoom(true);

    // 用经纬度设置地图中心点
    function theLocation(){
        map.clearOverlays();
        var new_point = new BMap.Point(lng,lat);
        var marker = new BMap.Marker(new_point);  // 创建标注
        map.addOverlay(marker);              // 将标注添加到地图中
        map.panTo(new_point);
    }

    theLocation();

</script>
