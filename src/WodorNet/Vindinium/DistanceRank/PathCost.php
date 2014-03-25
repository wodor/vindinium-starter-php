<?php

namespace WodorNet\Vindinium\DistanceRank;

class PathCost extends \SplHeap
{
    protected function compare($pos1, $pos2)
    {
        return $pos2->getCost() - $pos1->getCost();
    }

    public function __toString()
    {
        $s = clone $this;
        $dump = '';
        foreach($s as $k=>$p) {
            $dump .= " \n\t $k: " . $p;
        }
        return "\n Pathcost elements count: ".(string)iterator_count($s) . $dump;
    }
} 