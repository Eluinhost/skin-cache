<?php

namespace PublicUHC\SkinCache\Formatters;


class RawImageFormatter implements Formatter {

    /**
     * Doesn't format the image, passes the raw image back
     * @param $data string the image that requires formatting
     * @return string the same image
     */
    public function format($data)
    {
        return $data;
    }
}