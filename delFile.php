<?php
include_once "commonFunctions.php";
session_start();
$rname = $_SESSION['rname'];
$fileName = $_GET['file'];
$filePath = $rname.'/'.$fileName;
$thumbnailPath = $rname."/thumbnails/".$fileName;
if (file_exists($thumbnailPath))    {
    unlink($thumbnailPath);
}
if (file_exists($filePath)) {
    unlink($filePath);
    redirect("upload.php", 1, "文件删除成功");
}