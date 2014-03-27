<?php

namespace WodorNet\Vindinium\Scout;

use WodorNet\Vindinium\Board;
use WodorNet\Vindinium\DistanceRank\PathCost;
use WodorNet\Vindinium\DistanceRank\PathtileQueue;
use WodorNet\Vindinium\Path;
use WodorNet\Vindinium\Tile\Goldmine;
use WodorNet\Vindinium\Position;
use WodorNet\Vindinium\State;
use WodorNet\Vindinium\Tile\AbstractTile;
use WodorNet\Vindinium\Tile\Ground;
use WodorNet\Vindinium\Tile\PathTile;

class Grapher
{
    /**
     * @var Position
     */
    private $position;

    /**
     * @var Board
     */
    private $board;

    /**
     * @var \SplObjectStorage
     */
    private $discoveredTiles;

    private $goldMines;

    public function __construct()
    {
        $this->goldMines = new PathCost();
    }

    public function calculatePathsToPois(Position $position)
    {
        $this->goldMines = new PathCost();
        $this->discoveredTiles = new \SplObjectStorage();

        $tiles = $this->board->getTilesGraph($position);
        $tile = $this->board->fetchTileInPosition($position);

        $this->dfs($tile, new Path());
        $this->djikstra($tile);

//        echo $this->goldMines;
    }

    public function dfs(AbstractTile $tile, Path $path)
    {
        if (!$this->discoveredTiles->contains($tile)) {

            foreach( $this->board->surroundingTiles($tile->getPosition()) as $poi) {
                if($poi instanceof Goldmine) {
                    $cloned = clone $path;
                    $cloned->push($poi);
                    $this->goldMines->insert($cloned);
                }
            }

            foreach ($tile->getNeighbours() as $t) {
//                echo "\n visiting $t";
                if($this->discoveredTiles->contains($t)) {
//                    echo ", discov.";
                    continue;
                }
                $this->discoveredTiles->attach($tile);
                $path->push($t);
                $path = $this->dfs($t, $path);
                $path->pop();
            }
        }

        return $path;
    }

    public function setState(State $state)
    {
        $this->board = $state->getBoard();
        $this->position = $state->getProtagonist()->getPosition();
    }

    /**
     * @return Path
     */
    public function findClosestMine()
    {
        foreach($this->goldMines as $path) {
            try{
                /** @var Path $path */
                $tile = $path->top();
                if($tile->isFree()) {
                    return $path;
                }
            }
            catch (\RuntimeException $e) {
                throw new \Exception("\n $path  was empty") ;
            }
        };
    }

    public function pathFromTo($from, $to)
    {
        $Q = new PathtileQueue();

        $source = new PathTile($this->board->fetchTileInPosition($from));
        $source->setCost(0);

        foreach($this->board->getTilesGraph($from) as $u) {
            if($u->getPosition() != $source) {
                $Q->insertPathTile(new PathTile($u));
            }
        };
        $Q->insertPathTile($source);

        $tile = $this->djikstra($Q, $to);

        $p =  new Path();
        while($tile = $tile->getPreviousTile()) {
            $p -> unshift($tile);
        }
        echo $p;
        return $p;
    }

    /**
     * @param $Q
     */
    protected function djikstra($Q, Position $to)
    {
        foreach ($Q as $u) {
            foreach ($u->getNeighbours() as $v) {
                if (($u->getCost() + 1) < $v->getCost()) {
                    $v->setCost($u->getCost() + 1);
                    $v->setPreviousTile($u);
                    if($v->getPosition() == $to) {
                        return $v;
                    }
                    $Q->insertPathTile($v);
                }
            };
        }
    }

}
