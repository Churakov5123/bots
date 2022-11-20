<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Statistic\Command;

use App\Bot\Dating\Modules\Profile\Command\FakeData\FakeProfile;
use App\Bot\Dating\Modules\Profile\Services\ProfileService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeStatistic extends Command
{
    use LockableTrait;

    private const BASE_COUNT_PROFILES = 1000;

    public function __construct(
        private FakeProfile $fakeProfile,
        private ProfileService $profileService,
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('profile:generate')
            ->setDescription('Generates a pack of 50 different profiles for each gender .');
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

        $this->release();

        return 0;
    }
}
