<?php

namespace PublicUHC\SkinCache\Downloaders;

use Stash\Pool;

abstract class Downloader {

    private $cachePool;

    public function __construct(Pool $cache)
    {
        $this->cachePool = $cache;
    }

    abstract function downloadSkin($username, $size);

    abstract function downloadHelm($username, $size);

    abstract function downloadHead($username, $size);

} 