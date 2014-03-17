<?php

namespace WodorNet\Vindinium;

class Display
{

    private $state;

    public function __construct(State $state)
    {
        $this->state = $state;
    }

    public function displayBoard()
    {
        return implode("\n" , str_split($this->state->getBoard()->getTiles(),
            $this->state->getBoard()->getSize()))."\n";
    }
}
