<?php

namespace xsist10\SafeBrowsing\Strategy;

interface Strategy
{
    public function execute($url, $param);
}