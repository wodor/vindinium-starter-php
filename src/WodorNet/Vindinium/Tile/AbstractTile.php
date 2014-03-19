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
     * @var Tile[]
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
    }

    /**
     * @return bool
     */
    public function isPassable()
    {
        return false;
    }

    public function __toString()
    {
        return  get_class($this) . " ($this->symbol) at " . $this->position;
    }


    public function addNeighbour(AbstractTile $tile)
    {
        $this->neighbours[] = $tile;
    }

    /**
     * @return \WodorNet\Vindinium\Position
     */
    public function getPosition()
    {
        return $this->position;
    }

}
