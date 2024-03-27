<html>
<head>
    <meta charset="utf-8">
    <title>上传文件</title>
</head>
<body>
<p align="center"><a href="login.php">返回登录页</a></p>
<div align="center">

<?php
session_start();
require_once "commonFunctions.php";
require_once "thumbnail.php";
include "connection.php";
global $conn;

$username = $_SESSION["uname"];
$sqlForRealName = "select name from names where num = '$username'" ;
$realNameResult = $conn -> query ($sqlForRealName);
while ($realName = $realNameResult -> fetch_assoc())
    $rname = $realName["name"];
$_SESSION["rname"] = $rname;

if (!is_dir($rname)) {
    mkdir($rname);
}

echo "欢迎，".$rname."!<br>";
$dirArray = getDirContent($rname);
$dirArray = arrayElementDel($dirArray, "thumbnails");
?>
  
</div>
<p align="center"><a href = "changepwd.php">修改密码</a></p>
<form action="upload_file.php" method="post" enctype="multipart/form-data">
    <label for="file"></label>

    <p align="center">文件要求为jpg、jpeg、png、gif、docx、pdf格式，且小于8MB。</p>
    <p align="center"><br>
      <input type="file" name="file" id="file">
  </p>
    <p align="center"><br>
      <input type="submit" name="submit" value="提交">
      </p>
</form>
<br>
<p align="center">已上传文件：</p><HR>

<?php
$allowedExtensions = array("gif", "jpeg", "jpg", "png");
for ($i = 0; $i < count($dirArray); $i++)  {
    $temp = explode(".", $dirArray[$i]);
    $extension = end($temp);
    if (in_array($extension, $allowedExtensions))   {
        getThumbnail($dirArray[$i]);
        echo "<p align=center><img src=$rname"."/thumbnails"."/$dirArray[$i]"."/></p>";
    }
    else    {
        echo "<p align=center>（无预览）</p>";
    }
    echo "<p align=center>$dirArray[$i]</p>";
//    echo "<button id='delButton'>点击我</button><script src='script.js'></script>";
    echo "<HR>";
}
?>

</body>
</html>