<?php

namespace WodorNet\Vindinium\Tile;

class Goldmine extends AbstractTile
{
    public function getOwnerId()
    {
        return $this->symbol{1};
    }
}
