<?php

namespace spec\WodorNet\Vindinium\Scout;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WodorNet\Vindinium\Board;
use WodorNet\Vindinium\Hero;
use WodorNet\Vindinium\Position;
use WodorNet\Vindinium\State;

class GrapherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('WodorNet\Vindinium\Scout\Grapher');
    }

    /**
     */
    function it_generates_reasonable_path(State $state, Hero $hero)
    {
        $map =  '##  @2  ####      ##'.
                '      ########      '.
                '        ####        '.
                '    []        []@4  '.
                '$1    ##    ##    $3'.
                '$1    ##    ##    $1'.
                '    []    @3  []    '.
                '        ####        '.
                '    @1########      '.
                '##      ####      ##';

        $board = new Board();
        $board->setState($map);

        $state->getProtagonist()->willReturn($hero);
        $state->getBoard()->willReturn($board);
        $this->setState($state);

        $this->calculatePathsToPois(new Position(8,2));

        $path = $this->findClosestMine();

        echo $path->getWrappedObject();
        $path->bottom()->getPosition()->getX()->shouldBeLike(7);

    }
}
