<?php

namespace WodorNet\Vindinium\Tile;

class PathTileFactory 
{
    private $identityMap;

    public function neighbours(PathTile $tile)
    {
        foreach ($tile->getNeighbours() as $abstractTile) {
            if (!isset($this->identityMap[(string) $abstractTile->getPosition()])) {
                $this->identityMap[(string) $abstractTile->getPosition()] =  new PathTile($abstractTile);
            }

            yield $this->identityMap[(string) $abstractTile->getPosition()];
        };
    }
} 