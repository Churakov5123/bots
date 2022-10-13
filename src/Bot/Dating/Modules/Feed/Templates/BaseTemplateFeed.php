<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Templates;

class BaseTemplateFeed extends AbstractTemplateFeed
{
    private const ADS = [
        0 => 'Мы автоматически высчитываем на основе астрологического а так же китайского гороскопа на сколько выбранный профиль Вам соответствует исходя из вашего же гороскопа, на любовь, отношения дружбу итд..',

        1 => 'Когда Ваши пары совпали, Вы получаете уведомление и ссылку на профиль - чтобы написать Вашему человеку.',

        2 => 'У нас доступен приватный поиск, для людей которые ищут конкретные цели (по выбранному интересу) и не хотят это офишировать!',

        3 => 'Мы хотим дать Вам возможность пользовться всеми самыми крутыми функциями нашего бота.
              Поделись своей уникальной ссылкой на регистрацию с кем то из приятелем, и если он создаст анкету, тебе автоматичеси будет доступен режим приватного поиска ..
              Пригласительная ссылк так же доступна в настройках вашего профиля',

        4 => 'Мы хотим чтоб этот бот помогал Вам максимаально найти то что вы хотите, в ближайшее время будет доступно сопоставление профилей 
         с вашей картой Тарро а так же по Нумерологии, не переключайтесь .',

        5 => 'Наш бот использует продвинутые технологии Искуственного интеллекта
         и на основе заполненного вами профиля - помогает нам максимально сформировть выдачу кандидатов именно под Ваш запрос.
         Поэтому мы рекомендуюм Вам максимально заполнять вашу анкету, для того чтобы добиться потрясающих результатов.',

        6 => 'Заполните поле интерес для знакомства, это поможет сделать нашу выдачу более релевантной Вашим ожиданиям..',

        7 => 'Заполните полее Вашими хобби или описание - мы сможем подобрать Вам конгруэнтную личность.',

        8 => 'У нас можно добавлять до 5 фото, в ближайщее время будет доступно добавление коротких видео',
    ];

    protected function getAdvertSet(): array
    {
        return self::ADS;
    }
}
