<?php

namespace WodorNet\Vindinium\Scout;

use WodorNet\Vindinium\Board;
use WodorNet\Vindinium\DistanceRank\PathCost;
use WodorNet\Vindinium\DistanceRank\PathtileQueue;
use WodorNet\Vindinium\Path;
use WodorNet\Vindinium\Position;
use WodorNet\Vindinium\State;
use WodorNet\Vindinium\Tile\Goldmine;
use WodorNet\Vindinium\Tile\PathTile;
use WodorNet\Vindinium\Tile\PathTileFactory;

/**
 * Class Grapher
 *
 * @package WodorNet\Vindinium\Scout
 */
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

    /**
     * @var \WodorNet\Vindinium\DistanceRank\PathCost
     */
    private $goldMines;

    /**
     *
     */
    public function __construct()
    {
        $this->goldMines = new PathCost();
    }

    /**
     * @param State $state
     */
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
        echo "Finding closest mine from " . $this->position;


        foreach($this->djikstra($this->position) as $tile) {
            $pathToMine = $this->poiLookup($tile);
            if($pathToMine instanceof Path) {
                return $pathToMine;
            }

        }
    }

    /**
     * @param $from
     * @param $to
     * @return Path
     */
    public function pathFromTo($from, $to)
    {
        foreach ($this->djikstra($from) as $tile) {
            if ($tile->getPosition() == $to) {
                break;
            }
        };

        $p = $this->buildPathByGraphTiles($tile);

        return $p;
    }


    /**
     * @param Position $from
     * @return \Generator
     */
    protected function djikstra(Position $from)
    {
        $Q = new PathtileQueue();
        $pathTileFactory = new PathTileFactory();
        $source = new PathTile($this->board->fetchTileInPosition($from));
        $source->setCost(0);
        foreach ($this->board->recalculateGraphFromPosition($from) as $u) {
            if ($u->getPosition() != $source) {
                $Q->insertPathTile(new PathTile($u));
            }
        };
        $Q->insertPathTile($source);
        yield $source;
        foreach ($Q as $u) {
            foreach ($pathTileFactory->neighbours($u) as $v) {
                if (($u->getCost() + 1) < $v->getCost()) {
                    $v->setCost($u->getCost() + 1);
                    $v->setPreviousTile($u);
                    $Q->insertPathTile($v);
                    yield $v;
                }
            };
        }
    }

    /**
     * @param $tile
     * @return Path
     */
    protected function buildPathByGraphTiles(PathTile $tile)
    {
        $p = new Path();
        do  {
            $p->unshift($tile);
        } while ($tile = $tile->getPreviousTile());

        $p->dequeue();
        return $p;
    }

    /**
     * @param $tile
     * @return Path
     */
    protected function poiLookup($tile)
    {
        foreach ($this->board->surroundingTiles($tile->getPosition()) as $potentianPoi) {
            if ($potentianPoi instanceof Goldmine && $potentianPoi->isFree()) {

                $poiTile = new PathTile($potentianPoi);
                $poiTile->setPreviousTile($tile);
                $poiTile->setCost($tile->getCost() + 1);

                return $this->buildPathByGraphTiles($poiTile);
            }
        };
    }

}
