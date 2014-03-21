<?php

namespace spec\WodorNet\Vindinium;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WodorNet\Vindinium\Board;
use WodorNet\Vindinium\Position;

class PathfinderSpec extends ObjectBehavior
{
    public function let(Position $position, Board $board)
    {
        $this->beConstructedWith($position, $board);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('WodorNet\Vindinium\Pathfinder');
    }
}
