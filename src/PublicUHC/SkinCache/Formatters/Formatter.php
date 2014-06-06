<?php
namespace PublicUHC\SkinCache\Formatters;

abstract class Formatter {

    private $next;

    /**
     * Format the image data
     * @param $data string the image that requires formatting
     * @return mixed the formatted data
     */
    public abstract function format($data);

    public function formatData($data) {
        $data = $this->format($data);
        if($this->next != null) {
            $data = $this->formatData($data);
        }
        return $data;
    }

    /**
     * Add the formatter to the chain after this one
     * @param Formatter $formatter the formatter to add after
     * @return Formatter the formatter passed in
     */
    public function then(Formatter $formatter) {
        $this->next = $formatter;
        return $formatter;
    }

} 