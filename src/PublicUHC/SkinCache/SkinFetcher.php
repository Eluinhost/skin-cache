<?php

namespace PublicUHC\SkinCache\Fetchers;


use PublicUHC\SkinCache\Downloaders\Downloader;
use PublicUHC\SkinCache\Formatters\Formatter;
use Stash\Interfaces\PoolInterface;

class SkinFetcher {

    private $downloader;
    private $formatter;
    private $cachePool;

    public function __construct(Downloader $downloader, Formatter $formatter, PoolInterface $cachePool)
    {
        $this->downloader = $downloader;
        $this->formatter = $formatter;
        $this->cachePool = $cachePool;
    }

    function fetchSkin($username) {
        //TODO check cache and download if needed
        $this->formatter->format($this->downloader->downloadSkin($username));
    }

    function fetchHelm($username, $size) {
        //TODO check cache and download if needed
        $this->formatter->format($this->downloader->downloadHelm($username, $size));
    }

    function fetchHead($username, $size)
    {
        //TODO check cache and download if needed
        $this->formatter->format($this->downloader->downloadHead($username, $size));
    }
} 