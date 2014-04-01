Google SafeBrowsing Client
==========================

Demo code for PHPSA14 (http://phpsouthafrica.com/) conference

[![Build Status](https://travis-ci.org/xsist10/SafeBrowsing.svg?branch=master)](https://travis-ci.org/xsist10/SafeBrowsing)
[![Latest Stable Version](https://poser.pugx.org/xsist10/safebrowser/v/stable.png)](https://packagist.org/packages/xsist10/safebrowser)
[![Total Downloads](https://poser.pugx.org/xsist10/safebrowser/downloads.png)](https://packagist.org/packages/xsist10/safebrowser)
[![License](https://poser.pugx.org/xsist10/safebrowser/license.png)](https://packagist.org/packages/xsist10/safebrowser)


Get an API key
--------------

* [Signup Page](https://developers.google.com/safe-browsing/key_signup)
* [Development Guide](https://developers.google.com/safe-browsing/)


Installing
----------

This library is available via Composer:

    {
        "require": {
            "xsist10/safebrowser": "v1.0.0"
        }
    }


Using
-----

```php
<?php
require 'vendor/autoload.php';

use xsist10\SafeBrowsing\SafeBrowsing;
use xsist10\SafeBrowsing\Strategy\Chain;
use xsist10\SafeBrowsing\Strategy\Post;
use xsist10\SafeBrowsing\Strategy\Get;

$chain = new Chain();
$chain->append(new Post());
$chain->append(new Get());

$safeBrowsing = new SafeBrowsing("[API KEY]", $chain);
$response = $safeBrowsing->isUrlSafe('http://ianfette.org/');
if (!$response->isSecure()) {
    // Oh no! Panic!

    if ($response->hasMalware()) {
        // Malware detected
    }

    if ($response->hasPhishing()) {
        // Phising detected
    }
}
```
