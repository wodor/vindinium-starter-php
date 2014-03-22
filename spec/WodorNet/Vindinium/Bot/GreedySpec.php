<?php

namespace spec\WodorNet\Vindinium\Bot;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WodorNet\Vindinium\Board;
use WodorNet\Vindinium\Hero;
use WodorNet\Vindinium\Position;
use WodorNet\Vindinium\Scout;
use WodorNet\Vindinium\State;

class GreedySpec extends ObjectBehavior
{
    const SOUTH = 'South';

    function let(Scout $scout, State $state, Hero $protagonist, Board $board)
    {
        $this->beConstructedWith($scout);
        $state->getBoard()->willReturn($board);
        $state->getProtagonist()->willReturn($protagonist);
        $this->setState($state);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType('WodorNet\Vindinium\Bot\Greedy');
    }

    function it_moves_to_closest_mine(
        State $state,
        Scout $scout,
        Hero $protagonist,
        Position $protagonistPosition,
        Position $minePosition
    )
    {
        $protagonistPosition->getX()->willReturn(0);
        $protagonistPosition->getY()->willReturn(0);
        $protagonist->getPos()->willReturn($protagonistPosition);
        $state->getProtagonist()->willReturn($protagonist);
        $scout->findClosestMine()->willReturn($minePosition);
        $protagonistPosition->moveStringTo($minePosition)->shouldBeCalled()
            ->willreturn(self::SOUTH);
        $this->move()->shouldReturn(self::SOUTH);
    }
}
