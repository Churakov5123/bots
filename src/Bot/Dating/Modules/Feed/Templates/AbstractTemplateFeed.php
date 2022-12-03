<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Templates;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Ad\Decorator\AdDecorator;
use App\Bot\Dating\Modules\Feed\Decorator\ProfileDecoratorFromTemplate;
use App\Bot\Dating\Modules\Horoscope\Services\HoroscopeService;

abstract class AbstractTemplateFeed implements FeedTemplate
{
    public const BASE_TEMPLATE = 'BASE';
    public const PRIVATE_TEMPLATE = 'PRIVATE';

    private const ADVERTISING_PLACE = 5;

    public function __construct(
        protected ProfileDecoratorFromTemplate $decoratorFromTemplate,
        protected AdDecorator $adDecorator,
        protected Profile $profileOwner
    ) {
    }

    abstract public function getName(): string;

    abstract protected function getAdvertSet(): array;

    abstract public function prepareProfile(Profile $profile, Profile $profileOwner): array;

    public function getAdvert(int $number): string
    {
        return $this->getAdvertSet()[$number];
    }

    public function prepareData(array $profiles): array
    {
        $count = 0;
        $advertCount = 0;
        $result = [];

        foreach ($profiles as $profile) {
            ++$count;

            $result[] = $this->prepareProfile($profile, $this->profileOwner);

            if (self::ADVERTISING_PLACE === $count) {
                $ads = $advertCount >= $this->getAdvertCount() ? $advertCount = 0 : $advertCount++;

                $result[] = $this->prepareAd($this->getAdvert($ads));

                $count = 0;
            }
        }

        return $result;
    }

    public function getAdvertCount(): int
    {
        return count($this->getAdvertSet());
    }

    public function prepareAd(string $msg): array
    {
        $this->adDecorator->setMessage($msg);

        return $this->adDecorator->getAdForFeed();
    }

    public function isBaseTemplate(): bool
    {
        return self::BASE_TEMPLATE === $this->getName();
    }

    public function isPrivateTemplate(): bool
    {
        return self::PRIVATE_TEMPLATE === $this->getName();
    }

    protected function transformProfile(Profile $profile, Profile $profileOwner): ProfileDecoratorFromTemplate
    {
        $horoscopeService = new HoroscopeService(new \DateTime($profileOwner->getBirthDate()));

        $this->decoratorFromTemplate->setProfile($profile);
        $this->decoratorFromTemplate->setHoroscopeService($horoscopeService);

        return $this->decoratorFromTemplate;
    }
}
