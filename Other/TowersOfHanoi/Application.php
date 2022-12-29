<?php
declare(strict_types=1);

namespace Adorosh\Algorithms\Other\TowersOfHanoi;

use RuntimeException;

class Application
{
    public const TAKEN_RING_VALUE = 0;
    public const TAKEN_RING_POSITION = 1;
    public const EMPTY_VALUE = -1;

    private Console $console;

    private MovementStats $movementStats;

    private int $ringsCount;

    /**
     * @var Tower[]
     */
    private array $towers = [];

    /**
     * @var int[]
     */
    private array $takenRing = [self::EMPTY_VALUE, self::EMPTY_VALUE];

    public function run(): void
    {
        try {
            $this->init();

            $this->hanoiTowers($this->ringsCount, ...$this->towers);
        } catch (RuntimeException $e) {
            Console::print($e->getMessage());
        }
    }

    private function init(): void
    {
        $this->ringsCount = Console::requirePositiveInt('Please, enter rings count', 3, 8);

        for ($i = 0; $i < 3; $i++) {
            $this->towers[] = new Tower($i, $this->ringsCount);
        }

        $this->movementStats = new MovementStats();

        $this->console = new Console(
            new Frame($this->ringsCount + 1, $this->towers, $this->takenRing, $this->movementStats)
        );

        $this->console->printFrame();
    }

    private function hanoiTowers(int $quantity, Tower $from, Tower $to, Tower $spare): void
    {
        if ($quantity) {
            $this->hanoiTowers($quantity - 1, $from, $spare, $to);
            $this->moveRing($from, $to);
            $this->hanoiTowers($quantity - 1, $spare, $to, $from);
        }
    }

    private function moveRing(Tower $from, Tower $to): void
    {
        if (!$from->getCount()) {
            throw new RuntimeException(sprintf('Nothing to move from the tower with id %d!', $from->getId()));
        }

        $this->movementStats->registerMovement($from, $to);

        $this->takeRing($from)
            ->moveRingOver($to->getId())
            ->putRing();
    }

    private function takeRing(Tower $tower): self
    {
        if ($this->takenRing[self::TAKEN_RING_VALUE] !== self::EMPTY_VALUE) {
            throw new RuntimeException('Cannot take a ring! Another ring is already taken!');
        }

        $this->takenRing[self::TAKEN_RING_VALUE] = $tower->getRing();
        $this->takenRing[self::TAKEN_RING_POSITION] = $tower->getId();

        $this->console->printFrame();

        return $this;
    }

    private function moveRingOver(int $toTowerId): self
    {
        if ($this->takenRing[self::TAKEN_RING_VALUE] === self::EMPTY_VALUE) {
            throw new RuntimeException('Cannot move a ring! There is no rings taken!');
        }

        while ($this->takenRing[self::TAKEN_RING_POSITION] !== $toTowerId) {
            $this->takenRing[self::TAKEN_RING_POSITION] +=
                ($this->takenRing[self::TAKEN_RING_POSITION] < $toTowerId) ? 1 : -1;

            $this->console->printFrame();
        }

        return $this;
    }

    private function putRing(): void
    {
        if ($this->takenRing[self::TAKEN_RING_VALUE] === self::EMPTY_VALUE) {
            throw new RuntimeException('Cannot put a ring! No ring is taken!');
        }

        $tower = $this->towers[$this->takenRing[self::TAKEN_RING_POSITION]];

        if ($tower->whatOnTop() && $tower->whatOnTop() < $this->takenRing[self::TAKEN_RING_VALUE]) {
            throw new RuntimeException('Cannot put a ring to the tower - there is a smaller ring on top!');
        }

        $tower->putRing($this->takenRing[self::TAKEN_RING_VALUE]);

        $this->takenRing[self::TAKEN_RING_VALUE] = self::EMPTY_VALUE;
        $this->takenRing[self::TAKEN_RING_POSITION] = self::EMPTY_VALUE;

        $this->console->printFrame();
    }
}
