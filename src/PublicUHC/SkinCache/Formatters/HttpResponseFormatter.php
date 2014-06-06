<?php
namespace PublicUHC\SkinCache\Formatters;

use Symfony\Component\HttpFoundation\Response;

class HttpResponseFormatter extends Formatter {

    /**
     * Format the image data.
     * <b>THIS CANNOT BE PASSED TO ANOTHER FORMATTER. The response is a Symfony Response of the image and not an image itself</b>
     * @param $data string the image that requires formatting
     * @return Response the image as a Symfony Response
     */
    function format($data)
    {
        return new Response($data, 200,  ['content-type' => 'image/png']);
    }
}