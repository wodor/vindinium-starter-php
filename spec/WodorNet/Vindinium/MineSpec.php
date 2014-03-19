<?php

namespace spec\WodorNet\Vindinium;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MineSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('WodorNet\Vindinium\Mine');
    }
}
