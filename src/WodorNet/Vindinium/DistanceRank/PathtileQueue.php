<?php

namespace WodorNet\Vindinium\DistanceRank;

use WodorNet\Vindinium\Tile\PathTile;

class PathtileQueue extends \SplPriorityQueue
{
    public function insertPathTile(PathTile $tile)
    {
        parent::insert($tile, $tile->getCost());
    }

    public function insert($value, $priority)
    {
        throw new \RuntimeException("Use insertPathTile instead");
    }

    public function compare($priority1, $priority2)
    {
        if(is_null($priority1)) {
            return -1;
        }

        if(is_null($priority2)) {
            return 1;
        }

        return parent::compare($priority1, $priority2) * -1;
    }

    public function __toString()
    {
        $s = clone $this;
        $dump = '';
        foreach($s as $k=>$p) {
            $dump .= " \n\t $k: " . $p;
        }
        return "\n PathTileQueue elements count: ".(string)iterator_count($s) . $dump;
    }

} 