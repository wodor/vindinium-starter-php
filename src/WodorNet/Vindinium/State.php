<?php

namespace WodorNet\Vindinium;

/**
 * Class State
 *
 * @package WodorNet\Vindinium
 */
/**
 * Class State
 *
 * @package WodorNet\Vindinium
 */
class State
{
    /**
     * @var array
     */
    private $heroes = array();

    /**
     * @var
     */
    private $stateArray;

    /**
     * @var Board
     */
    private $board;

    public function __construct(){
        $this->board = new Board();
    }

    /**
     * @param $stateArray
     */
    public function update($stateArray)
    {
        $this->stateArray = $stateArray;
        $this->board->setState($stateArray['game']['board']['tiles']);
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

    /**
     * @return mixed
     */
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

    /**
     * @return Hero
     */
    public function getProtagonist()
    {
        return $this->getHeroes()[$this->stateArray['hero']['id']];
    }

}
