<?php
declare(strict_types=1);

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

class Application
{
    private Bank $bank;

    private bool $debug = false;

    public function __construct()
    {
        $this->bank = new Bank();
    }

    public function run(array $argv): void
    {
        $this->debug = (isset($argv[1]) && $argv[1] === '--debug');

        while (true) {
            $changeAmount = $this->getChangeAmount();

            echo 'So, you need $' . $changeAmount / 100 . ' as a change...' . PHP_EOL;

            $result = 'You are getting';

            try {
                foreach ($this->bank->getChange($changeAmount) as $amount => $count) {
                    if ($amount < 100) {
                        $sign = '￠';
                    } else {
                        $sign = '$';
                        $amount /= 100;
                    }

                    $result .= ' ' . $count . ' of ' . $sign . $amount . ',';
                }

                echo rtrim($result, ',') . ' as your change!' . PHP_EOL
                    . 'Lets try once more!' . PHP_EOL;
            } catch (RuntimeException $e) {
                echo 'Bank said: ' . $e->getMessage() . PHP_EOL
                    . 'Lets try again...' . PHP_EOL;
            }
        }
    }

    private function getChangeAmount(): int
    {
        if ($this->debug) {
            $this->debug();
        }

        echo 'Enter the change amount (float number)' . PHP_EOL . '> $';
        $changeAmount = readline();

        if ($changeAmount === false) { //^D during readline()
            echo PHP_EOL;
            exit;
        }

        if ($errorMessage = $this->validate($changeAmount)) {
            echo $errorMessage . PHP_EOL;

            return $this->getChangeAmount();
        }

        return (int)($changeAmount * 100);
    }

    private function validate(string $amount): string
    {
        if (!is_numeric($amount)) {
            return 'Value must be numeric!';
        }

        $amount = (float)$amount * 100;

        if ($amount < 1) {
            return 'Amount must be greater than or equal to $0.01';
        }

        if ($amount > (int)$amount) {
            return 'Not more 2 digits after the decimal separator are allowed!';
        }

        return '';
    }

    private function debug(): void
    {
        $mask = '| %8.8s | %-5.5s |' . PHP_EOL;
        $table = '+----------+-------+' . PHP_EOL
            . sprintf($mask, 'Amount', 'Count')
            . '+----------+-------+' . PHP_EOL;
        $mask = '| %8.2f | %-5.5d |' . PHP_EOL;

        foreach ($this->bank->getDebugVault() as $amount => $count) {
            $table .= sprintf($mask, $amount, $count);
        }

        $table .= '+----------+-------+';

        printf(
            'DEBUG:%1$sBank\'s vault:%1$s%2$s%1$sBank\'s capability: %3$.2f%1$s/DEBUG%1$s',
            PHP_EOL,
            $table,
            $this->bank->getDebugTotal()
        );
    }
}

(new Application())->run($argv);
