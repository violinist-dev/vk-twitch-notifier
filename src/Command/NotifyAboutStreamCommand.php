<?php

declare(strict_types=1);

namespace App\Command;

use App\StreamDetector\TwitchStreamDetector;
use App\ValueObject\TwitchUsername;
use App\ValueObject\Url;
use App\VkNotifier;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function App\explodeNonEmpty;

class NotifyAboutStreamCommand extends Command
{
    use LockableTrait;

    private const COMMAND = 'app:notify-about-stream';

    /**
     * @var TwitchStreamDetector
     */
    private $twitchStreamDetector;

    /**
     * @var string[]
     */
    private $twitchWatchUsernames;

    /**
     * @var VkNotifier
     */
    private $vkNotifier;

    public function __construct(
        TwitchStreamDetector $twitchStreamDetector,
        VkNotifier $vkNotifier,
        string $twitchWatchUsernames
    ) {
        parent::__construct(self::COMMAND);

        $this->twitchStreamDetector = $twitchStreamDetector;
        $this->vkNotifier = $vkNotifier;
        $this->twitchWatchUsernames = explodeNonEmpty(',', $twitchWatchUsernames);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->lock()) {
            $output->writeln('<error>The command is already running in another process.</error>');

            return 1;
        }

        /** @var Url[] $activeStreams */
        $activeStreams = [];

        foreach ($this->twitchWatchUsernames as $twitchWatchUsername) {
            $twitchStream = $this->twitchStreamDetector->getActiveStream(new TwitchUsername($twitchWatchUsername));

            if ($twitchStream === null) {
                continue;
            }

            $activeStreams[] = $twitchStream;
        }

        $this->vkNotifier->notify($activeStreams);

        $this->release();
    }
}
