<?php

namespace WodorNet\Vindinium\Bot;

use Monolog\Logger;
use WodorNet\Vindinium\Scout;
use WodorNet\Vindinium\State;

class Greedy extends AbstractBot
{
    /**
     * @var \WodorNet\Vindinium\Scout
     */
    private $scout;

    /**
     * @param Scout $scout
     */
    public function __construct(Scout $scout)
    {
        $this->scout = $scout;
        parent::__construct();
    }

    /**
     * @param State $state
     */
    public function setState(State $state)
    {
        $this->state = $state;
        $this->scout->setBoard($state->getBoard());
        $this->scout->setPosition($this->state->getProtagonist()->getPosition());
    }

    /**
     * @return string
     */
    public function move()
    {
        $from = $this->state->getProtagonist()->getPosition();

        $to = $this->scout->findClosestMine();

        $move = $from->moveStringTo($to);
        $this->logger->info($move, array('pid' => getmypid()));
        return $move;
    }
}
