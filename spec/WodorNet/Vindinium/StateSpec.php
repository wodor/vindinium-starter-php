<?php

namespace spec\WodorNet\Vindinium;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StateSpec extends ObjectBehavior
{
    const tiles = '####$$$$    @1@2';

    const size = 4;

    function let()
    {
        $state = ['game' =>
            ['board' =>
                ['size' => self::size,
                 'tiles' => self::tiles
                ],
             'heroes' => [
                    json_decode('[ "id":1, "name":"foo", "userId":"ffffffff", "elo":1200, "pos":{ "x":12, "y":6 }, "life":100, "gold":0, "mineCount":0, "spawnPos":{ "x":12, "y":6 }, "crashed":true ]'),
                    json_decode('[ "id":2, "name":"bar", "userId":"bbbbbbbb", "elo":1200, "pos":{ "x":6, "y":12 }, "life":100, "gold":0, "mineCount":0, "spawnPos":{ "x":12, "y":6 }, "crashed":true ]')
                ],
            ],
            'hero' => json_decode('[ "id":2, "name":"bar", "userId":"bbbbbbbb", "elo":1200, "pos":{ "x":6, "y":12 }, "life":100, "gold":0, "mineCount":0, "spawnPos":{ "x":12, "y":6 }, "crashed":true ]')

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
        $this->getBoard()->getTilesString()->shouldBeEqualTo(self::tiles);
        $this->getBoard()->getSize()->shouldBeEqualTo(self::size);
    }

    function it_puts_heroes_in_place()
    {
        $this->getProtagonist()->shouldBeAnInstanceOf('WodorNet\Vindinium\Hero');
    }




}
