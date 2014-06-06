<?php

namespace PublicUHC\SkinCache\Formatters;


class GreyscaleFormatter extends Formatter {

    /**
     * Format the image data
     * @param $data string the string image that requires formatting
     * @return string greyscale version of the image string
     */
    public function format($data)
    {
        $image = imagecreatefromstring($data);
        imagefilter($image, IMG_FILTER_GRAYSCALE);
        ob_start();
        imagepng($image);
        $data = ob_get_contents();
        ob_end_clean();
        imagedestroy($image);
        return $data;
    }
}