<?php

namespace xsist10\SafeBrowsing\Strategy;

use \Exception;

class Get implements Strategy
{
    public function execute($url, $param)
    {
        if (!ini_get('allow_url_fopen'))
        {
            throw new UnavailableException('allow_url_fopen disabled.');
        }
        
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => true,
                'cafile'      => __DIR__ . '/../../cacert.pem',
                'CN_match'    => 'sb-ssl.google.com'
            ]
        ]);
        
        $param = http_build_query($param);
        return file_get_contents($url . '?' . $param, FALSE, $context);
    }
}