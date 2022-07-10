<?php
declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Requests;

use App\Bot\Dating\Components\Enum\EnumTransformer;
use App\Bot\Dating\Components\Request\BaseRequest;
use App\Bot\Dating\Modules\Profile\Enum\Gender;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Contracts\Service\Attribute\Required;
use UnitEnum;

class CreateProfileRequest extends BaseRequest
{
    #[Type('string')]
    #[Regex('/^[A-Za-z\d_\- ]+$/')] // допилить регулярку чтобы и цифры и букувы - только цирфы не работало! и собаку тоже!!!
    #[NotBlank]
    #[NotNull]
    #[Length([
        'min' => 2,
        'max' => 25,
    ])]
    protected ?string $login;

    #[Type('string')]
    #[Regex('/^[A-Za-z\d_\- ]+$/')] // допилить регулярку чтобы и цифер небыло
    #[NotBlank]
    #[NotNull]
    #[Length([
        'min' => 2,
        'max' => 30,
    ])]
    protected string $name;

    #[Type('string')]
    #[Length([
        'min' => 2,
        'max' => 500,
    ])]
    protected ?string $description;

    #[DateTime('d-m-Y')]
    #[NotBlank]
    #[NotNull]
    protected string $birthDate;

    #[Country()]
    #[NotBlank]
    #[NotNull]
    #[Length([
        'min' => 2,
        'max' => 2
    ])]
    protected string $countryCode;

    #[Type('string')]
    #[NotBlank]
    #[NotNull]
    protected string $city;

    #[Choice(choices: [])]
    #[NotBlank]
    #[NotNull]
    protected int $gender;

//    #[Type('integer')]
//    #[NotBlank]
//    #[NotNull]
//    protected int $couple;
//
//    #[Type('integer')]
//    #[NotBlank]
//    #[NotNull]
//    protected int $platform;
//
//    protected ?array $tags = null;
//    protected ?array $media = null;
//    protected ?string $lang = null;
//    protected ?string $locale = null;
//
//    protected ?bool $active = null;
}
