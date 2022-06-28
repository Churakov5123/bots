<?php

declare(strict_types=1);

namespace App\Bot\Dating\Data\Entity;

use App\Bot\Dating\Modules\Profile\Dto\TagsDto;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table
 *
 * @ORM\Entity(repositoryClass="App\Bot\Dating\Modules\Profile\Repository\ProfileRepository")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Profile
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     *
     * @Serializer\Expose
     */
    protected ?int $id = null;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @Assert\NotBlank
     * @Serializer\Expose
     */
    protected string $login;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose
     */
    protected string $name;

    /**
     * ENUM
     *
     * @var string
     *
     * @ORM\Column(type="string", length=10)
     * @Serializer\Expose
     */
    protected string $gender;

    /**
     * ФОРМАТ ДАТЫ!
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose
     */
    protected string $birthdate;

    /**
     * ENUM
     *
     * @var string
     *
     * @ORM\Column(type="string", length=10)
     * @Serializer\Expose
     */
    protected string $couple;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose
     */
    protected string $zodiac;

    /**
     * @var TagsDto[]
     *
     * @ORM\Column(type="array")
     * @Serializer\Expose
     */
    protected array $tags;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Expose
     */
    protected ?string $description = null;

    /**
     * Массив урл одресов на картинки, в хранилище по типу солителя.
     *
     * @var string[]
     *
     * @ORM\Column(type="array")
     * @Serializer\Expose
     */
    protected array $media;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose
     */
    protected string $country;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose
     */
    protected string $city;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     * @Serializer\Expose
     */
    protected bool $active = false;

    /**
     * @ORM\Column(type="datetime_immutable")
     *
     * @Serializer\Expose
     */
    protected \DateTimeImmutable $createdAt;


    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getBirthdate(): string
    {
        return $this->birthdate;
    }

    /**
     * @param string $birthdate
     */
    public function setBirthdate(string $birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return string
     */
    public function getCouple(): string
    {
        return $this->couple;
    }

    /**
     * @param string $couple
     */
    public function setCouple(string $couple): void
    {
        $this->couple = $couple;
    }

    /**
     * @return string
     */
    public function getZodiac(): string
    {
        return $this->zodiac;
    }

    /**
     * @param string $zodiac
     */
    public function setZodiac(string $zodiac): void
    {
        $this->zodiac = $zodiac;
    }

    /**
     * @return TagsDto[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param TagsDto[] $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string[]
     */
    public function getMedia(): array
    {
        return $this->media;
    }

    /**
     * @param string[] $media
     */
    public function setMedia(array $media): void
    {
        $this->media = $media;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
