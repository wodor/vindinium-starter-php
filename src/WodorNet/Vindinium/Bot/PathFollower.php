<?php

namespace WodorNet\Vindinium\Bot;

use WodorNet\Vindinium\Path;
use WodorNet\Vindinium\Position;

class PathFollower extends AbstractBot
{
    private $path;

    public function __construct()
    {
        parent::__construct();
        $this->path = new Path();
    }

    /**
     * @param \WodorNet\Vindinium\Path $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    public function move()
    {
        $from = $this->state->getProtagonist()->getPos();
        $to = $this->followPath($from);

        $move = $from->moveStringTo($to);

        $tile = $this->state->getBoard()->createTileInPosition($to);
        $this->logger->info('Decided to go to: ' . $tile . ' from '. $from . ' move: ' . $move ,  array('pid' => getmypid()));

        return $move;
    }

    public function generateSouthPath()
    {
        $path = new Path();
        $path->enqueue(new Position(1, 1));
        $path->enqueue(new Position(3, 2));
        $path->enqueue(new Position(3, 0));
        $path->enqueue(new Position(4, 1));
        $path->enqueue(new Position(4, 0));
        $path->enqueue(new Position(5, 1));
        $path->enqueue(new Position(5, 0));
        $path->enqueue(new Position(7, 1));
        $path->enqueue(new Position(6, 2));
        $path->enqueue(new Position(6, 3)); //tav
        $path->enqueue(new Position(5, 4));

        return $path;
    }

    /**
     * @param $from
     * @return mixed
     */
    protected function followPath($from)
    {
        $this->logger->debug($this->path);

        if ($this->path->isEmpty()) {
            $this->logger->debug("Path is empty, we don't go anywhere");

            return $from;
        }

        $to = $this->path->bottom();

        if ($to == $from) {
            $this->logger->debug('We are already at destination ' . $to . ', moving to next step');
            $dq = $this->path->dequeue();
            $this->logger->debug('deququed' . $dq);

            return $this->followPath($from);
        }

        $this->logger->debug('Not reached, being at: ' . $from . ' going to' . $to);

        if (!$this->state->getBoard()->createTileInPosition($to)->isPassable() && $to->isNeighbourOf($from)) {
            $this->logger->debug(sprintf('Position %s is a neighbour and is not passable', $to));
            $this->path->dequeue();
        }

        return $to;
    }
}
