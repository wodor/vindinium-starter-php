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
use WodorNet\Vindinium\Tile\Tavern;

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
     * @var \WodorNet\Vindinium\DistanceRank\PathCost
     */
    private $taverns;

    /**
     * @var State
     */
    private $state;

    /**
     *
     */
    public function __construct()
    {

    }

    /**
     * @param State $state
     */
    public function setState(State $state)
    {
        $this->board = $state->getBoard();
        $this->position = $state->getProtagonist()->getPosition();
        $this->state = $state;
        $this->goldMines = new PathCost();
        $this->taverns = new PathCost();

        foreach($this->djikstra($this->position) as $tile) {
            $this->poiLookup($tile);
        }

    }

    public function thereAreMinesToConquer()
    {
        return $this->goldMines->valid();
    }
    /**
     * @return Path
     */
    public function findClosestMine()
    {
        return $this->goldMines->top();
    }

    public function findClosestTavern()
    {
        return $this->taverns->top();
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
                // rozwaz dodanie kosztu jesli jest przeciwnik
                // warto tez dodac koszt bycia daleko od spawnpointa
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
     * Looks around a tile
     *
     * @param $tile
     * @return Path
     */
    protected function poiLookup($tile)
    {
        foreach ($this->board->surroundingTiles($tile->getPosition()) as $toi) {
            if ($toi instanceof Goldmine && $toi->getOwnerId() != $this->state->getProtagonist()->getId()) {
                $this->goldMines->insert($this->buildPathToAbstractTile($tile, $toi));
            }
            if ($toi instanceof Tavern) {
                $this->taverns->insert($this->buildPathToAbstractTile($tile, $toi));
            }
        };
    }

    /**
     * @param $tile
     * @param $potentialPoi
     * @return Path
     */
    protected function buildPathToAbstractTile($tile, $potentialPoi)
    {
        $poiTile = new PathTile($potentialPoi);
        $poiTile->setPreviousTile($tile);
        $poiTile->setCost($tile->getCost() + 1);

        return $this->buildPathByGraphTiles($poiTile);
    }

}
