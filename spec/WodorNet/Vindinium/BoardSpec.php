<?php

namespace spec\WodorNet\Vindinium;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WodorNet\Vindinium\Position;
use WodorNet\Vindinium\TileGraphBuilder;

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

    function it_builds_tile_graph()
    {
        $this->fetchTileInPosition(new Position(2,0))->shouldHaveNeighbours(
            array($this->fetchTileInPosition(new Position(2,1)))
        );
    }

    function it_calculates_postion_by_string_index()
    {
        $this->getPositionByStringIndex(8)->getX()->shouldReturn(0);
        $this->getPositionByStringIndex(8)->getY()->shouldReturn(1);
    }

    function getMatchers()
    {
        return [
            'haveNeighbours' => function($subjectTile, $expectedTiles) {
                    foreach($expectedTiles as $expectedTile) {
                        if(!$subjectTile->getNeighbours()->contains($expectedTile)) {
                            throw new FailureException(sprintf("%s expected to have neighbour: %s", $subjectTile->getPosition(), $expectedTile->getPosition()));
                        }
                    }
                    return true;
                }
        ];
    }
}
