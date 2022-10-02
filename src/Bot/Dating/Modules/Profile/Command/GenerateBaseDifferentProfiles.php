<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Command;

use App\Bot\Dating\Modules\Profile\Command\FakeData\FakeProfile;
use App\Bot\Dating\Modules\Profile\Dto\CreateProfileDto;
use App\Bot\Dating\Modules\Profile\Services\ProfileService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateBaseDifferentProfiles extends Command
{
    use LockableTrait;

    private const BASE_COUNT_PROFILES = 200;

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

        $count = 0;

        while ($count < self::BASE_COUNT_PROFILES) {
            $fakeProfile = $this->fakeProfile->getProfile();

            if (empty($fakeProfile)) {
                return 0;
            }

            $dto = (new CreateProfileDto())->fillFromArray($fakeProfile);

            $profile = $this->profileService->make($dto, true);

            print_r($profile);

            ++$count;
        }

        $this->release();

        return 0;
    }
}
