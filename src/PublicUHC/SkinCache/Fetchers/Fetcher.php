<?php

namespace PublicUHC\SkinCache\Fetchers;


use PublicUHC\SkinCache\Downloaders\Downloader;
use PublicUHC\SkinCache\Formatters\Formatter;
use Stash\Interfaces\PoolInterface;

abstract class Fetcher {

    private $downloader;
    private $formatter;
    private $cachePool;

    public function __construct(Downloader $downloader, Formatter $formatter, PoolInterface $cachePool)
    {
        $this->downloader = $downloader;
        $this->formatter = $formatter;
        $this->cachePool = $cachePool;
    }

    abstract function fetchSkin($username);

    abstract function fetchHelm($username);

    abstract function fetchHead($username);
} 