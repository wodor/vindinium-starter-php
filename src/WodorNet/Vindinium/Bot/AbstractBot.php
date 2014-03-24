<?php

namespace WodorNet\Vindinium\Bot;

use Monolog\Logger;
use WodorNet\Vindinium\State;

abstract class AbstractBot
{
    /**
     * @var State
     */
    protected $state;

    protected $logger;

    abstract public function move();

    public function __construct()
    {
        $this->logger = new Logger('main');
    }

    /**
     * @param State $state
     */
    public function setState(State $state)
    {
        $this->state = $state;
    }
} 