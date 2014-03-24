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

        if ($this->y>0) {
            $neighbours[] = new Position($this->x, $this->y-1);
        }

        return $neighbours;
    }

    public function moveStringTo(Position $position)
    {
        $xDist = $this->x - $position->getX();
        $yDist = $this->y - $position->getY();

        if ($xDist == 0 && $yDist == 0) {
            return 'Stay';
        }

        if (abs($xDist) > abs($yDist)) {
            return ($xDist > 0 ? 'North' : 'South');
        }

        return ($yDist > 0 ? 'West' : 'East');

    }

    public function isNeighbourOf(Position $position)
    {
        foreach($this->neighbours() as $neighbour){
            if($position->getX() == $neighbour->getX() && $position->getY() == $neighbour->getY()) {
                return true;
            }
        }
        return false;
    }

}
