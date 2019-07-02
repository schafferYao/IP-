<?php
session_start();

require_once 'mysql.php';

if(!isset($_SESSION['username'])){
    header('location:login.php');
}


echo "欢迎用户" . $_SESSION['username'];
echo "<hr>";
?>
<h2>发布定位</h2>
<form action="" method="post">
    备注信息：<textarea cols="100" rows="10"name="remarks"></textarea><br>
    <input type="submit" value="生成链接">

</form>
<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //验证账号
    $remarks = $_POST['remarks'];
    $userId = 1;

    $mysql = new Mysql();
    $data = array(
        'user_id' => $userId,
        'remarks' => $remarks,
        'create_time' => time(),
    );
    $res = $mysql->insertTrack($data);
    if(!$res){
        die('创建错误');
    }

    echo "创建成功ID：<span style='color: red'>".$res .'</span><br>';
    echo "链接地址:<span style='color: red'>http://location.yaoxiangfei.com?id=".$res.'</span><br>';
}


?>
<hr>
<h2>查询信息</h2>
<form action="" method="get">
    查询定位ID:<input type="input" name="id" value="">
    <input type="submit" value="查询">
</form>

<table  border="1" width="100%">
<thead >
<tr>
    <th width="30px">id</th><th width="100px">ip地址</th><th width="100px">城市</th><th>浏览器定位</th><th>SDK定位</th><th>访问时间</th><th>操作</th>
</tr>

</thead>
    <tbody>
    <?php
        if($id = $_GET['id']){
            $mysql = new Mysql();
            $list = $mysql->getAllTrack($id);
            foreach($list as $item){
    ?>
    <tr>
        <td><?php echo $item['id']; ?></td>
        <td ><?php echo long2ip($item['ip']); ?></td>
        <td><?php echo $item['city']; ?></td>
        <td><?php echo $item['browser']; ?></td>
        <td><?php echo $item['sdk']; ?></td>
        <td><?php echo date('Y-m-d H:i:s',$item['create_time']); ?></td>
        <td><?php echo '<a target="_blank" href="/details.php?id='. $item['id'] .'">查看</a>'; ?></td>
    </tr>
    <?php
            }
        }

    ?>
    </tbody>
</table>