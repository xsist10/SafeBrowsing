<?php

namespace xsist10\SafeBrowsing\Strategy;

use \Exception;

class Chain implements Strategy
{
    private $chain;
    
    public function append(Strategy $strategy) {
        $this->chain[] = $strategy;
    }
    
    public function execute($url, $param) {
        if (empty($this->chain)) {
            throw new Exception('No available strategy.');
        }

        foreach ($this->chain as $strategy) {
            try {
                return $strategy->execute($url, $param);
            } catch (UnavailableException $exception) {
                // We can log this if we want
                // We can ignore StrategyUnavailableException
                // exceptions and try the next item in the chain
            }
        }
        
        throw new Exception('All available strategies failed.');
    }
}