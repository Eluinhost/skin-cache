<?php
namespace PublicUHC\SkinCache\Painters;


interface ErrorImagePainter {

    /**
     * Fetch an error image for the size give
     * @param $sizeX int the x length
     * @param $sizeY int the y height
     * @return string the image
     */
    public function getImage($sizeX, $sizeY);
} 