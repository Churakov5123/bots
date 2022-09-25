<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class ProfileRequest extends CreateProfileRequest
{
    /**
     * @Assert\NotBlank,
     * @Assert\NotNull,
     * @Assert\Type("string")
     */
    protected string $lang;

    /**
     * @Assert\NotBlank,
     * @Assert\NotNull,
     * @Assert\Type("string")
     */
    protected string $locale;

    /**
     * @Assert\Choice({1,2,3,4,5,6})
     */
    protected int $searchMode;
}
