<?php

namespace WodorNet\Vindinium;

/**
 * Class State
 *
 * @package WodorNet\Vindinium
 */
class State
{

    /**
     * @var
     */
    private $stateArray;

    /**
     * @var Board
     */
    private $board;

    /**
     * @param $stateArray
     */
    public function __construct($stateArray)
    {
        $this->stateArray = $stateArray;

        $this->board = new Board($stateArray['game']['board']['size'], $stateArray['game']['board']['tiles']);
    }

    /**
     * @return \WodorNet\Vindinium\Board
     */
    public function getBoard()
    {
        return $this->board;
    }
}
