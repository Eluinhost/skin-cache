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

    public function downloadSkin($username)
    {
        return $this->downloadFromURL('/skin/'.$username);
    }

    public function downloadHelm($username, $size)
    {
        return $this->downloadFromURL('/helm/'.$username.'/'.$size.'.png');
    }

    public function downloadHead($username, $size)
    {
        return $this->downloadFromURL('/avatar/'.$username.'/'.$size.'.png');
    }

    /**
     * Get the data from the given subURL
     * @param String $path the subURL to fetch
     * @return string the resource from the URL
     * @throws DownloadException if fetching URL failed or non 200 OK response
     */
    function downloadFromURL($path)
    {
        try {
            $data = $this->client->get($path, ['timeout' => $this->timeout]);
            if ($data->getStatusCode() != Response::HTTP_OK) {
                throw new DownloadException();
            }
            $body = $data->getBody();
            if(null == $body) {
                throw new DownloadException();
            }
            return $body->__toString();
        } catch (RequestException $ex) {
            throw new DownloadException();
        }
    }
}