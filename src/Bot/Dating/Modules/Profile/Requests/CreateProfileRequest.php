<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Requests;

use App\Bot\Dating\Components\Request\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;

class CreateProfileRequest extends BaseRequest
{
    /**
     * @Assert\NotBlank,
     * @Assert\NotNull,
     * @Assert\Regex(
     *     pattern = "/^@[a-z0-9_]{3,20}$|^[a-z0-9_]{3,20}$/i",
     * ),
     * @Assert\Type("string"),
     * @Assert\Length(
     *      min = 2,
     *      max = 25,
     * )
     */
    protected ?string $login;

    /**
     * @Assert\NotBlank,
     * @Assert\NotNull,
     * @Assert\Regex(
     *     pattern = "/^([A-Za-z])+$/",
     * ),
     * @Assert\Type("string"),
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     * )
     */
    protected string $name;

    /**
     * @Assert\Type("string"),
     * @Assert\Length(
     *      min = 2,
     *      max = 350,
     * )
     */
    protected ?string $description;

    /**
     * @Assert\NotBlank,
     * @Assert\NotNull,
     * @Assert\DateTime("d-m-Y")
     */
    protected string $birthDate;

    /**
     * @Assert\NotBlank,
     * @Assert\NotNull,
     * @Assert\Country
     */
    protected string $countryCode;

    /**
     * @Assert\NotBlank,
     * @Assert\NotNull,
     * @Assert\Type("string")
     */
    protected string $city;

    /**
     * @Assert\NotBlank,
     * @Assert\NotNull,
     * @Assert\Choice({1,2,3})
     */
    protected int $gender;

    /**
     * @Assert\NotBlank,
     * @Assert\NotNull,
     * @Assert\Choice({1,2,3,4,5,6})
     */
    protected int $couple;

    /**
     * @Assert\NotBlank,
     * @Assert\NotNull,
     * @Assert\Choice({1})
     */
    protected int $platform;

    /**
     * @Assert\Choice({1,2,3,4,5,6,7,8})
     */
    protected ?int $tag = null;

    /**
     * @Assert\Collection(
     *     fields={
     *         "popular"  =  @Assert\Optional({@Assert\Type("string")}),
     *     },
     *     allowMissingFields = true
     * )  */
    protected ?array $media = null;

    /**
     * @Assert\Collection(
     *     fields={
     *         "popular"  =  @Assert\Optional({@Assert\Type("string")}),
     *     },
     *     allowMissingFields = true
     * )  */
    protected ?array $hobby = null;
}
