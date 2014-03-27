<?php

namespace WodorNet\Vindinium\Tile;

class PathTile
{
    static $identityMap = array();
    /**
     * @var AbstractTile
     */
    private $tile;

    /**
     * @var AbstractTile
     */
    private $previousTile;

    private $cost;

    public function __construct(AbstractTile $tile)
    {
        $this->tile = $tile;
        $this->cost = 1000;
    }

    public function getPosition()
    {
        return $this->tile->getPosition();
    }

    /**
     * @param \WodorNet\Vindinium\Tile\AbstractTile $previousTile
     */
    public function setPreviousTile($previousTile)
    {
        $this->previousTile = $previousTile;
    }

    /**
     * @return \WodorNet\Vindinium\Tile\AbstractTile
     */
    public function getPreviousTile()
    {
        return $this->previousTile;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    public function __toString()
    {
        return sprintf("\n%s, cost: %s, previous: %s)",
            $this->tile,
            is_null($this->cost) ? 'null' : $this->cost,
            $this->previousTile instanceof PathTile ? $this->previousTile->getPosition() : 'none'
        );
    }

    public function getNeighbours()
    {
        foreach ($this->tile->getNeighbours() as $n) {

            if (!isset(self::$identityMap[(string) $n->getPosition()])) {
                self::$identityMap[(string) $n->getPosition()] =  new self($n);
            }
            yield self::$identityMap[(string) $n->getPosition()];
        };
    }

}
