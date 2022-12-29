<?php
declare(strict_types=1);

namespace Adorosh\Algorithms\Other\TowersOfHanoi;

use SplStack;

class Tower
{
    private int $id;
    private SplStack $stack;

    public function __construct(int $id, int $ringsCount)
    {
        $this->id = $id;
        $this->stack = new SplStack();

        $ringsCount = (!$id) ? $ringsCount : 0;

        for ($ring = $ringsCount; $ring > 0; $ring--) {
            $this->putRing($ring);
        }

        $this->stack->rewind();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function whatOnTop(): int
    {
        return $this->stack->current() ?? 0;
    }

    public function getRing(): int
    {
        return $this->stack->pop();
    }

    public function putRing(int $ring): void
    {
        $this->stack->push($ring);
    }

    public function getAllStack(): array
    {
        $result = [];

        $this->stack->rewind();

        while ($this->stack->valid()) {
            $result[] = $this->stack->current();
            $this->stack->next();
        }

        $this->stack->rewind();

        return $result;
    }

    public function getCount(): int
    {
        return $this->stack->count();
    }
}
