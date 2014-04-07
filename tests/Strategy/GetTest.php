<?php

use xsist10\SafeBrowsing\Strategy\Get;
use xsist10\SafeBrowsing\Strategy\UnavailableException;

use \PHPUnit_Framework_TestCase;

class GetTest extends PHPUnit_Framework_TestCase
{
    public function testNoValidStrategyChain()
    {
        /*$this->setExpectedException('Exception', 'No available strategy.');

        $chain = new Chain();
        $chain->execute('http://www.google.com', []);*/
    }
}
