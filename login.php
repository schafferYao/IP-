<?php

if(isset($_SESSION['username'])){
    header('location:manage.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //验证账号
    $username = $_POST['username'];
    $password = $_POST['password'];
    if($username == 'admin' && $password == 'admin'){
        session_start();
        $_SESSION["username"] = $username;
        header('Location:manage.php');
    }

    die('账号或密码错误');
}


?>


<div>
    <form action="" method="post" >
        账号:<input type="input" name="username" value="">
        密码:<input type="password" name="password" value="">
        <input type="submit" value="登陆">
    </form>

</div>
