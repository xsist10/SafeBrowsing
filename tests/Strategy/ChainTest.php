<?php

use xsist10\SafeBrowsing\Strategy\Chain;
use xsist10\SafeBrowsing\Strategy\Get;
use xsist10\SafeBrowsing\Strategy\Post;
use xsist10\SafeBrowsing\Strategy\UnavailableException;

use \PHPUnit_Framework_TestCase;

class ChainTest extends PHPUnit_Framework_TestCase
{
    public function testNoValidStrategyChain()
    {
        $this->setExpectedException('Exception', 'No available strategy.');

        $chain = new Chain();
        $chain->execute('http://www.google.com', []);
    }

    public function testAllStrategiesFailed()
    {
        $this->setExpectedException('Exception', 'All available strategies failed.');

        $get = $this->getMockBuilder('xsist10\SafeBrowsing\Strategy\Get', ['execute'])
            ->getMock();

        $get->expects($this->once())
            ->method('execute')
            ->willThrowException(new UnavailableException('allow_url_fopen disabled.'));

        $chain = new Chain();
        $chain->append($get);
        $chain->execute('http://www.google.com', []);
    }

    public function testChainWithFirstStrategySucceeding()
    {
        $get = $this->getMockBuilder('xsist10\SafeBrowsing\Strategy\Get', ['execute'])
            ->getMock();

        $get->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(''));

        $post = $this->getMockBuilder('xsist10\SafeBrowsing\Strategy\Post', ['execute'])
            ->getMock();

        $post->expects($this->never())
            ->method('execute');

        $chain = new Chain();
        $chain->append($get);
        $chain->append($post);
        $chain->execute('http://www.google.com', []);
    }

    public function testChainWithSecondStrategySucceeding()
    {
        $get = $this->getMockBuilder('xsist10\SafeBrowsing\Strategy\Get', ['execute'])
            ->getMock();

        $get->expects($this->once())
            ->method('execute')
            ->willThrowException(new UnavailableException('allow_url_fopen disabled.'));

        $post = $this->getMockBuilder('xsist10\SafeBrowsing\Strategy\Post', ['execute'])
            ->getMock();

        $post->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(''));

        $chain = new Chain();
        $chain->append($get);
        $chain->append($post);
        $chain->execute('http://www.google.com', []);
    }
}
