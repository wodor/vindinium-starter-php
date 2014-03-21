<?php

namespace WodorNet\Vindinium;

class Pathfinder
{

    private $position;

    private $board;

    public function __construct(Position $position, Board $board)
    {
        $this->position = $position;
        $this->board = $board;
    }
}
