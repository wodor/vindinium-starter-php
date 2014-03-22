<?php

namespace WodorNet\Vindinium;

use WodorNet\Vindinium\DistanceRank\Manhattan;

class Scout
{
    private $position;

    private $board;

    /**
     * @param mixed $board
     */
    public function setBoard($board)
    {
        $this->board = $board;
    }

    /**
     * @return mixed
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    public function findClosestMine()
    {
        return $this->findMines()->top();
    }

    /**
     * @return Manhattan
     */
    public function findMines()
    {
        $minesHeap = new Manhattan($this->position);
        $regex = '/\$[\-1-4]{1}/';
        return $this->findRegexPostions($regex, $minesHeap);
    }

    /**
     * @return Manhattan
     */
    public function findHeroes()
    {
        $heroesHeap = new Manhattan($this->position);
        $regex = '/@[\-1-4]{1}/';
        return $this->findRegexPostions($regex, $heroesHeap);
    }

    /**
     * @param $regex
     * @param $matches
     * @return Manhattan
     */
    private function findRegexPostions($regex, \SplHeap $heap)
    {
        preg_match_all($regex, $this->board->getTilesString(), $matches, PREG_OFFSET_CAPTURE);
        foreach ($matches[0] as $match) {
            $heap->insert($this->board->getPositionByStringIndex($match[1]));

        }
        return $heap;
    }
}
