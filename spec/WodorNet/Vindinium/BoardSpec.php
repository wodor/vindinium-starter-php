<?php

namespace spec\WodorNet\Vindinium;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WodorNet\Vindinium\Position;

class BoardSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(4,
            '$-    $-'.
            '    ####'.
            '    ####'.
            '$2    @1'
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('WodorNet\Vindinium\Board');
    }

    function it_finds_closest_free_mine()
    {
        $this->findClosestFreeMine(new Position(3,3))
            ->shouldBeLike(new Position(0,0));
    }
}
