<?php

namespace PublicUHC\SkinCache\Downloaders;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use PublicUHC\SkinCache\Exceptions\DownloadException;
use Symfony\Component\HttpFoundation\Response;

class MinotarLikeDownloader extends Downloader {

    private $timeout;
    private $client;

    /**
     * @param Client $client the client to use, expects the base_url to be set to the minotar-like service URL
     * @param $timeout
     */
    public function __construct(Client $client, $timeout)
    {
        $this->client = $client;
        $this->timeout = $timeout;
    }

    function downloadSkin($username)
    {
        return $this->_downloadFromURL('/skin/'.$username);
    }

    function downloadHelm($username, $size)
    {
        return $this->_downloadFromURL('/helm/'.$username.'/'.$size.'.png');
    }

    function downloadHead($username, $size)
    {
        return $this->_downloadFromURL('/avatar/'.$username.'/'.$size.'.png');
    }

    /**
     * Get the data from the given subURL
     * @param String $path the subURL to fetch
     * @return resource the resource from the URL
     * @throws DownloadException if fetching URL failed or non 200 OK response
     */
    function _downloadFromURL($path)
    {
        try {
            $data = $this->client->get($path, ['timeout' => $this->timeout]);
            if ($data->getStatusCode() != Response::HTTP_OK) {
                throw new DownloadException();
            }
            return $data->getBody();
        } catch (RequestException $ex) {
            throw new DownloadException();
        }
    }
}