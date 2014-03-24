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
        $this->path->rewind();
        $this->path->setIteratorMode(\SplQueue::IT_MODE_KEEP);
    }

    public function move()
    {
        $from = $this->state->getProtagonist()->getPos();

        $this->logger->debug($this->path);
        if (!$this->path->isEmpty()) {
            $this->path->rewind();
            $this->logger->debug("Key: " . $this->path->key());
            $to = $this->path->current();
            if ($to != $from) {
                $this->logger->debug('Not reached, being at: ' . $from . ' going to' . $to);
            } else {
                $this->logger->debug('We are already at destination ' . $to . ', moving to next');
                $this->path->dequeue();
                $this->path->rewind();
                if(!$this->path->isEmpty()) {
                    $to = $this->path->current();
                } else {
                    $to = $from;
                }
                $this->logger->debug($this->path);
            }
            $tile = $this->state->getBoard()->createTileInPosition($to);
            $this->logger->debug( 'to is ' . $tile)  ;
            if (!$this->state->getBoard()->createTileInPosition($to)->isPassable() && $to->isNeighbourOf($from)) {
                $this->logger->debug(sprintf('Position %s is a neighbour and is not passable', $to));
                $this->path->dequeue();
            }
        } else {
            $this->logger->debug("Path is empty, we don't go anywhere");
            $to = $from;
        }

        $move = $from->moveStringTo($to);

        $this->logger->info('Decided to go to: ' . $to . ' from '.$from . ' move: ' . $move ,  array('pid' => getmypid()));

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
}
