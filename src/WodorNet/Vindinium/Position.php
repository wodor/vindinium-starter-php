<?php

namespace WodorNet\Vindinium;

class Position
{
    private $x;
    private $y;

    function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    public function __toString()
    {
        return "( x:{$this->x}, y:{$this->y} )";
    }

}
