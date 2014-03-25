<?php

namespace spec\WodorNet\Vindinium\Bot;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WodorNet\Vindinium\Board;
use WodorNet\Vindinium\Hero;
use WodorNet\Vindinium\Path;
use WodorNet\Vindinium\Position;
use WodorNet\Vindinium\State;

class PathFollowerSpec extends ObjectBehavior
{
    function let(State $state, Hero $protagonist, Board $board, Path $path)
    {
        $path->__toString()->willReturn('');
        $state->getBoard()->willReturn($board);
        $state->getProtagonist()->willReturn($protagonist);
        $this->setState($state);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('WodorNet\Vindinium\Bot\PathFollower');
    }

    function it_stays_on_place(Path $path, Hero $protagonist)
    {
        $path->isEmpty()->willReturn(false);
        $path->bottom()->willReturn(new Position(1,1));
        $path->dequeue()->shouldNotBeCalled()->willReturn(new Position(10,1));

        $protagonist->getPosition()->willReturn(new Position(1,1));

        $this->setPath($path);
        $this->move()->shouldReturn('Stay');
    }

    function it_takes_next_pathpoint_after_reaching_previous(Path $path, Hero $protagonist)
    {
        $path->isEmpty()->willReturn(false);
        $path->bottom()->willReturn(new Position(5,1));
        $path->dequeue()->shouldNotBeCalled();

        $protagonist->getPosition()->willReturn(new Position(1,1));

        $this->setPath($path);
        $this->move()->shouldReturn('South');
    }

}
