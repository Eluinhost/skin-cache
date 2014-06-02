<?php

namespace PublicUHC\SkinCache;


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
        $cacheItem = $this->cachePool->getItem('skins/skin', $username);

        $data = $cacheItem->get();

        if($cacheItem->isMiss()) {
            $cacheItem->lock();

            $data = $this->downloader->downloadSkin($username);

            $cacheItem->set($data);
        }

        return $this->formatter->format($data);
    }

    function fetchHelm($username, $size) {
        $cacheItem = $this->cachePool->getItem('skins/helm', $username, $size);

        $data = $cacheItem->get();

        if($cacheItem->isMiss()) {
            $cacheItem->lock();

            $data = $this->downloader->downloadHelm($username, $size);

            $cacheItem->set($data);
        }
        return $this->formatter->format($data);
    }

    function fetchHead($username, $size)
    {
        $cacheItem = $this->cachePool->getItem('skins/skin/', $username);

        $data = $cacheItem->get();

        if($cacheItem->isMiss()) {
            $cacheItem->lock();

            $data = $this->downloader->downloadHead($username, $size);

            $cacheItem->set($data);
        }
        return $this->formatter->format($data);
    }
}