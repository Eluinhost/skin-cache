<?php

namespace PublicUHC\SkinCache;


use DateTime;
use GuzzleHttp\Client;
use PublicUHC\SkinCache\Downloaders\MinotarLikeDownloader;
use PublicUHC\SkinCache\Formatters\HttpResponseFormatter;
use PublicUHC\SkinCache\Painters\TransparentImagePainter;
use Stash\Driver\FileSystem;
use Stash\Pool;

class SimpleSkinFetcher extends SkinFetcher {

    /**
     * Create a skin fetcher with some basic defaults.
     * <p>
     * Created skin fetcher will fetch skins from $base_url with maximum timeout $timeout. It will format them as HttpFoundation Responses.
     * It will cache the images to $cacheDirectory and will show transparent images the same size as the request on a failed fetch.
     * </p>
     * <p>
     * Uses the following parameters on creation:
     * </p>
     * <ul>
     * <li>Downloader - MinotarLikeDownloader with a Guzzle Client set to base URL $base_url and with timeout $timeout</li>
     * <li>RepsonseFormatter - HttpResponseFormatter</li>
     * <li>PoolInterface - Stash\Pool with the FileSystem driver with it's cache directory set to $cacheDirectory</li>
     * <li>ErrorImagePainter - TransparentImagePainter
     * </ul>
     * @param $base_url string the base URL for the cached minotar site
     * @param $timeout int the timeout for fetching skins
     * @param $cacheDirectory string the path to cache the skins/error images in
     * @param int|DateTime $ttl the number of seconds to cache skins for or a future DateTime to expire on before refetching them
     */
    public function __construct($base_url, $timeout, $cacheDirectory, $ttl)
    {
        $downloader = new MinotarLikeDownloader(new Client(['base_url'=>$base_url]), $timeout);
        $formatter = new HttpResponseFormatter();
        $cachePool = new Pool(new FileSystem(['path'=>$cacheDirectory]));
        $errorPainter = new TransparentImagePainter();
        parent::__construct($downloader, $formatter, $cachePool, $errorPainter, $ttl);
    }
} 