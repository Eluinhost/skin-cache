<?php

use PublicUHC\SkinCache\Formatters\Formatter;
use PublicUHC\SkinCache\Formatters\GreyscaleFormatter;
use PublicUHC\SkinCache\Formatters\HttpResponseFormatter;
use PublicUHC\SkinCache\Formatters\RawImageFormatter;

class FormatterTest extends PHPUnit_Framework_TestCase {

    public function testThenChain() {
        /**
         * @var $chain1 Formatter
         * @var $chain2 Formatter
         * @var $chain3 Formatter
         */
        $chain1 = new RawImageFormatter();
        $chain2 = new GreyscaleFormatter();
        $chain3 = new HttpResponseFormatter();

        $formatter = $chain1->then($chain2)->then($chain3);

        $this->assertSame($chain1->next(), $chain2);
        $this->assertSame($chain2->next(), $chain3);
        $this->assertSame($chain3->next(), null);
        $this->assertSame($formatter, $chain1);
    }
}