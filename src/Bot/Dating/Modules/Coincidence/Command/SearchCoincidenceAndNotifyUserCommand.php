<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Coincidence\Command;

use App\Bot\Dating\Modules\Coincidence\Services\CoincidenceService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SearchCoincidenceAndNotifyUserCommand extends Command
{
    use LockableTrait;

    public function __construct(
        private CoincidenceService $coincidenceService
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('coincidence:find')
            ->setDescription('Search match and notify users.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');

            return 1;
        }
        $this->coincidenceService->calculateCoincidences();

        $this->notifyUserAboutCoincidence();

        $output->write('All done.');

        $this->release();

        return 0;
    }
}
