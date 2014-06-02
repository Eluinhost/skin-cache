<?php

namespace PublicUHC\SkinCache\Fetchers;


use PublicUHC\MinotarCache\Downloaders\Downloader;
use PublicUHC\MinotarCache\Formatters\Formatter;

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