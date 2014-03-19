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
        $dimension = $this->state->getBoard()->getSize() * 2;
        $mapsep = str_repeat('=', $dimension);

        return "\n" . $mapsep . "\n" .
        implode("\n" , str_split($this->state->getBoard()->getTilesString(),
            $dimension)) .
        "\n" . $mapsep . "\n";
    }

    public function displayLink()
    {
        echo "\n" . $this->state->getViewUrl();
    }

}
