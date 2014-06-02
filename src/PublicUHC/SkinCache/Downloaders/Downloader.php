<?php

namespace PublicUHC\SkinCache\Downloaders;

use PublicUHC\SkinCache\Exceptions\DownloadException;
use Stash\Interfaces\PoolInterface;

abstract class Downloader {

    private $cachePool;

    public function __construct(PoolInterface $cache)
    {
        $this->cachePool = $cache;
    }

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