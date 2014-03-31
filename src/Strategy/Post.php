<?php

namespace xsist10\SafeBrowsing\Strategy;

use \Exception;
use \RuntimeException;

class Post implements Strategy
{
    public function get($url, $param)
    {
        if (!function_exists('curl_init'))
        {
            throw new UnavailableException('cURL not installed.');
        }
      
        // Initialize cURL
        $curl = curl_init();

        // If cURL is still not initialized, then there is a problem
        if (!$curl) {
            throw new RuntimeException('Unable to create handle for cURL.');
        }

        $url_to_scan = "1\n" . $param['url'];
        unset($param['url']);
        $param = http_build_query($param);

        // Configure our curl call
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_URL, $url . '?' . $param);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $url_to_scan);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_CAINFO, __DIR__ . '/../../cacert.pem');

        $result = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Check our result for unexpected errors
        if ($code == 401) {
            throw new RuntimeException('Invalid API key specified.');
        }

        if ($code == 400) {
            throw new RuntimeException('Bad request. Check the URL you specified for errors.');
        }

        if ($code == 503) {
            throw new RuntimeException('Service unavailable. It is possible that your client has been throttled.');
        }

        if ($code != 200 && $code != 204) {
            throw new RuntimeException('Remote server returned an unexpected response: ' . $code);
        }

        return $result;
    }
}