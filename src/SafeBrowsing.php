<?php

namespace xsist10\SafeBrowsing;

use xsist10\SafeBrowsing\Strategy\Chain;

use \Exception;

class SafeBrowsing
{
    const API_LOOKUP = 'https://sb-ssl.google.com/safebrowsing/api/lookup';
    
    private $api_key;
    
    private $chain;
    
    public function __construct($api_key, Chain $chain) {
        $this->api_key = $api_key;
        $this->chain = $chain;
    }
    
    function isUrlSafe($url) {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception('Invalid URL specified.');
        }
        
        $result = $this->chain->handle(self::API_LOOKUP, [
            'client' => 'api',
            'apikey' => $this->api_key,
            'appver' => '1.0',
            'pver'   => '3.0',
            'url'    => $url
        ]);
        
        return new Response($result);
    }
}
