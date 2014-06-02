<?php

namespace PublicUHC\SkinCache\Downloaders;

use GuzzleHttp\Exception\RequestException;
use PHPUnit_Framework_TestCase;
use Stash\Driver\BlackHole;
use Stash\Pool;

class MinotarDownloaderTest extends PHPUnit_Framework_TestCase {

    /** @var $downloader MinotarLikeDownloader */
    private $downloader;
    private $client;
    private $response;

    public function setUp() {
        $this->client = $this->getMock('GuzzleHttp\Client');

        $this->response = $this->getMockBuilder('GuzzleHttp\Message\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $this->client->expects($this->any())
            ->method('get')
            ->will($this->returnValue($this->response));

        $this->downloader = new MinotarLikeDownloader(new Pool(new BlackHole()), $this->client, 30);
    }

    public function testFetchFromURL() {
        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $this->response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue('TEST BODY'));

        $data = $this->downloader->_downloadFromURL('this could be anything');

        $this->assertEquals('TEST BODY', $data);
    }

    public function testFetchFromURLFail() {
        $fakeRequest = $this->getMockBuilder('GuzzleHttp\Message\Request')->disableOriginalConstructor()->getMock();

        $this->client->expects($this->any())
            ->method('get')
            ->will($this->throwException(new RequestException('', $fakeRequest)));

        $this->setExpectedException('GuzzleHttp\Exception\RequestException');

        $this->downloader->_downloadFromURL('this could be anything');
    }

    public function testFetchNon200FromURL() {

        $this->response->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue(401));

        $data = $this->downloader->_downloadFromURL('this could be anything');

        $this->assertFalse($data);
    }
}
 