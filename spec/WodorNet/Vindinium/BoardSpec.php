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

    function Xit_finds_surrounding_passable_tiles()
    {
//        $surroundingPassableTiles = $this->getSurroundingPassableTiles(new Position(3, 3));
//        foreach($surroundingPassableTiles as $tile) {
//            $tile->shouldBeAnInstanceOf('WodorNet\Vindinium\Tile\AbstractTileSS');
//        }
    }

    function it_builds_tile_graph()
    {
        $this->getTiles()->shouldHaveCount(7);
    }

    function it_calculates_postion_by_string_index()
    {
        $this->getPositionByStringIndex(8)->getX()->shouldReturn(0);
        $this->getPositionByStringIndex(8)->getY()->shouldReturn(1);

    }
}
