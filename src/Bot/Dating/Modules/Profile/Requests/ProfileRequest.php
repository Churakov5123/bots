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
    protected string $id;
}
