<?php

namespace WodorNet\Vindinium\Scout;

use WodorNet\Vindinium\Board;
use WodorNet\Vindinium\DistanceRank\PathCost;
use WodorNet\Vindinium\Path;
use WodorNet\Vindinium\Tile\Goldmine;
use WodorNet\Vindinium\Position;
use WodorNet\Vindinium\State;
use WodorNet\Vindinium\Tile\AbstractTile;

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

    public function djikstra()
    {

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
}
