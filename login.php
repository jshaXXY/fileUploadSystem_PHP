<?php
session_start();
require_once "commonFunctions.php";
include "connection.php";
global $conn;
if ($conn->connect_error) {
    die("服务器连接失败: " . $conn->connect_error);
}

$username = $password = "";
$loginFeedback = "";

if (isset($_POST['Submit0']) &&  $_SERVER["REQUEST_METHOD"] = "POST")    {
    if (!empty($_POST["username"])) {
        $username = test_input ($_POST["username"]);
    }
    if (!empty($_POST["password"])) {
        $password = test_input ($_POST["password"]);
    }

    $_SESSION["uname"] = $username;
    $_SESSION["pwd"] = $password;

    $sql = "select * from names where num = '$username' and password = '$password'";

    $result = $conn->query($sql);
    if (!$result) {
        printf("发生错误: %s\n", mysqli_error($conn));
        exit();
    }
    $rows = $result->fetch_assoc();
    if ($rows) {
        redirect("upload.php", 1, "登录成功，即将自动跳转！");
    }
    else
        $loginFeedback = "请检查账号或密码";
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1">
    <title>登录</title>
</head>
<style>
    .warning {color: #FF0000}
</style>
<body>
<form name="form0" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label>
    <div align="center">账号
        <input type="text" name="username" value="<?php echo $username?>">
    </div>
    </label>
    <label>
        <div align="center">密码
          <input type="password" name="password" value="<?php echo $password?>">
          <br>
          <input type="submit" name="Submit0" value="登录">
        </div>
    </label>
</form>
<p align="center"><span class="warning"><?php echo "$loginFeedback"?></span></p>
</body>
</html>