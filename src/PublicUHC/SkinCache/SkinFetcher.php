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

    function fetchSkin($username, $format = true) {
        $cacheItem = $this->cachePool->getItem('skins/skin', $username);

        $data = $cacheItem->get();

        if($cacheItem->isMiss()) {
            $cacheItem->lock();

            $data = $this->downloader->downloadSkin($username);

            $cacheItem->set($data);
        }

        return $format ? $this->formatter->format($data) : $data;
    }

    function fetchHelm($username, $size, $format = true) {
        $cacheItem = $this->cachePool->getItem('skins/helm', $username, $size);

        $data = $cacheItem->get();

        if($cacheItem->isMiss()) {
            $cacheItem->lock();

            $data = $this->downloader->downloadHelm($username, $size);

            $cacheItem->set($data);
        }
        return $format ? $this->formatter->format($data) : $data;
    }

    function fetchHead($username, $size, $format = true)
    {
        $cacheItem = $this->cachePool->getItem('skins/skin/', $username);

        $data = $cacheItem->get();

        if($cacheItem->isMiss()) {
            $cacheItem->lock();

            $data = $this->downloader->downloadHead($username, $size);

            $cacheItem->set($data);
        }
        return $format ? $this->formatter->format($data) : $data;
    }
}