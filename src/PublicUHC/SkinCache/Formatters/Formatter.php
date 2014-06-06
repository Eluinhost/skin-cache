<?php
namespace PublicUHC\SkinCache\Formatters;

abstract class Formatter {

    /** @var Formatter */
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
     * @return Formatter|null the next chain or null
     *
     */
    public function next() {
        return $this->next;
    }

    /**
     * Add the formatter to the end of the chain
     * @param Formatter $formatter the formatter to the end
     * @return Formatter this
     */
    public function then(Formatter $formatter) {
        if($this->next == null) {
            $this->next = $formatter;
        } else {
            $this->next->then($formatter);
        }
        return $this;
    }

} 