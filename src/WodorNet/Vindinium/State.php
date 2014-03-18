<?php

namespace WodorNet\Vindinium;

/**
 * Class State
 *
 * @package WodorNet\Vindinium
 */
class State
{
    private $heroes = array();

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
        foreach ($stateArray['game']['heroes'] as $heroArray) {
            $hero = new Hero(
                isset($heroArray['userId']) ? $heroArray['userId'] : null,
                new Position($heroArray['spawnPos']['x'], $heroArray['spawnPos']['y']),
                new Position($heroArray['pos']['x'], $heroArray['pos']['y']),
                $heroArray['name'],
                $heroArray['mineCount'],
                $heroArray['life'],
                $heroArray['id'],
                $heroArray['gold'],
                isset($heroArray['elo']) ? $heroArray['elo'] : 0 ,
                $heroArray['crashed']
            );
            $this->heroes[$hero->getId()] = $hero;
        }
    }

    /**
     * @return \WodorNet\Vindinium\Board
     */
    public function getBoard()
    {
        return $this->board;
    }

    public function getViewUrl()
    {
        return $this->stateArray['viewUrl'];
    }

    /**
     * @return array
     */
    public function getHeroes()
    {
        return $this->heroes;
    }

    public function getProtagonist()
    {
        return $this->getHeroes()[$this->stateArray['hero']['userId']];
    }
}
