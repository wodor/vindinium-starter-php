<?php

namespace WodorNet\Vindinium\Tile;

class Hero extends AbstractTile
{
    /**
     * Interesting thing, should we consider this passable
     * or maybe we should when hero is weak enough
     *
     * Not being passable can make some parts of map innaccessible
     * but for now we recalculate the paths every time and maybe we want to go
     * around the hero
     * @return bool
     */
    public function isPassable()
    {
//        return true;
        return false;
    }

    public function isMovable()
    {
        return true;
    }
}
