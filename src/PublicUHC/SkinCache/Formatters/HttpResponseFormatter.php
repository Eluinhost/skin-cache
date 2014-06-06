<?php
namespace PublicUHC\SkinCache\Formatters;

use Symfony\Component\HttpFoundation\Response;

class HttpResponseFormatter implements Formatter {

    /**
     * Format the image data
     * @param $data string the image that requires formatting
     * @return Response the image as a Symfony Response
     */
    function format($data)
    {
        return new Response($data, 200,  ['content-type' => 'image/png']);
    }
}