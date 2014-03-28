<?php

namespace WodorNet\Vindinium\Bot;
use WodorNet\Vindinium\Path;
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
     * @var Path
     */
    private $path;

    /**
     * @var Grapher
     */
    private $scout;

    public function __construct($scout)
    {
        $this->scout = $scout;
        parent::__construct();
    }

    public function setState(State $state)
    {
        parent::setState($state);
        $this->scout->setState($state);
    }


    public function move()
    {
        $from = $this->state->getProtagonist()->getPosition();

        // w zaleznosci od tego ile masz kopalni i czy wygrywasz powinienes zwiekszac bezpieczenstwo

        if(!$this->scout->thereAreMinesToConquer() || $this->state->getProtagonist()->getLife() < 60) {
           $this->path = $this->scout->findClosestTavern();
        }
        else {
            $this->path = $this->scout->findClosestMine();
        }

        $to = $this->followPath($from);

        $move = $from->moveStringTo($to);

        $tile = $this->state->getBoard()->fetchTileInPosition($to);
        $this->logger->info('Decided to go to: ' . $tile . ' from '. $from . ' move: ' . $move ,  array('pid' => getmypid()));


        return $move;
    }

    /**
     *
     * This method is overshoot as path is regenreated every step (for now)
     * @param $from
     * @return mixed
     */
    protected function followPath($from)
    {
        $this->logger->debug("Following: " . $this->path);

        if (!$this->path instanceof Path OR $this->path->isEmpty()) {
            $this->logger->debug("Path is empty, we don't go anywhere");

            return $from;
        }

        $to = $this->path->bottom()->getPosition();

        $this->logger->debug('Dest. Not reached, being at: ' . $from . ' still heading to' . $to);

        if ($to->isNeighbourOf($from)) {
            $this->logger->debug(sprintf('Position %s is a neighbour, we\'ll get there next step', $to));
            $this->path->dequeue();
        }
        else {
           $this->logger->debug($from . ' is not a neighbour of' . $to);
        }

        return $to;
    }
}