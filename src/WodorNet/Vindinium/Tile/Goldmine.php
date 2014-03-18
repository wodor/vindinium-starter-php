<?php

namespace WodorNet\Vindinium\Tile;

class Goldmine extends AbstractTile
{
    public function isFree()
    {
        return $this->symbol{1} == '-';
    }
}
