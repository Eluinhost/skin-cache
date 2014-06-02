<?php

namespace PublicUHC\SkinCache\Fetchers;


use PublicUHC\SkinCache\Downloaders\Downloader;
use PublicUHC\SkinCache\Formatters\Formatter;

abstract class Fetcher {

    private $downloader;
    private $formatter;

    public function __construct(Downloader $downloader, Formatter $formatter)
    {
        $this->downloader = $downloader;
        $this->formatter = $formatter;
    }

    abstract function fetchSkin($username);

    abstract function fetchHelm($username);

    abstract function fetchHead($username);
} 