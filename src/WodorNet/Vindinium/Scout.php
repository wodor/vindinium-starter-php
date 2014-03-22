<?php

namespace WodorNet\Vindinium;

class Scout
{
    private $position;

    private $board;

    public function __construct(Position $position, Board $board)
    {
        $this->position = $position;
        $this->board = $board;
    }

    public function findMines()
    {
        $regex = '/\$[\-1-4]{1}/';
        return $this->findRegexPostions($regex);
    }

    public function findHeroes()
    {
        $regex = '/@[\-1-4]{1}/';
        return $this->findRegexPostions($regex);
    }

    /**
     * @param $regex
     * @param $matches
     * @return array
     */
    private function findRegexPostions($regex)
    {
        preg_match_all($regex, $this->board->getTilesString(), $matches, PREG_OFFSET_CAPTURE);
        $postions = [];
        foreach ($matches[0] as $match) {
            $postions[] = $this->board->getPositionByStringIndex($match[1]);

        }

        return $postions;
    }
}
