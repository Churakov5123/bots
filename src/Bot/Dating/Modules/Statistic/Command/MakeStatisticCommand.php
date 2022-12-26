<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Statistic\Command;

use App\Bot\Dating\Modules\Statistic\Services\StatisticService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeStatisticCommand extends Command
{
    use LockableTrait;

    public function __construct(
        private StatisticService $statisticService,
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('statistic:make')
            ->setDescription('Make statistic for each day');
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

        $this->statisticService->makeNewStatistic();

        $this->release();

        return 0;
    }
}
