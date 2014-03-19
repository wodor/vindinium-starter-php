<?php

namespace WodorNet\Vindinium\Tile;

use WodorNet\Vindinium\Board;
use WodorNet\Vindinium\Position;

class Ground extends AbstractTile
{
    public function __construct(Position $position, Board $board)
    {
        parent::__construct($position, $board, '  ');
    }

    public function isPassable()
    {
        return true;
    }
}
