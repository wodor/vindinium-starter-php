<?php

namespace WodorNet\Vindinium;

use WodorNet\Vindinium\Tile\AbstractTile;

class Board
{
    private $size;
    private $tilesString;
    private $tiles; // graph
    private $tilesArray; // identityMap of tiles

    public function __construct()
    {
        $this->tiles = new \SplObjectStorage();
    }

    public function setState($tilesString)
    {
        $this->size = (int) sqrt(strlen($tilesString) / 2);
        $this->tilesString = $tilesString;
        $this->tilesArray = array();
        $this->tiles = new \SplObjectStorage();
        $this->buildTileGraph($this->getFirstPassableTile());
    }

    private function getFirstPassableTile()
    {
        $i = 0;
        while (true) {
            $startPos = $this->getPositionByStringIndex($i);
            $tile = $this->fetchTileInPosition($startPos);
            if ($tile->isPassable()) {
                return $tile;
            }
            $i = $i + 2;
        }
    }

    /**
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getTilesString()
    {
        return $this->tilesString;
    }

    /**
     * @param  Position              $startPos
     * @return AbstractTile
     * @throws \OutOfBoundsException
     */
    public function fetchTileInPosition(Position $startPos)
    {
        if (isset($this->tilesArray[(string) $startPos])) {
            return $this->tilesArray[(string) $startPos];
        }
        $pos = $this->tilesPositionIndex($startPos);

        if (!$this->positionIsOnBoard($startPos)) {
            throw new \OutOfBoundsException($startPos . " is out of bounds");
        }

        $symbol = substr($this->tilesString, $pos, 2);

        $this->tilesArray[(string) $startPos] = $this->createTile($startPos, $symbol);

        return $this->tilesArray[(string) $startPos];
    }

    /**
     * Factory Method
     */
    private function createTile(Position $position, $symbol)
    {
        switch ($symbol{0}) {
            case ' ':
                $class = 'Ground';
                break;
            case '#':
                $class = 'Wood';
                break;
            case '[':
                $class = 'Tavern';
                break;
            case '$':
                $class = 'Goldmine';
                break;
            case '@':
                $class = 'Hero';
                break;
            default:
                throw new \InvalidArgumentException(' "' . $symbol . '" ' . ' unrecognized tile:' . $this->tilesString);
        }

        $class = "\\WodorNet\\Vindinium\\Tile\\".$class;

       return new $class($position, $this, $symbol);
    }

    /**
     * @param  Position $startPos
     * @return mixed
     */
    public function positionIsOnBoard(Position $startPos)
    {
        if (($startPos->getY() > $this->size-1 || $startPos->getX() > $this->size - 1)) {
            return false;
        };
        if ($startPos->getX()<0 || $startPos->getY()<0) {
            return false;
        }

        return true;
    }

    /**
     * @param  Position $startPos
     * @return mixed
     */
    private function tilesPositionIndex(Position $startPos)
    {
        $pos = ($startPos->getX() * $this->size + $startPos->getY()) * 2;

        return $pos;
    }

    private function surroundingPassableTiles(Position $position)
    {
        foreach ($this->surroundingTiles($position) as $tile) {
            if ($tile->isPassable()) {
                yield $tile;
            }
            continue;
        }
    }

    private function surroundingTiles(Position $position)
    {
        foreach ($position->surroundings() as $neighbour) {
            if (!$this->positionIsOnBoard($neighbour)) {
                continue;
            }
            yield $this->fetchTileInPosition($neighbour);
        }
    }

    private function buildTileGraph(AbstractTile $tile)
    {
        if (!$this->tiles->contains($tile)) {
            $this->tiles->attach($tile);
            foreach ($this->surroundingPassableTiles($tile->getPosition()) as $discoveredTile) {
                $tile->addNeighbour($discoveredTile);
                $discoveredTile->addNeighbour($tile);
                $this->buildTileGraph($discoveredTile);
            }
        }
    }

    /**
     * startingPosition sense is to have correct starting point if movable things are able to
     * cut the graph and we re-calculate graph every move
     * this a bit contradicts what board should be (static once-calculated source of information), but ok for now
     *
     * @param  Position          $startingPosition
     * @return \SplObjectStorage
     */
    public function recalculateGraphFromPosition(Position $startingPosition)
    {
        $this->tiles = new \SplObjectStorage();
        $this->buildTileGraph($this->fetchTileInPosition($startingPosition));

        return $this->tiles;
    }

    /**
     * @param $i
     * @return Position
     */
    public function getPositionByStringIndex($i)
    {
        if ($i%2 != 0) {
            throw new \InvalidArgumentException("Index must be even");
        }
        $i = (int) ($i/2);
        $x = $i % $this->size;
        $y = (int) floor($i / $this->size);
        $startPos = new Position($x, $y);

        return $startPos;
    }
}
