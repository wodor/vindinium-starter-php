<?php

namespace WodorNet\Vindinium\Bot;
use WodorNet\Vindinium\Scout\Grapher;
use WodorNet\Vindinium\State;

/**
 * Class GreedyGrapherUser
 *
 * Uses grapher to get path to nearest mine
 * and goes there
 * @package WodorNet\Vindinium\Bot
 */
class GreedyGrapherUser extends AbstractBot
{

    /**
     * @var Grapher
     */
    private $scout;

    public function __construct($scout)
    {
        $this->scout = $scout;
    }

    public function setState(State $state)
    {
        parent::setState($state);
        $this->scout->setState($state);
    }

    public function move()
    {
       $this->scout->pathsToPois();




       return 'South';
    }
}