<?php
declare(strict_types=1);

namespace Adorosh\Algorithms\OOP;

class Fibonacci
{
    private const START_A = 0;
    private const START_B = 1;

    private float $a;
    private float $b;

    public function printSequence(): void
    {
        $this->initAB();

        $this->print($this->a);
        $this->print($this->b);

        while (!is_infinite($this->a)) {
            $this->next();

            //Cast scientific notation (1.3069892237634E+308) into human-readable and remove thousands separator
            $this->print(number_format($this->b, 0, '.', ' '));
        }
    }

    private function initAB(): void
    {
        $this->a = self::START_A;
        $this->b = self::START_B;
    }

    private function next(): void
    {
        $this->b = $this->a + $this->b;
        $this->a = $this->b - $this->a;
    }

    private function print($value): void
    {
        echo $value . PHP_EOL;
    }
}
