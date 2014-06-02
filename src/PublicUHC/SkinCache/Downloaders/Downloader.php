<?php

namespace PublicUHC\SkinCache\Downloaders;

use Stash\Interfaces\PoolInterface;

abstract class Downloader {

    private $cachePool;

    public function __construct(PoolInterface $cache)
    {
        $this->cachePool = $cache;
    }

    abstract function downloadSkin($username);

    abstract function downloadHelm($username, $size);

    abstract function downloadHead($username, $size);

} 