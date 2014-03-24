<?php

namespace WodorNet\Vindinium;

class Path extends \SplQueue
{
    public function __toString()
    {
        $s = clone $this;
        $dump = '';
        foreach($this as $k=>$p) {
            $dump .= "$k: $p ";
        }
        return "elements count: ".(string)iterator_count($this) . "  " . $dump;
    }
}
