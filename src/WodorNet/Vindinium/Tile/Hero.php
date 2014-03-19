<?php

namespace WodorNet\Vindinium\Tile;

class Hero extends AbstractTile
{
    /**
     * Interesting thing, should we consider this passable
     * or maybe we should when hero is weak enough
     *
     * Not being passable can make some parts of map innaccessible
     *
     * @return bool
     */
    public function isPassable()
    {
//        return true;
        return false;
    }
}
