<?php

namespace WodorNet\Vindinium;

class Path extends \SplQueue
{
    public function __toString()
    {
        $s = clone $this;
        $dump = '';
        foreach($s as $k=>$p) {
            $dump .= " $k: " . $p;
        }
        return "elements count: ".(string)iterator_count($s) . $dump;
    }

    public function getCost()
    {
        return iterator_count($this);
    }

}
