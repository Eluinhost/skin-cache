<?php

namespace PublicUHC\SkinCache\Downloaders;


use PublicUHC\SkinCache\Exceptions\MissingDependencyException;
use Stash\Interfaces\PoolInterface;
use Symfony\Component\HttpFoundation\Response;

class MinotarDownloader extends Downloader {

    private $timeout;

    public function __construct(PoolInterface $cache, $timeout) {
        parent::__construct($cache);
        $this->timeout = $timeout;
    }

    function downloadSkin($username, $size)
    {
        // TODO: Implement downloadSkin() method.
    }

    function downloadHelm($username, $size)
    {
        // TODO: Implement downloadHelm() method.
    }

    function downloadHead($username, $size)
    {
        // TODO: Implement downloadHead() method.
    }

    /**
     * Get the data from the given URL
     * @param String $path the URL to fetch
     * @return bool|resource the resource from the URL or false if failed to fetch
     */
    function _downloadFromURL($path) {
        $this->_checkForCurl();
        $ch = curl_init($path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $data = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpCode == Response::HTTP_OK ? $data : false;
    }

    function _checkForCurl() {
        if (!function_exists('curl_version')) {
            throw new MissingDependencyException('Curl needs to be installed to fetch from Minotar.');
        }
    }
}