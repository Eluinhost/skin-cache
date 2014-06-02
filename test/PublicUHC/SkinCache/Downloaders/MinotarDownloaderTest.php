<?php

namespace PublicUHC\SkinCache\Downloaders;


use PHPUnit_Extension_FunctionMocker;
use PHPUnit_Framework_TestCase;
use Stash\Driver\BlackHole;
use Stash\Pool;

class MinotarDownloaderTest extends PHPUnit_Framework_TestCase {

    /** @var $downloader MinotarDownloader */
    private $downloader;

    public function setUp() {
        $this->downloader = new MinotarDownloader(new Pool(new BlackHole()));
    }

    protected function setCurlInstalled($installed) {
        $funcMocker = PHPUnit_Extension_FunctionMocker::start($this, 'PublicUHC\SkinCache\Downloaders')
            ->mockFunction('function_exists')
            ->getMock();

        $funcMocker->expects($this->any())
            ->method('function_exists')
            ->will($this->returnValue($installed));
    }

    public function testCheckForCurl() {
        $this->setCurlInstalled(true);
        $this->downloader->checkForCurl();
    }

    public function testCheckForCurlFail() {
        $this->setExpectedException('PublicUHC\SkinCache\Exceptions\MissingDependencyException');
        $this->setCurlInstalled(false);
        $this->downloader->checkForCurl();
    }
}
 