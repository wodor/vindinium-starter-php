<?php

namespace spec\WodorNet\Vindinium;

use PhpSpec\ObjectBehavior;
use WodorNet\Vindinium\Board;
use WodorNet\Vindinium\Position;

class ScoutSpec extends ObjectBehavior
{
    public function let(Position $position, Board $board)
    {
        $this->setBoard($board);
        $this->setPosition($position);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType('WodorNet\Vindinium\Scout');
    }

    public function it_finds_mines(Board $board, Position $minePosition)
    {
        $tiles =
            '@1      '.
            '$-      '.
            '      $-'.
            '        ';

        $board->getSize()->willReturn(4);
        $board->getTilesString()->willReturn($tiles);

        $board->getPositionByStringIndex(8)->shouldBeCalled()->willReturn($minePosition);
        $board->getPositionByStringIndex(22)->shouldBeCalled()->willReturn($minePosition);

        $this->findMines()->top()->shouldReturn($minePosition);
    }

    public function it_finds_heroes(Board $board, Position $heroPosition)
    {
        $tiles =
            '@1      '.
            '$-      '.
            '      $-'.
            '    @4  ';

        $board->getSize()->willReturn(4);
        $board->getTilesString()->willReturn($tiles);

        $board->getPositionByStringIndex(0)->shouldBeCalled()->willReturn($heroPosition);
        $board->getPositionByStringIndex(28)->shouldBeCalled()->willReturn($heroPosition);

        $this->findHeroes()->top()->shouldReturn($heroPosition);
    }

}
