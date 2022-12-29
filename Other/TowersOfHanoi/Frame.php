<?php
declare(strict_types=1);

namespace Adorosh\Algorithms\Other\TowersOfHanoi;

class Frame
{
    private readonly int $oneTowerRowLength;
    private readonly int $maxMovements;

    private int $framesCount = 0;

    public function __construct(
        private readonly int $towerSize,
        private array &$towers,
        private array &$takenRing,
        private MovementStats $movementStats
    ) {
        /**
         * This thing is described in the docblock to
         * @see buildOneTowerFrame()
         */
        $this->oneTowerRowLength = ($this->towerSize + 1) * 2 + 3;

        //2^n - 1, where N is a number of rings
        $this->maxMovements = pow(2, $this->towerSize - 1) - 1;
    }

    public function __toString(): string
    {
        $frame = implode(PHP_EOL, $this->build()) . PHP_EOL
            . PHP_EOL
            . $this->addStatistics();

        $this->framesCount++;

        return $frame;
    }

    /**
     * @return string[]
     */
    private function build(): array
    {
        $towersRows = [];

        foreach ($this->towers as $tower) {
            $towersRows[] = $this->buildOneTowerFrame($tower);
        }

        return $this->mergeTowersFrames($towersRows, $this->towerSize + 3);
    }

    /**
     * @param Tower $tower
     *
     * @return string[]
     *
     * This method builds a frame of a tower and taken ring. Statistics is being added in
     * @see __toString(), addStatistics()
     *
     * This is an example of a single tower frame (borders are only for imagination)
     *
     * |    <(1)>    | < taken ring
     * |             | < empty row
     * |      |      | < extra layer of the stick
     * |      |      | < (ring)
     * |   <=(2)=>   | < ring
     * |  <==(3)==>  | < ring
     * | ####[1]#### | < tower base
     *  ^----------^--< padding 1 space
     * Each ring and the tower base length is 2N + 3, where
     *     N is number of chars on one of sides
     *     3 is a number of a tower or a ring and braces
     * The base is 2 chars longer than the biggest ring (per 1 char for l and r)
     * The height of the stick equals to count of all the rings in the game + 1
     * So, it appears that (the tower base's length / 2) and the stick's lengths are equal to (max ring + 1)
     *
     * Taken ring -- is a ring "in your hand". It has its value and position (over which tower it is now)
     *
     * Each row is being padded with spaces on both sides to total length of (base length + 1) * 2 + 3
     * This value is being set into $oneTowerRowLength in the @see __construct()
     *
     * Here is an example of the whole frame (frames of all towers)
     * |                                        <(1)>      |
     * |                                                   |
     * |        |                |                |        |
     * |        |                |                |        |
     * |        |                |                |        |
     * |        |                |                |        |
     * |        |             <=(2)=>             |        |
     * |  <====(5)====>      <==(3)==>       <===(4)===>   |
     * | ######[1]######  ######[2]######  ######[3]###### |
     *
     * The frame rows count (WITHOUT STATISTICS) is towerSize + 3:
     *                 (                towerSize                )
     * 1 (tower base) + N (max rings count) + 1 (extra stick row) + 1 (empty row) + 1 (taken ring row)
     */
    private function buildOneTowerFrame(Tower $tower): array
    {
        $towerRows = [
            sprintf(' %1$s[%2$d]%1$s ', str_repeat('#', $this->towerSize), $tower->getId() + 1)
        ];

        $rings = array_reverse($tower->getAllStack());

        for ($i = 0; $i < $this->towerSize; $i++) {
            $ring = (count($rings)) ? array_shift($rings) : 0;

            $towerRows[] = $this->buildRingRow($ring);
        }

        $takenRing = $this->takenRing[Application::TAKEN_RING_POSITION] === $tower->getId()
            ? $this->buildRingRow($this->takenRing[Application::TAKEN_RING_VALUE])
            : str_repeat(' ', $this->oneTowerRowLength);

        array_push($towerRows, '', $takenRing);

        return $towerRows;
    }

    private function buildRingRow(int $ringValue): string
    {
        return str_pad(
            (!$ringValue) ? '|' : sprintf('<%1$s(%2$d)%1$s>', str_repeat('=', $ringValue - 1), $ringValue),
            $this->oneTowerRowLength,
            ' ',
            STR_PAD_BOTH
        );
    }

    /**
     * @param Tower[] $towers
     * @param int $rowsCount
     *
     * @return string[]
     */
    private function mergeTowersFrames(array $towers, int $rowsCount): array
    {
        $rows = [];

        for ($row = $rowsCount - 1; $row >= 0; $row--) {
            $value = '';

            foreach ($towers as $tower) {
                $value .= $tower[$row];
            }

            $rows[] = $value;
        }

        return $rows;
    }

    private function addStatistics(): string
    {
        $result = ($this->movementStats->getCount())
            ? sprintf(
                'Movement Info: move ring %d from tower %d to tower %d',
                ...$this->movementStats->getMovementDetails()
            ) . PHP_EOL
            : 'Movement Info:' . PHP_EOL;

        return $result . sprintf(
            'Movements: %d/%d%sFrames: %d',
            $this->movementStats->getCount(),
            $this->maxMovements,
            PHP_EOL,
            $this->framesCount
        );
    }
}
