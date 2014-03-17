<?php

namespace spec\WodorNet\Vindinium;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StateSpec extends ObjectBehavior
{
    const tiles = '####$$$$%%%%^^^^';

    const size = 4;

    function let()
    {
        $state = ['game' =>
            ['board' =>
                ['size' => self::size,
                 'tiles' => self::tiles
                ]
            ]
        ];

        $this->beConstructedWith($state);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('WodorNet\Vindinium\State');
    }

    function it_puts_the_board_in_place()
    {
        $this->getBoard()->shouldBeAnInstanceOf('WodorNet\Vindinium\Board');
        $this->getBoard()->getTiles()->shouldBeEqualTo(self::tiles);
        $this->getBoard()->getSize()->shouldBeEqualTo(self::size);
    }

}
