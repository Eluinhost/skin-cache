<?php

namespace PublicUHC\SkinCache;


use PublicUHC\SkinCache\Downloaders\Downloader;
use PublicUHC\SkinCache\Exceptions\DownloadException;
use PublicUHC\SkinCache\Formatters\Formatter;
use PublicUHC\SkinCache\Painters\TransparentImagePainter;
use Stash\Interfaces\PoolInterface;

class SkinFetcher {

    private $downloader;
    private $formatter;
    private $cachePool;
    private $painter;

    public function __construct(Downloader $downloader, Formatter $formatter, PoolInterface $cachePool, TransparentImagePainter $painter)
    {
        $this->downloader = $downloader;
        $this->formatter = $formatter;
        $this->cachePool = $cachePool;
        $this->painter = $painter;
    }

    function fetchTransparent($sizeX, $sizeY) {
        $cacheItem = $this->cachePool->getItem('transparents', $sizeX, $sizeY);

        $data = $cacheItem->get();
        if($cacheItem->isMiss()) {
            $cacheItem->lock();

            $data = $this->painter->getImage($sizeX, $sizeY);
            $cacheItem->set($data);
        }

        return $data;
    }

    function fetchSkin($username, $format = true, $error = false) {
        $cacheItem = $this->cachePool->getItem('skins/skin', $username);

        $data = $cacheItem->get();

        if($cacheItem->isMiss()) {
            $cacheItem->lock();

            //attempt to fetch the data
            //if failed throw error or return a transparent image based on $error
            try {
                $data = $this->downloader->downloadSkin($username);
                $cacheItem->set($data);
            } catch (DownloadException $ex) {
                if($error) { throw $ex; }
                $data = $this->fetchTransparent(64, 32);
            }
        }

        return $format ? $this->formatter->format($data) : $data;
    }

    function fetchHelm($username, $size, $format = true, $error = false) {
        $cacheItem = $this->cachePool->getItem('skins/helm', $username, $size);

        $data = $cacheItem->get();

        if($cacheItem->isMiss()) {
            $cacheItem->lock();

            //attempt to fetch the data
            //if failed throw error or return a transparent image based on $error
            try {
            $data = $this->downloader->downloadHelm($username, $size);
                $cacheItem->set($data);
            } catch (DownloadException $ex) {
                if($error) { throw $ex; }
                $data = $this->fetchTransparent($size, $size);
            }
        }
        return $format ? $this->formatter->format($data) : $data;
    }

    function fetchHead($username, $size, $format = true, $error = false)
    {
        $cacheItem = $this->cachePool->getItem('skins/skin/', $username);

        $data = $cacheItem->get();

        if($cacheItem->isMiss()) {
            $cacheItem->lock();

            //attempt to fetch the data
            //if failed throw error or return a transparent image based on $error
            try {
                $data = $this->downloader->downloadHead($username, $size);
                $cacheItem->set($data);
            } catch (DownloadException $ex) {
                if($error) { throw $ex; }
                $data = $this->fetchTransparent($size, $size);
            }
        }
        return $format ? $this->formatter->format($data) : $data;
    }
}