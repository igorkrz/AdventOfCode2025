<?php

declare(strict_types=1);

namespace App\Command;

use DateTime;
use Error;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PuzzleCommand extends Command
{
    protected static string $defaultName = 'puzzle';

    public function __construct(?string $name = null, ?callable $code = null)
    {
        $name = $name ?? self::$defaultName;
        parent::__construct($name, $code);
    }

    protected function configure(): void
    {
        $currentDay = (new DateTime())->format("d");
        $currentSolutionPart = 1;

        $this
            ->setHelp('This command lets you run puzzles by day')
            ->addOption('day', 'd', InputOption::VALUE_REQUIRED, "Puzzle day", $currentDay)
            ->addOption('part', 'p', InputOption::VALUE_REQUIRED, "Puzzle solution part", $currentSolutionPart);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day = $input->getOption('day');
        $part = $input->getOption('part');

        try {
            $class = sprintf('\\App\\Puzzle\\Day%s\\Solution', $day);
            $solution = new $class();
        } catch (Error) {
            $output->writeln(sprintf('<error>No class found for day %s</error>', $day));
            return Command::FAILURE;
        }

        switch ($part) {
            case 1:
                $array = $solution->read();
                $result = $solution->solution1($array);
                $solution->write($result);
                break;
            case 2:
                $array = $solution->read();
                $result = $solution->solution2($array);
                $solution->write($result);
                break;
            default:
                $output->writeln(sprintf('<error>No method found for puzzle %s</error>', $part));
                return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
