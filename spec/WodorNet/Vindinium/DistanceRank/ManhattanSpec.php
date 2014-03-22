<?php

namespace spec\WodorNet\Vindinium\DistanceRank;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WodorNet\Vindinium\Position;

class ManhattanSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new Position(3,3));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('WodorNet\Vindinium\DistanceRank\Manhattan');
    }

    function it_sorts_positions_by_manhattan_distance(Position $posN, Position $posS)
    {
        $posN->getX()->willReturn(1);
        $posN->getY()->willReturn(1);

        $posS->getX()->willReturn(4);
        $posS->getY()->willReturn(4);

        $this->insert($posN);
        $this->insert($posS);

        $this->top()->shouldReturn($posS);
    }
}
