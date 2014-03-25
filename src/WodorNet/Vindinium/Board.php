<?php

namespace WodorNet\Vindinium;

use WodorNet\Vindinium\Tile\AbstractTile;

class Board
{

    private $size;
    private $tilesString;
    private $tiles;
    private $tilesArray;

    public function __construct($size, $tilesString)
    {
        $this->size = $size;
        $this->tilesString = $tilesString;
        $this->tiles = new \SplObjectStorage();
//        $this->buildTileGraph($this->getFirstPassableTile());

//        foreach ($this->tiles as $tile) {
//            echo "\n" . $tile;
//        }
    }

    private function getFirstPassableTile()
    {
        $i = 0;
        while (true) {
            $startPos = $this->getPositionByStringIndex($i);
            $tile = $this->createTileInPosition($startPos);
            if ($tile->isPassable()) {
                return $tile;
            }
            $i++;
            $i++;
        }
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return mixed
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
    public function createTileInPosition(Position $startPos)
    {
        if (isset($this->tilesArray[(string) $startPos])) {
            return $this->tilesArray[(string) $startPos];
        }
        $pos = $this->tilesPositionIndex($startPos);

        if (!$this->positionIsInBounds($startPos)) {
            throw new \OutOfBoundsException($startPos . " is out of bounds");
        }

        $symbol = substr($this->tilesString, $pos, 2);

        $tile = $this->createTile($startPos, $symbol);

        // flick memory for now
        $this->tilesArray[(string) $startPos] = $tile;

        return $tile;
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
    public function positionIsInBounds(Position $startPos)
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
        $pos = $startPos->getX() * $this->size * 2 + $startPos->getY() * 2;

        return $pos;
    }

    public function surroundingPassableTiles(Position $position)
    {
        foreach ($this->surroundingTiles($position) as $tile) {
            if ($tile->isPassable()) {
                yield $tile;
            }
            continue;
        }
    }

    public function surroundingTiles(Position $position)
    {
        foreach ($position->neighbours() as $neighbour) {
            if (!$this->positionIsInBounds($neighbour)) {
                continue;
            }
            yield $this->createTileInPosition($neighbour);
        }
    }

    public function buildTileGraph(AbstractTile $tile)
    {
        if (!$this->tiles->contains($tile)) {
            $this->tiles->attach($tile);
            foreach ($this->surroundingPassableTiles($tile->getPosition()) as $discoveredTile) {
                $tile->addNeighbour($discoveredTile);
                $discoveredTile->addNeighbour($tile);
                $this->buildTileGraph($discoveredTile);
            }
        }
        else {
//            echo "\n contains already" . $tile;
        }

    }

    /**
     * @param  Position $startingPosition
     * $startingPosition sense is to have correct starting point if movable things are able to
     * cut the graph and we re-calculate graph every move
     * this a bit contradicts what board should be (static once-calculated source of information), but ok for now
     * @return \SplObjectStorage
     */
    public function getTilesGraph(Position $startingPosition)
    {
//        if (empty($this->tiles)) {
            $this->buildTileGraph($this->createTileInPosition($startingPosition));
//        }

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
