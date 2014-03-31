<?php

namespace xsist10\SafeBrowsing;

class Response
{
    private $raw;
    
    public function __construct($raw) {
        $this->raw = $raw;
    }
    
    public function isSecure() {
        return !$this->hasMalware() && !$this->hasPhishing();
    }

    public function hasMalware() {
        return strpos($this->raw, 'malware') !== false;
    }
    
    public function hasPhishing() {
        return strpos($this->raw, 'phishing') !== false;
    }
}
