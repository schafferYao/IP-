<?php
/**
 * 接收用户IP地址数据
 */

require_once 'mysql.php';

$data = $_POST;
if(empty($data)){
    die('');
}

$save = [];
if($data['type'] == 'browser'){
    $save = array(
        'browser' => $data['lng'].','.$data['lat'],
    );
}

//IP定位城市
if($data['type'] == 'ip'){
    $save = array(
        'city' => $data['city'],
    );
}

//SDK
if($data['type'] == 'sdk'){
    $save = array(
        'sdk' => $data['lng'].','.$data['lat'],
    );
}

$mysql = new Mysql();


$res = $mysql->update($data['id'],$save);
var_dump($res);