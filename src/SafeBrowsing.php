<?php

namespace xsist10\SafeBrowsing;

use xsist10\SafeBrowsing\Strategy\Strategy;

use \Exception;

class SafeBrowsing
{
    const API_LOOKUP = 'https://sb-ssl.google.com/safebrowsing/api/lookup';
    
    private $api_key;
    
    private $strategy;
    
    public function __construct($api_key, Strategy $strategy) {
        $this->api_key = $api_key;
        $this->strategy = $strategy;
    }
    
    function isUrlSafe($url) {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception('Invalid URL specified.');
        }
        
        $result = $this->strategy->execute(self::API_LOOKUP, [
            'client' => 'api',
            'key' => $this->api_key,
            'appver' => '1.0',
            'pver'   => '3.0',
            'url'    => $url
        ]);
        
        return new Response($result);
    }
}
