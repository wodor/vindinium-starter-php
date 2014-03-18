<?php

namespace spec\WodorNet\Vindinium;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PositionSpec extends ObjectBehavior
{
    const x = 2;

    const y = 3;

    function let()
    {
        $this->beConstructedWith(self::x, self::y);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('WodorNet\Vindinium\Position');
    }

    function it_has_x()
    {
       $this->getX()->shouldReturn(self::x);
    }

    function it_has_y()
    {
        $this->getY()->shouldReturn(self::y);
    }
}
