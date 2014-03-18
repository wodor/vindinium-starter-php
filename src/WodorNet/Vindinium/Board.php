<?php

namespace WodorNet\Vindinium;

use WodorNet\Vindinium\Tile\AbstractTile;

class Board
{

    private $size;
    private $tiles;

    public function __construct($size, $tiles)
    {
        $this->size = $size;
        $this->tiles = $tiles;
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
    public function getTiles()
    {
        return $this->tiles;
    }

    public function findClosestFreeMine(Position $startPos)
    {
        $startTile = $this->getTileByPosition($startPos);

        echo $startPos;
        var_dump($startTile->getSurroundingPassableTiles());
        exit();
    }

    /**
     * @param Position $startPos
     * @return AbstractTile
     * @throws \OutOfBoundsException
     */
    public function getTileByPosition(Position $startPos)
    {
        $pos = $this->tilesPositionIndex($startPos);

        if(!$this->positionIsInBounds($startPos)) {
            throw new \OutOfBoundsException($startPos . " is out of bounds");
        }

        $symbol = substr($this->tiles, $pos, 2);

        return $this->createTile($startPos, $symbol);
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
                throw new \InvalidArgumentException(' "' . $symbol . '" ' . ' unrecognized tiles:' . $this->tiles);
        }

        $class = "\\WodorNet\\Vindinium\\Tile\\".$class;

       return new $class($position, $this, $symbol);
    }

    /**
     * @param  Position              $startPos
     * @return mixed
     * @throws \OutOfBoundsException
     */
    public function positionIsInBounds(Position $startPos)
    {
        $pos = $this->tilesPositionIndex($startPos);
        return !($pos > strlen($this->tiles)-2 || $startPos->getX() > $this->size - 1);
    }

    /**
     * @param  Position $startPos
     * @return mixed
     */
    private function tilesPositionIndex(Position $startPos)
    {
        $pos = $startPos->getY() * $this->size * 2 + $startPos->getX() * 2;

        return $pos;
    }

}
