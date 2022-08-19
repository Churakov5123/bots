<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Requests;

use App\Bot\Dating\Components\Request\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;

class ReadProfileRequest extends BaseRequest
{
    /**
     * @Assert\NotBlank,
     * @Assert\NotNull,
     * @Assert\Type("string")
     */
    protected string $id;
}
