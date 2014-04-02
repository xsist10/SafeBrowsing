<?php
/**
 * The Shone Security Scanner is used to help a developer determine if the versions of the
 * dependencies he is using are vulnerable to known exploits.
 *
 * @category Shone
 * @package  Scanner
 * @author   Thomas Shone <xsist10@gmail.com>
 */

use xsist10\SafeBrowsing\SafeBrowsing;
use xsist10\SafeBrowsing\Strategy\Chain;

use \PHPUnit_Framework_TestCase;

class SafeBrowsingTest extends PHPUnit_Framework_TestCase
{
    public function testInvalidUrl()
    {
        $chain = new Chain();
        $safeBrowsing = new SafeBrowsing('', $chain);

        $this->setExpectedException('Exception', 'Invalid URL specified.');
        $safeBrowsing->isUrlSafe('invalid-url');
    }

    public function testSecure()
    {
        $mock = $this->getMockBuilder('xsist10\SafeBrowsing\Strategy\Chain', ['execute'])
            ->getMock();

        $mock->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(''));

        $safeBrowsing = new SafeBrowsing('', $mock);
        $response = $safeBrowsing->isUrlSafe('http://www.google.com');
        $this->assertTrue($response->isSecure());
        $this->assertFalse($response->hasMalware());
        $this->assertFalse($response->hasPhishing());
    }

    public function testMalware()
    {
        $mock = $this->getMockBuilder('xsist10\SafeBrowsing\Strategy\Chain', ['execute'])
            ->getMock();

        $mock->expects($this->once())
            ->method('execute')
            ->will($this->returnValue('malware'));

        $safeBrowsing = new SafeBrowsing('', $mock);
        $response = $safeBrowsing->isUrlSafe('http://www.google.com');
        $this->assertFalse($response->isSecure());
        $this->assertTrue($response->hasMalware());
        $this->assertFalse($response->hasPhishing());
    }

    public function testPhishing()
    {
        $mock = $this->getMockBuilder('xsist10\SafeBrowsing\Strategy\Chain', ['execute'])
            ->getMock();

        $mock->expects($this->once())
            ->method('execute')
            ->will($this->returnValue('phishing'));

        $safeBrowsing = new SafeBrowsing('', $mock);
        $response = $safeBrowsing->isUrlSafe('http://www.google.com');
        $this->assertFalse($response->isSecure());
        $this->assertFalse($response->hasMalware());
        $this->assertTrue($response->hasPhishing());
    }

    public function testMalwareAndPhishing()
    {
        $mock = $this->getMockBuilder('xsist10\SafeBrowsing\Strategy\Chain', ['execute'])
            ->getMock();

        $mock->expects($this->once())
            ->method('execute')
            ->will($this->returnValue('phishing malware'));

        $safeBrowsing = new SafeBrowsing('', $mock);
        $response = $safeBrowsing->isUrlSafe('http://www.google.com');
        $this->assertFalse($response->isSecure());
        $this->assertTrue($response->hasMalware());
        $this->assertTrue($response->hasPhishing());
    }
}
