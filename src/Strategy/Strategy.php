<?php

namespace xsist10\SafeBrowsing\Strategy;

interface Strategy
{
    public function get($url, $param);
}