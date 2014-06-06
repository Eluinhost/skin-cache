<?php

namespace PublicUHC\SkinCache\Formatters;


class InvertedImageFormatter extends Formatter {

    /**
     * Inverts the image data
     * @param $data string the image that requires formatting
     * @return string the inverted image data
     */
    public function format($data)
    {
        $image = imagecreatefromstring($data);
        imagefilter($image, IMG_FILTER_NEGATE);
        ob_start();
        imagepng($image);
        $data = ob_get_contents();
        ob_end_clean();
        imagedestroy($image);
        return $data;
    }
}