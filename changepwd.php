<?php session_start(); ?>
<?php
require_once "commonFunctions.php";
include "connection.php";
global $conn;
function getPwd()
{
    $pwd = "";
    global $conn;
    $username = $_SESSION["uname"];
    $sqlForPwd = "select password from names where num = $username";
    $pwdResult = $conn -> query ($sqlForPwd);
    while ($password = $pwdResult -> fetch_assoc())
        $pwd = $password["password"];
    return $pwd;
}

$oriPwd = $newPwd = $rptNewPwd = "";
$oriPwdErr = $newPwdErr = $rptNewPwdErr = "";
$successFeedback = "";
$oriPwdCondition = $newPwdCondition = $rptNewPwdCondition = 0;
$username = $_SESSION["uname"];

if (isset($_POST['Submit1']) &&  $_SERVER["REQUEST_METHOD"] = "POST")    {
    $trueOriPwd = getPwd();
    if (empty($_POST["oriPwd"]))    {
        $oriPwdErr = "原密码不能为空";
        $oriPwdCondition = 1;
    }
    else    {
        $oriPwd = test_input ($_POST["oriPwd"]);
        $oriPwdCondition = 0;
        if ($oriPwd != $trueOriPwd) {
            $oriPwdErr = "原密码不正确";
            $oriPwdCondition = 1;
        }
        else    {
            $oriPwdCondition = 0;
        }
    }

    if (empty($_POST["newPwd"]))    {
        $newPwdErr = "新密码不能为空";
        $newPwdCondition = 1;
    }
    else    {
        $newPwd = test_input ($_POST["newPwd"]);
        $newPwdCondition = 0;
    }

    if (!empty($_POST["rptNewPwd"]))    {
        $rptNewPwd = test_input ($_POST["rptNewPwd"]);
    }
    if ($newPwd != $rptNewPwd)  {
        $rptNewPwdErr = "两次输入不相同";
        $rptNewPwdCondition = 1;
    }
    else    {
        $rptNewPwdCondition = 0;
    }

    $allConditions = $rptNewPwdCondition + $newPwdCondition + $oriPwdCondition;
    if ($allConditions == 0) {
        $sqlChangePwd = "update names set password='$newPwd' where num=$username";
        $act = $conn -> query($sqlChangePwd);
        $successFeedback = "密码修改成功，点击返回登录页面";
        redirect("login.php", 2,"密码修改成功，2秒后返回登陆页面！");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>修改密码</title>
    <style>
        .error {color: #FF0000;}
        .success {color: #00FF00}
    </style>
</head>
<body>
<div align="center">
</div>
<form name="changePassword" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <label>
  <div align="center"></div>
  </label>
  <label>
  <div align="center">
    原密码
    <input type="password" name="oriPwd" value="<?php echo $oriPwd?>">
    <span class="error">*<?php echo $oriPwdErr?></span>
  </div>
  </label>
  <p align="center">
    <label>新密码 
    <input type="password" name="newPwd" value="<?php echo $newPwd?>">
        <span class="error">*<?php echo $newPwdErr?></span>    </label>
  </p>
  <p align="center">
    <label>确认密码
    <input type="password" name="rptNewPwd" value="<?php echo $rptNewPwd?>">
        <span class="error">*<?php echo $rptNewPwdErr?></span>    </label>
  </p>
  <p align="center">
    <label>
    <input type="submit" name="Submit1" value="提交">
    </label>
  </p>
</form>
<p align="center"><span class="success"><?php echo $successFeedback?></span></p>
<p align="center"><a href="upload.php">返回上一页</p>
<p align="center"><a href="login.php">返回登录页面</p>
</body>
</html>