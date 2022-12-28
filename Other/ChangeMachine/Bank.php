<?php
declare(strict_types=1);

namespace Adorosh\Algorithms\Other\ChangeMachine;

use RuntimeException;

Class Bank
{
    /**
     * Vault of papers and coins
     * Amount => Count
     * Amount is presented in cents (100 is $1)
     */
    private array $vault = [];

    private int $total = 0;

    public function __construct(array $vault = [
        1 => 10,
        2 => 10,
        5 => 10,
        10 => 10,
        20 => 10,
        50 => 10,
        100 => 10,
        500 => 10,
        1000 => 10,
        2000 => 10,
        5000 => 10,
        10000 => 10
    ]) {
        $this->vault = $this->normalize($vault);

        $this->calculateTotal();
    }

    public function getChange(int $value): array
    {
        if ($value > $this->total) {
            throw new RuntimeException('We are too broke for you, sowwy :\'(');
        }

        $change = [];

        foreach ($this->vault as $amount => $countInVault) {
            if ($value === 0) {
                break;
            }

            $countToTake = (int)($value / $amount);

            if ($countToTake > 0 && $countInVault) {
                if ($countToTake > $countInVault) {
                    $countToTake = $countInVault;
                }

                $this->vault[$amount] -= $countToTake;
                $change[$amount] = $countToTake;
                $value -= $countToTake * $amount;
            }
        }

        if ($value > 0) {
            $this->rollback($change);

            throw new RuntimeException(
                'We can\'t give you your change coz we ran out of money of needed amount :\'('
            );
        }

        $this->calculateTotal();

        return $change;
    }

    public function getDebugTotal(): float
    {
        return $this->total / 100;
    }

    public function getDebugVault(): array
    {
        $result = [];

        foreach ($this->vault as $amount => $count) {
            $result[(string)($amount/100)] = $count;
        }

        return $result;
    }

    private function normalize(array $input): array
    {
        $normalizedArray = [];

        foreach ($input as $key => $value) {
            $normalizedArray[(int)$key] = ((int)$value > -1) ? (int)$value : 0;
        }

        krsort($normalizedArray);

        return $normalizedArray;
    }

    private function calculateTotal(): void
    {
        $sum = 0;

        foreach ($this->vault as $value => $count) {
            $sum += $value * $count;
        }

        $this->total = $sum;
    }

    private function rollback(array $change): void
    {
        foreach ($change as $amount => $count) {
            $this->vault[$amount] += $count;
        }
    }
}
