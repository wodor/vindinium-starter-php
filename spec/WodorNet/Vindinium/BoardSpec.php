<?php

namespace spec\WodorNet\Vindinium;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WodorNet\Vindinium\Position;
use WodorNet\Vindinium\Tile\Ground;

class BoardSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(4,
            '$-    $-'.
            '[]  ####'.
            '    ##  '.
            '$2    @1'
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('WodorNet\Vindinium\Board');
    }

    function it_finds_surrounding_passable_tiles()
    {
        $this->getSurroundingPassableTiles(new Position(3,3))
            ->shouldHaveCount(2);
    }

    function it_builds_tile_graph()
    {
        $this->getTiles()->shouldHaveCount(7);
    }

// pomysl - rob ekspoloracje - dawaj info jak blisko sa poszczegolne cele
}
