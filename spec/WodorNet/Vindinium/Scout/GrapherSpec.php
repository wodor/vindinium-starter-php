<?php

namespace spec\WodorNet\Vindinium\Scout;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WodorNet\Vindinium\State;

class GrapherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('WodorNet\Vindinium\Scout\Grapher');
    }

    function it_has_state(State $state)
    {
        $this->setState($state);
    }
}
