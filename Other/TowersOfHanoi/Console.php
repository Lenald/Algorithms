<?php
declare(strict_types=1);

namespace Adorosh\Algorithms\Other\TowersOfHanoi;

class Console
{
    public function __construct(
        private readonly Frame $frame
    ) {
    }

    public function printFrame(): void
    {
        system('clear');

        self::print(PHP_EOL . $this->frame . PHP_EOL);

        sleep(1);
    }

    public static function print(string $message): void
    {
        echo $message . PHP_EOL;
    }

    public static function requirePositiveInt(string $message, int $from, $to): int
    {
        self::print(sprintf('%s (from %d to %d)', $message, $from, $to));
        echo '> ';

        $value = readline();

        if ($value === false) {
            self::print('Bye!');
            exit;
        }

        self::print('');

        if ($errorMessage = self::validateInt($value, $from, $to)) {
            self::print($errorMessage);

            return self::requirePositiveInt($message, $from, $to);
        }

        return (int)$value;
    }

    private static function validateInt(string $value, int $from, int $to): string
    {
        if ($value != (int)$value) {
            return sprintf('Value must be a positive integer number from %d to %d', $from, $to);
        }

        $value = (int)$value;

        if ($value < $from) {
            return 'Value must be not less than ' . $from;
        }

        if ($value > $to) {
            return 'Value must be not greater than ' . $to;
        }

        return '';
    }
}
