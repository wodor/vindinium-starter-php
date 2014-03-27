<?php

namespace WodorNet\Vindinium\Tile;

use WodorNet\Vindinium\Board;
use WodorNet\Vindinium\Position;

/**
 * Class AbstractTile
 *
 * @package WodorNet\Vindinium\Tile
 */
abstract class AbstractTile
{
    protected $symbol;

    /**
     * @var \WodorNet\Vindinium\Position
     */
    private $position;

    /**
     * @var \WodorNet\Vindinium\Board
     */
    private $board;

    /**
     * @var SplObjectStorage
     */
    private $neighbours;

    /**
     * @param Position $position
     * @param Board    $board
     */
    public function __construct(Position $position, Board $board, $symbol)
    {
        $this->position = $position;
        $this->board = $board;
        $this->symbol = $symbol;
        $this->neighbours = new \SplObjectStorage();
    }

    /**
     * @return bool
     */
    public function isPassable()
    {
        return false;
    }

    /**
     * Tells if this tile is here for whole game
     * @return bool
     */
    public function isMovable()
    {
        return false;
    }


    public function __toString()
    {
        return  " ($this->symbol) at " . $this->position . ' ';// . spl_object_hash($this);
    }


    public function addNeighbour(AbstractTile $tile)
    {
        $this->neighbours->attach($tile);
    }

    /**
     * @return \WodorNet\Vindinium\Tile\Tile[]
     */
    public function getNeighbours()
    {
        return $this->neighbours;
    }

    /**
     * @return \WodorNet\Vindinium\Position
     */
    public function getPosition()
    {
        return $this->position;
    }

}
