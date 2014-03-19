<?php

namespace WodorNet\Vindinium;

class Position
{
    private $x;
    private $y;

    public function __construct($x, $y)
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

    public function neighbours()
    {
        $neighbours = [];

        $neighbours[] = new Position($this->x+1, $this->y);
        $neighbours[] = new Position($this->x, $this->y+1);

        if ($this->x>0) {
            $neighbours[] = new Position($this->x-1, $this->y);
        }

        if($this->y>0) {
            $neighbours[] = new Position($this->x, $this->y-1);
        }

        return $neighbours;
    }

}
