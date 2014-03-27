<?php

namespace spec\WodorNet\Vindinium\Scout;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;
use WodorNet\Vindinium\Board;
use WodorNet\Vindinium\Hero;
use WodorNet\Vindinium\Position;
use WodorNet\Vindinium\State;

class GrapherSpec extends ObjectBehavior
{
    private $map1;

    public function let(State $state, Hero $hero)
    {
        $this->map1 =   '##  @2  ####      ##'.
                        '      ########      '.
                        '        ####        '.
                        '    []        []@4  '.
                        '$1    ##    ##    $3'.
                        '$1    ##    ##    $1'.
                        '    []    @3  []    '.
                        '        ####        '.
                        '    @1########      '.
                        '##      ####      ##';

        $board = new Board();
        $board->setState($this->map1);

        $state->getProtagonist()->willReturn($hero);
        $state->getBoard()->willReturn($board);
        $this->setState($state);
    }

    /**
     */
    public function it_generates_reasonable_path()
    {
        $this->calculatePathsToPois(new Position(8,2));
        $path = $this->findClosestMine();

        echo $path->getWrappedObject();

    }

    public function it_finds_optimal_path_to_chosen_position()
    {
        $path = $this->pathFromTo(new Position(8,2), new Position(9,6));

        $path->shouldLeadThroughPosition(new Position(7,2));
        $path->shouldLeadThroughPosition(new Position(6,5));
    }

    public function getMatchers()
    {
        return [
            'leadThroughPosition' => function($path, $position) {
                    foreach($path as $tile) {
                        if($tile->getPosition() == $position){
                            return true;
                        }
                    }
                    throw new FailureException("Path is not following " . $position);
                },
        ];
    }
}
