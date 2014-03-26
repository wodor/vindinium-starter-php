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
        $this->setState(
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
        // TODO: write matcher to assert internals
//        foreach($this->getTiles()->getWrappedObject() as $tile) {
//            echo "\n $tile";
//            foreach($tile->getNeighbours() as $n) {
//                echo "\n\t" . $n;
//            }
//        }
        $this->getTilesGraph(new Position(2,0))->shouldHaveCount(9);
    }

    function it_calculates_postion_by_string_index()
    {
        $this->getPositionByStringIndex(8)->getX()->shouldReturn(0);
        $this->getPositionByStringIndex(8)->getY()->shouldReturn(1);

    }
}
