<?php
declare(strict_types=1);

namespace Adorosh\Algorithms\Other\TowersOfHanoi;

class MovementStats
{
    private int $ring = Application::EMPTY_VALUE;
    private int $towerFrom = Application::EMPTY_VALUE;
    private int $towerTo = Application::EMPTY_VALUE;
    private int $count = 0;

    public function registerMovement(Tower $from, Tower $to): void
    {
        $this->ring = $from->whatOnTop();
        $this->towerFrom = $from->getId() + 1;
        $this->towerTo = $to->getId() + 1;
        $this->count++;
    }

    /**
     * @return int[]
     */
    public function getMovementDetails(): array
    {
        return [$this->ring, $this->towerFrom, $this->towerTo];
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
