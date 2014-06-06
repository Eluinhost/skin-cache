<?php
namespace PublicUHC\SkinCache\Formatters;

interface Formatter {

    /**
     * Format the image data
     * @param $data string the image that requires formatting
     * @return mixed the formatted data
     */
    public function format($data);

} 