<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Coincidence\Services;

use App\Bot\Dating\Data\Entity\Coincidence;
use App\Bot\Dating\Modules\Coincidence\Repository\CoincidenceRepository;
use App\Bot\Dating\Modules\Feed\Factory\TemplateFactory;

class CoincidenceAnalyzeProcessor
{
    public function __construct(
        private CoincidenceRepository $coincidenceRepository,
        private TemplateFactory $templateFactory,
    ) {
    }

    public function execute(): void
    {
        $coincidences = $this->coincidenceRepository->getNotSendedCoincidences();

        if (empty($coincidences)) {
            return;
        }
        /** @var Coincidence $coincidence */
        foreach ($coincidences as $coincidence) {
            // отправлять нотификацию мы будем  id совпадения $coincidence->getId()
            // Делаем отправку в очерь  Рэбита сообщений $coincidence->getId() !

            // эта логика будет в  обработчике
//            $template = $this->templateFactory->getTemplate(
//                $coincidence->getChooseProfile()->getSearchMode(),
//                $coincidence->getChooseProfile()
//            );
//
//            $match = $template->prepareProfile(); //датасет совпадения пары
//            $coincidence->getChooseProfile()->getId() // id получателя
        }
    }
}
