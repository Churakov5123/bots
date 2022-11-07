<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Requests;

use App\Bot\Dating\Components\Request\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;

class ReadFeedRequest extends BaseRequest
{
    /**
     * @Assert\Type("string")
     * @Assert\Uiid
     */
    protected ?string $profileId = null;

    /**
     * @Assert\Type("boolean")
     */
    protected ?bool $resolution = null;
}
