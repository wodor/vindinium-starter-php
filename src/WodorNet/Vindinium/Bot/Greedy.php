<?php

namespace WodorNet\Vindinium\Bot;

use Monolog\Logger;
use WodorNet\Vindinium\Scout;
use WodorNet\Vindinium\State;

class Greedy
{
    private $logger;

    /**
     * @var \WodorNet\Vindinium\Scout
     */
    private $scout;

    /**
     * @var State
     */
    private $state;

    /**
     * @param Scout $scout
     */
    public function __construct(Scout $scout)
    {
        $this->scout = $scout;
        $this->logger = new Logger('main');
    }

    /**
     * @param State $state
     */
    public function setState(State $state)
    {
        $this->state = $state;
        $this->scout->setBoard($state->getBoard());
        $this->scout->setPosition($this->state->getProtagonist()->getPos());
    }

    /**
     * @return string
     */
    public function move()
    {
        $from = $this->state->getProtagonist()->getPos();

        $to = $this->scout->findClosestMine();

        $move = $from->moveStringTo($to);
        $this->logger->info($move, array('pid' => getmypid()));
        return $move;
    }
}
