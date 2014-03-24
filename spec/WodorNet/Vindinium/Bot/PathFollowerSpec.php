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
    function let(State $state, Hero $protagonist, Board $board)
    {
        $state->getBoard()->willReturn($board);
        $state->getProtagonist()->willReturn($protagonist);
        $this->setState($state);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('WodorNet\Vindinium\Bot\PathFollower');
    }

    function it_moves_along_the_path(Path $path, Hero $protagonist)
    {
        $path->isEmpty()->willReturn(false);
        $path->top()->willReturn(new Position(1,1));
        $path->dequeue()->shouldBeCalled()->willReturn(new Position(10,1));

        $protagonist->getPos()->willReturn(new Position(1,1));

        $this->setPath($path);
        $this->move()->shouldReturn('South');
    }

    function it_takes_next_pathpoint_after_reaching_previous(Path $path, Hero $protagonist)
    {
        $path->isEmpty()->willReturn(false);
        $path->top()->willReturn(new Position(5,1));
        $path->dequeue()->shouldNotBeCalled();

        $protagonist->getPos()->willReturn(new Position(1,1));

        $this->setPath($path);
        $this->move()->shouldReturn('South');
    }
}
