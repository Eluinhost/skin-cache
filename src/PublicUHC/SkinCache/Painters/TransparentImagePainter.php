<?php
namespace PublicUHC\SkinCache\Painters;


class TransparentImagePainter implements ErrorImagePainter {

    public function getImage($sizeX, $sizeY)
    {
        $image = imagecreatetruecolor($sizeX, $sizeY);
        imagealphablending($image, false);
        $col=imagecolorallocatealpha($image,255,255,255,127);
        imagefilledrectangle($image,0,0,$sizeX, $sizeY,$col);
        imagesavealpha($image,true);
        ob_start();
        imagepng($image);
        $imageString = ob_get_contents();
        ob_end_clean();
        imagedestroy($image);
        return $imageString;
    }
}