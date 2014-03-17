<?php

namespace spec\WodorNet\Vindinium;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BoardSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(4, '####$$$$%%%%^^^^');
    }
    function it_is_initializable()
    {
        $this->shouldHaveType('WodorNet\Vindinium\Board');
    }
}
