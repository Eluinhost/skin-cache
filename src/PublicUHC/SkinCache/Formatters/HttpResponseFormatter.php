<?php
namespace PublicUHC\SkinCache\Formatters;

use Symfony\Component\HttpFoundation\Response;

class HttpResponseFormatter extends Formatter {

    function format($data)
    {
        return new Response($data, 200,  ['content-type' => 'image/png']);
    }
}