<?php

namespace PublicUHC\SkinCache;


use GuzzleHttp\Client;
use PublicUHC\SkinCache\Downloaders\MinotarLikeDownloader;
use PublicUHC\SkinCache\Formatters\HttpResponseFormatter;
use PublicUHC\SkinCache\Painters\TransparentImagePainter;
use Stash\Driver\FileSystem;
use Stash\Pool;

class SimpleSkinFetcher extends SkinFetcher {

    /**
     * Create a skin fetcher with some basic defaults.
     * @param $base_url string the base URL for the cached minotar site
     * @param $timeout int the timeout for fetching skins
     * @param $cacheDirectory string the path to cache the skins/error images in
     */
    public function __construct($base_url, $timeout, $cacheDirectory)
    {
        $downloader = new MinotarLikeDownloader(new Client(['base_url'=>$base_url]), $timeout);
        $formatter = new HttpResponseFormatter();
        $cachePool = new Pool(new FileSystem(['path'=>$cacheDirectory]));
        $errorPainter = new TransparentImagePainter();
        parent::__construct($downloader, $formatter, $cachePool, $errorPainter);
    }
} 