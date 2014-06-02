<?php

namespace PublicUHC\SkinCache\Downloaders;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Stash\Interfaces\PoolInterface;
use Symfony\Component\HttpFoundation\Response;

class MinotarLikeDownloader extends Downloader {

    private $timeout;
    private $client;

    /**
     * @param PoolInterface $cache the caching pool to use
     * @param Client $client the client to use, expects the base_url to be set to the minotar-like service URL
     * @param $timeout
     */
    public function __construct(PoolInterface $cache, Client $client, $timeout) {
        parent::__construct($cache);
        $this->client = $client;
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
     * Get the data from the given subURL
     * @param String $path the subURL to fetch
     * @return bool|resource the resource from the URL or false if not a 200 OK response
     * @throws RequestException if fetching URL failed
     */
    function _downloadFromURL($path) {
        $data = $this->client->get($path, ['timeout' => $this->timeout]);
        if ($data->getStatusCode() != Response::HTTP_OK) {
            return false;
        }
        return $data->getBody();
    }
}