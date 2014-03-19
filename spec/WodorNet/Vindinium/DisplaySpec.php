<?php

namespace spec\WodorNet\Vindinium;

use PhpSpec\ObjectBehavior;
use WodorNet\Vindinium\Board;
use WodorNet\Vindinium\State;

class DisplaySpec extends ObjectBehavior
{
    public function let(State $state, Board $board)
    {
        $board->getSize()->willReturn(2);
        $board->getTilesString()->willReturn('####$$$$    @1@2');
        $state->getBoard()->
            willReturn($board);
        $this->beConstructedWith($state);
    }

    public function it_displays_board_in_nice_way()
    {
       $this->displayBoard()
           ->shouldReturn("\n====\n####\n$$$$\n    \n@1@2\n====\n");
    }

}
