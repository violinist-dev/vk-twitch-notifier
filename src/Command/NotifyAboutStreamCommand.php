<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NotifyAboutStreamCommand extends Command
{
    use LockableTrait;

    private const COMMAND = 'app:notify-about-stream';

    public function __construct()
    {
        parent::__construct(self::COMMAND);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->lock()) {
            $output->writeln('<error>The command is already running in another process.</error>');

            return 1;
        }

        $this->release();
    }
}
