<?php

namespace PublicUHC\SkinCache;


use DateTime;
use PublicUHC\SkinCache\Downloaders\Downloader;
use PublicUHC\SkinCache\Exceptions\DownloadException;
use PublicUHC\SkinCache\Formatters\Formatter;
use PublicUHC\SkinCache\Painters\ErrorImagePainter;
use Stash\Interfaces\PoolInterface;
use Stash\Item;

class SkinFetcher {

    private $downloader;
    private $formatter;
    private $cachePool;
    private $painter;
    private $ttl;

    /**
     * Create a skin fetcher.
     * @param Downloader $downloader the downloader to use, fetches the skins
     * @param Formatter $formatter the formatter to use, formats the images for use
     * @param PoolInterface $cachePool the caching pool to use for caching skins/transparents
     * @param ErrorImagePainter $painter the painter to use for error images
     * @param int|DateTime $ttl the number of seconds to cache skins for or a future DateTime to expire on before refetching them
     */
    public function __construct(Downloader $downloader, Formatter $formatter, PoolInterface $cachePool, ErrorImagePainter $painter, $ttl)
    {
        $this->downloader = $downloader;
        $this->formatter = $formatter;
        $this->cachePool = $cachePool;
        $this->painter = $painter;
        $this->ttl = $ttl;
    }

    /**
     * Return an image from the painter with the given size
     * @param $sizeX int the x length
     * @param $sizeY int the y height
     * @return string the image as a string
     */
    function fetchTransparent($sizeX, $sizeY)
    {
        /** @var $cacheItem Item */
        $cacheItem = $this->cachePool->getItem('transparents', $sizeX, $sizeY);

        $data = $cacheItem->get();
        if($cacheItem->isMiss()) {
            $cacheItem->lock();

            $data = $this->painter->getImage($sizeX, $sizeY);
            //should cache until cleared
            $cacheItem->set($data);
        }

        return $data;
    }

    /**
     * Attempt to fetch a skin image
     * @param $username string the username to fetch for
     * @param bool $format if true formats the response using the formatter, if false returns the raw image
     * @param bool $error if true will throw a DownloadException on failed fetch, otherwise will return a transparent image
     * @return mixed either the raw image string or the formatted version based on $format
     * @throws Exceptions\DownloadException if $error is true and image fetching failed
     */
    function fetchSkin($username, $format = true, $error = false)
    {
        /** @var $cacheItem Item */
        $cacheItem = $this->cachePool->getItem('skins/skin', $username);

        $data = $cacheItem->get();

        if($cacheItem->isMiss()) {
            $cacheItem->lock();

            //attempt to fetch the data
            //if failed throw error or return a transparent image based on $error
            try {
                $data = $this->downloader->downloadSkin($username);
                $cacheItem->set($data, $this->ttl);
            } catch (DownloadException $ex) {
                if($error) { throw $ex; }
                $data = $this->fetchTransparent(64, 32);
            }
        }

        return $format ? $this->formatter->formatData($data) : $data;
    }

    /**
     * Attempt to fetch a helm image
     * @param $username string the username to fetch for
     * @param $size int the x and y dimensions to fetch
     * @param bool $format if true formats the response using the formatter, if false returns the raw image
     * @param bool $error if true will throw a DownloadException on failed fetch, otherwise will return a transparent image
     * @return mixed either the raw image string or the formatted version based on $format
     * @throws Exceptions\DownloadException if $error is true and image fetching failed
     */
    function fetchHelm($username, $size, $format = true, $error = false)
    {
        /** @var $cacheItem Item */
        $cacheItem = $this->cachePool->getItem('skins/helm', $username, $size);

        $data = $cacheItem->get();

        if($cacheItem->isMiss()) {
            $cacheItem->lock();

            //attempt to fetch the data
            //if failed throw error or return a transparent image based on $error
            try {
            $data = $this->downloader->downloadHelm($username, $size);
                $cacheItem->set($data, $this->ttl);
            } catch (DownloadException $ex) {
                if($error) { throw $ex; }
                $data = $this->fetchTransparent($size, $size);
            }
        }
        return $format ? $this->formatter->formatData($data) : $data;
    }

    /**
     * Attempt to fetch a skin image
     * @param $username string the username to fetch for
     * @param $size int the x and y dimensions to fetch
     * @param bool $format if true formats the response using the formatter, if false returns the raw image
     * @param bool $error if true will throw a DownloadException on failed fetch, otherwise will return a transparent image
     * @return mixed either the raw image string or the formatted version based on $format
     * @throws Exceptions\DownloadException if $error is true and image fetching failed
     */
    function fetchHead($username, $size, $format = true, $error = false)
    {
        /** @var $cacheItem Item */
        $cacheItem = $this->cachePool->getItem('skins/skin/', $username);

        $data = $cacheItem->get();

        if($cacheItem->isMiss()) {
            $cacheItem->lock();

            //attempt to fetch the data
            //if failed throw error or return a transparent image based on $error
            try {
                $data = $this->downloader->downloadHead($username, $size);
                $cacheItem->set($data, $this->ttl);
            } catch (DownloadException $ex) {
                if($error) { throw $ex; }
                $data = $this->fetchTransparent($size, $size);
            }
        }
        return $format ? $this->formatter->formatData($data) : $data;
    }
}