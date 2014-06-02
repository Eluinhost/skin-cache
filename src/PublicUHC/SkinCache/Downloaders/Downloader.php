<?php

namespace PublicUHC\SkinCache\Downloaders;

use PublicUHC\SkinCache\Exceptions\DownloadException;

abstract class Downloader {

    /**
     * @param $username String the username to fetch
     * @return resource the skin data
     * @throws DownloadException if fetching failed
     */
    abstract function downloadSkin($username);

    /**
     * @param $username String the username to fetch
     * @param $size int the dimensions of the square image
     * @return resource the helm data
     */
    abstract function downloadHelm($username, $size);

    /**
     * @param $username String the username to fetch
     * @param $size int the dimensions of the square image
     * @return resource the head data
     */
    abstract function downloadHead($username, $size);

} 