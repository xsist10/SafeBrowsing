<?php

use xsist10\SafeBrowsing\Response;

use \PHPUnit_Framework_TestCase;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    public function testSecure()
    {
        $response = new Response('');

        $this->assertTrue($response->isSecure());
        $this->assertFalse($response->hasMalware());
        $this->assertFalse($response->hasPhishing());
    }

    public function testMalware()
    {
        $response = new Response('malware');

        $this->assertFalse($response->isSecure());
        $this->assertTrue($response->hasMalware());
        $this->assertFalse($response->hasPhishing());
    }

    public function testPhishing()
    {
        $response = new Response('phishing');

        $this->assertFalse($response->isSecure());
        $this->assertFalse($response->hasMalware());
        $this->assertTrue($response->hasPhishing());
    }

    public function testMalwarePhishing()
    {
        $response = new Response('malware phishing');

        $this->assertFalse($response->isSecure());
        $this->assertTrue($response->hasMalware());
        $this->assertTrue($response->hasPhishing());
    }
}
