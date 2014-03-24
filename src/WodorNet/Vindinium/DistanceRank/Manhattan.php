<?php

namespace WodorNet\Vindinium\DistanceRank;

use WodorNet\Vindinium\Position;

class Manhattan extends \SplHeap
{
    /**
     * @var Position
     */
    private $protagonistPosition;

    function __construct(Position $protagonistPosition)
    {
        $this->protagonistPosition = $protagonistPosition;
    }

    /**
     * (PHP 5 &gt;= 5.3.0)<br/>
     * Compare elements in order to place them correctly in the heap while sifting up.
     *
     * @link http://php.net/manual/en/splheap.compare.php
     * @param mixed $value1 <p>
     *                      The value of the first node being compared.
     *                      </p>
     * @param mixed $value2 <p>
     *                      The value of the second node being compared.
     *                      </p>
     * @return int Result of the comparison, positive integer if <i>value1</i> is greater than <i>value2</i>, 0 if they are equal, negative integer otherwise.
     *                      </p>
     *                      <p>
     *                      Having multiple elements with the same value in a Heap is not recommended. They will end up in an arbitrary relative position.
     */
    protected function compare($pos1, $pos2)
    {
        return $this->positionDistance($pos2) - $this->positionDistance($pos1);
    }

    /**
     * @param Position $pos
     */
    protected function positionDistance(Position $pos)
    {
        return abs($this->protagonistPosition->getX() - $pos->getX()) +
            abs($this->protagonistPosition->getY() - $pos->getY());
    }

}