<?php

namespace PublicUHC\SkinCache\Downloaders;


use PublicUHC\SkinCache\Exceptions\MissingDependencyException;

class MinotarDownloader extends Downloader {

    function downloadSkin($username, $size)
    {
        // TODO: Implement downloadSkin() method.
    }

    function downloadHelm($username, $size)
    {
        // TODO: Implement downloadHelm() method.
    }

    function downloadHead($username, $size)
    {
        // TODO: Implement downloadHead() method.
    }

    function checkForCurl() {
        if (!function_exists('curl_version')) {
            throw new MissingDependencyException('Curl needs to be installed to fetch from Minotar.');
        }
    }
}