<?php
function getThumbnail($imageName)
{
    $thumbnailDir = $_SESSION["rname"]."/thumbnails/";
    if (!is_dir($thumbnailDir)) {
        mkdir($thumbnailDir);
    }
    $sourceImagePath = $_SESSION["rname"]."/".$imageName;
    $thumbnailWidth = 100;
    $thumbnailHeight = 100;
    $temp = explode(".", $imageName);
    $extension = end($temp);
    if ($extension == "jpeg" || $extension == "jpg")
        $sourceImage = imagecreatefromjpeg($sourceImagePath);
    else if ($extension == "png")
        $sourceImage = imagecreatefrompng($sourceImagePath);
    else if ($extension == "gif")
        $sourceImage = imagecreatefromgif($sourceImagePath);
    else
        return 0;
    $sourceWidth = imagesx($sourceImage);
    $sourceHeight = imagesy($sourceImage);
    if ($sourceWidth > $sourceHeight)   {
        $thumbnailHeight = intval($sourceHeight / $sourceWidth * $thumbnailWidth);
    }
    else    {
        $thumbnailWidth = intval($sourceWidth / $sourceHeight * $thumbnailHeight);
    }
    $thumbnailImage = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);

    imagecopyresampled($thumbnailImage, $sourceImage, 0, 0, 0, 0, $thumbnailWidth,$thumbnailHeight, $sourceWidth,$sourceHeight);
    if ($extension == "jpeg" || $extension == "jpg")
        imagejpeg($thumbnailImage, $thumbnailDir.$imageName);
    else if ($extension == "png")
        imagepng($thumbnailImage, $thumbnailDir.$imageName);
    else if ($extension == "gif")
        imagegif($thumbnailImage, $thumbnailDir.$imageName);
    imagedestroy($sourceImage);
    imagedestroy($thumbnailImage);
}