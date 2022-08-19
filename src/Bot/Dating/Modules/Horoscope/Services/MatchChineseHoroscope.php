<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Horoscope\Services;

use App\Bot\Dating\Modules\Horoscope\Enum\ChineseHoroscope;

class MatchChineseHoroscope
{
    private const DECODING = [
        0 => 'Шанс построить хорошие отношения достаточно высок, поскольку наладить контакт таким людям друг с другом легко. Ссоры и конфликты возникают крайне редко, а вот измены это вообще редчайшее явление. Такие отношения можно назвать комфортными.',
        1 => 'Cоюз в такой паре проблематичный, поскольку между партнерами возникает много ссор и проблем, а вообще они очень долгое время притираются. Восточный гороскоп советует несколько раз подумать, прежде чем идти под венец.',
        2 => 'Oтношения в такой паре можно назвать уравновешенными. Все дело в том, что к этой группе относятся пары, в которых совмещаются противоположные энергетики. Такие отношения могут перейти в крепкий и долгий брак.',
        3 => 'Между такими людьми налажен контакт и царит гармония. Совместимость в любви по годам рождения практически идеальна и влюбленные могут не переживать, поскольку их ждет долгая и счастливая жизнь',
        4 => 'Такой союз строится на противостоянии, поэтому влюбленным достаточно сложно быть рядом друг с другом. Важно заметить, что такие отношения могут привести к тому, что влюбленные останутся врагами.',
        5 => 'В таком союзе часто возникают ссоры, поэтому такие люди не могут быть вместе, поскольку это делает их несчастными.',
        6 => 'Неровный союз. Совместимость в сексе и любви знаков по году рождения в таком случае неоднозначная, поскольку могут быть белые и черные полосы. Люди смогут сохранить отношения только в том случае, если присутствуют сильные чувства.',
    ];

    private const COMPATIBILITY =
        [
            1 => [0, 2, 0, 1, 3, 0, 4, 5, 3, 6, 0, 0],
            2 => [2, 0, 0, 0, 6, 3, 5, 4, 0, 3, 1, 0],
            3 => [0, 0, 0, 0, 0, 5, 3, 0, 4, 0, 3, 2],
            4 => [1, 0, 0, 0, 5, 0, 6, 3, 0, 4, 2, 3],
            5 => [3, 6, 0, 5, 1, 0, 0, 0, 3, 2, 4, 0],
            6 => [0, 3, 5, 0, 0, 0, 0, 0, 2, 3, 0, 4],
            7 => [4, 5, 3, 6, 0, 0, 1, 2, 0, 0, 3, 0],
            8 => [5, 4, 0, 3, 0, 0, 2, 0, 0, 0, 1, 3],
            9 => [3, 0, 4, 0, 3, 2, 0, 0, 0, 0, 0, 5],
            10 => [6, 3, 0, 4, 2, 3, 0, 0, 0, 1, 5, 0],
            11 => [0, 1, 3, 2, 4, 0, 3, 1, 0, 5, 0, 0],
            12 => [0, 0, 2, 3, 0, 4, 0, 3, 5, 0, 0, 1],
        ];

    private const BEST_COMPATIBILITY = [1, 2, 3, 4, 5];

    public function getMatched(ChineseHoroscope $targetSing, ChineseHoroscope $sing): string
    {
        $compatibilities = $this->getCompatibilities($targetSing);

        return self::DECODING[$compatibilities[$sing->value - 1]];
    }

    private function getCompatibilities(ChineseHoroscope $sing): array
    {
        return self::COMPATIBILITY[$sing->value];
    }

    public function getBestMatched(ChineseHoroscope $targetSing, ChineseHoroscope $sing): ?string
    {
        $compatibilities = $this->filteredOnBestCompatibilities($targetSing);

        if (empty($compatibilities)) {
            return null;
        }

        return self::DECODING[$compatibilities[$sing->value - 1]];
    }

    private function filteredOnBestCompatibilities(ChineseHoroscope $sing): array
    {
        return array_diff(self::COMPATIBILITY[$sing->value], self::BEST_COMPATIBILITY);
    }
}
