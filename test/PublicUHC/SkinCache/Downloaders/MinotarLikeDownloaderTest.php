<?php

namespace PublicUHC\SkinCache\Downloaders;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use PHPUnit_Framework_TestCase;
use Stash\Driver\BlackHole;
use Stash\Pool;

class MinotarLikeDownloaderTest extends PHPUnit_Framework_TestCase {

    /** @var $downloader MinotarLikeDownloader */
    private $downloader;
    private $client;
    private $response;

    public function setUp()
    {
        $this->client = $this->getMock('GuzzleHttp\Client');

        $this->response = $this->getMockBuilder('GuzzleHttp\Message\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $this->client->expects($this->any())
            ->method('get')
            ->will($this->returnValue($this->response));

        $this->downloader = new MinotarLikeDownloader($this->client, 30);
    }

    public function testFetchFromURL()
    {
        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $this->response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue('TEST BODY'));

        $data = $this->downloader->_downloadFromURL('this could be anything');

        $this->assertEquals('TEST BODY', $data);
    }

    public function testFetchFromURLFail()
    {
        $fakeRequest = $this->getMockBuilder('GuzzleHttp\Message\Request')->disableOriginalConstructor()->getMock();

        $this->client->expects($this->any())
            ->method('get')
            ->will($this->throwException(new RequestException('', $fakeRequest)));

        $this->setExpectedException('PublicUHC\SkinCache\Exceptions\DownloadException');

        $this->downloader->_downloadFromURL('this could be anything');
    }

    public function testFetchNon200FromURL()
    {
        $this->response->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue(401));

        $this->setExpectedException('PublicUHC\SkinCache\Exceptions\DownloadException');

        $this->downloader->_downloadFromURL('this could be anything');
    }

    public function testGrabSkinFromMinotar()
    {
        $client = new Client(['base_url' => 'https://minotar.net/']);
        $downloader = new MinotarLikeDownloader($client, 30);

        $downloader->downloadSkin('ghowden');
    }

    public function testGrabHelmFromMinotar()
    {
        $client = new Client(['base_url' => 'https://minotar.net/']);
        $downloader = new MinotarLikeDownloader($client, 30);

        $downloader->downloadHelm('ghowden', 16);
    }

    public function testGrabHeadFromMinotar()
    {
        $client = new Client(['base_url' => 'https://minotar.net/']);
        $downloader = new MinotarLikeDownloader($client, 30);

        $downloader->downloadHead('ghowden', 16);
    }
}
 