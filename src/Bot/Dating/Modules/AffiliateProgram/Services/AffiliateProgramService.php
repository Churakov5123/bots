<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\AffiliateProgram\Services;

use App\Bot\Dating\Modules\Profile\Repository\ProfileRepository;

class AffiliateProgramService
{
    public const TELEGRAM_BOT_URL = '@DatingBotCoffe#';

    public function __construct(
        private ProfileRepository $profileRepository
    ) {
    }

    /**
     * Пока делается базавоя установка подписок прямо в профиль -
     * не делается отдельная сущность под подписки! поскольку на первоначальных этапх проекта это просто не имеет смысл
     * основная задача прото привлечь людей  за счет того что дать им полный доступ на все функции поиска и подбора пары - они будут доступны разом все.
     * потом если проект будет работать как нужно можно уже будет давать дефиренцированно.
     */
    public function activateSubscriptionForAttracting(string $affiliateCode): void
    {
        $profile = $this->profileRepository->findByAffiliateCode($affiliateCode);

        if (null === $profile) {
            return;
        }

        $profile->setSubscription(true);

        $this->profileRepository->save($profile);
    }
}
