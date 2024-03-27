<?php
session_start();

$username = $_SESSION["uname"];
$realName = $_SESSION["rname"];

$allowedExtensions = array("gif", "jpeg", "jpg", "png", "pdf", "docx");
$temp = explode(".", $_FILES["file"]["name"]);
echo $_FILES["file"]["size"];
$extension = end($temp);
if (/*($_FILES["file"]["size"] < 67108864)&& */in_array($extension, $allowedExtensions))
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo "错误：: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
        echo "上传文件名: " . $_FILES["file"]["name"] . "<br>";
        echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
        echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
//        echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"] . "<br>";

        if (file_exists($realName."/" . $_FILES["file"]["name"]))
        {
            echo $_FILES["file"]["name"] . " 已经存在。 ";
        }
        else
        {
            move_uploaded_file($_FILES["file"]["tmp_name"], $realName."/" . $_FILES["file"]["name"]);
            echo "文件存储在: " . $realName."/" . $_FILES["file"]["name"];
        }
    }
}
else
{
    echo "非法的文件";
}
?>

<p><a href = "upload.php">back</a></p>