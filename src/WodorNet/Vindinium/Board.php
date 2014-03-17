<?php

namespace WodorNet\Vindinium;

class Board
{

    private $size;
    private $tiles;

    function __construct($size, $tiles)
    {
        $this->size = $size;
        $this->tiles = $tiles;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getTiles()
    {
        return $this->tiles;
    }

}
