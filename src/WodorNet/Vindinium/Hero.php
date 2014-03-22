<?php

namespace WodorNet\Vindinium;

class Hero
{
    private $id;
    private $name;
    private $userId;
    private $elo;
    private $pos;
    private $life;
    private $gold;
    private $mineCount;
    private $spawnPos;
    private $crashed;

    function __construct($userId, Position $spawnPos, Position $pos, $name, $mineCount, $life, $id, $gold, $elo, $crashed)
    {
        $this->userId = $userId;
        $this->spawnPos = $spawnPos;
        $this->pos = $pos;
        $this->name = $name;
        $this->mineCount = $mineCount;
        $this->life = $life;
        $this->id = $id;
        $this->gold = $gold;
        $this->elo = $elo;
        $this->crashed = $crashed;
    }

    /**
     * @return mixed
     */
    public function getCrashed()
    {
        return $this->crashed;
    }

    /**
     * @return mixed
     */
    public function getElo()
    {
        return $this->elo;
    }

    /**
     * @return mixed
     */
    public function getGold()
    {
        return $this->gold;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLife()
    {
        return $this->life;
    }

    /**
     * @return mixed
     */
    public function getMineCount()
    {
        return $this->mineCount;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Position
     */
    public function getPos()
    {
        return $this->pos;
    }

    /**
     * @return mixed
     */
    public function getSpawnPos()
    {
        return $this->spawnPos;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }


}
