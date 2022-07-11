<?php

declare(strict_types=1);

namespace App\Bot\Dating\Data\Entity;

use App\Bot\Dating\Modules\Profile\Enum\Couple;
use App\Bot\Dating\Modules\Profile\Enum\Gender;
use App\Bot\Dating\Modules\Profile\Enum\Platform;
use App\Bot\Dating\Modules\Profile\Enum\Zodiac;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(indexes={
 *      @ORM\Index(columns={"login"}),
 *      @ORM\Index(columns={"is_active"}),
 *      @ORM\Index(columns={"created_at"}),
 * })
 *
 * @ORM\Entity(repositoryClass="App\Bot\Dating\Modules\Profile\Repository\ProfileRepository")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Profile
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    protected ?string $id = null;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @Serializer\Expose
     */
    protected string $login;

    /**
     * @ORM\Column(type="string", length=150)
     *
     * @Serializer\Expose
     */
    protected string $name;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Serializer\Expose
     */
    public \DateTime $birthDate;

    /**
     * @ORM\Column(type="string",  length=2)
     *
     * @Serializer\Expose
     */
    protected string $countryCode;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Expose
     */
    protected string $city;

    /**
     * @ORM\Column(type="smallint")
     *
     * @Assert\Choice(callback={"App\Bot\Dating\Modules\Profile\Enum\Gender", "Gender::cases()"})
     *
     * @Serializer\Expose
     */
    protected int $gender;

    /**
     * @ORM\Column(type="smallint")

     * @Assert\Choice(callback={"App\Bot\Dating\Modules\Profile\Enum\Platform", "Platform::cases()"})
     *
     * @Serializer\Expose
     */
    protected int $platform;

    /**
     * @ORM\Column(type="smallint")

     * @Assert\Choice(callback={"App\Bot\Dating\Modules\Profile\Enum\Couple", "Couple::cases()"})
     *
     * @Serializer\Expose
     */
    protected int $couple;

    /**
     * @ORM\Column(type="smallint")
     *
     * @Assert\Choice(callback={"App\Bot\Dating\Modules\Profile\Enum\Zodiac", "Zodiac::cases()"})
     *
     * @Serializer\Expose
     */
    protected int $zodiac;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Serializer\Expose
     */
    protected ?string $tags = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Serializer\Expose
     */
    protected ?string $description = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Serializer\Expose
     */
    protected ?string $media = null;

    /**
     * @ORM\Column(type="string", length=5)
     *
     * @Serializer\Expose
     */
    protected string $locale;

    /**
     * @ORM\Column(type="string", length=2)
     *
     * @Serializer\Expose
     */
    protected string $lang;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     *
     * @Serializer\Expose
     */
    protected bool $active = false;

    /**
     * @ORM\Column(type="datetime_immutable")
     *
     * @Serializer\Expose
     */
    protected \DateTimeImmutable $createdAt;

    public function __construct(
        string $login,
        string $name,
        string $birthDate,
        string $countryCode,
        string $city,
        Gender $gender,
        Platform $platform,
        Couple $couple,
        Zodiac $zodiac,
        ?string $tags = null,
        ?string $description = null,
        ?string $media = null,
    ) {
        $this->login = $login;
        $this->name = $name;
        $this->birthDate = new \DateTime($birthDate);
        $this->countryCode = $countryCode;
        $this->city = $city;
        $this->gender = $gender->value;
        $this->platform = $platform->value;
        $this->couple = $couple->value;
        $this->zodiac = $zodiac->value;
        $this->tags = $tags;
        $this->description = $description;
        $this->locale = 'ru';
        $this->lang = 'ru';
        $this->media = $media;

        $this->active = true;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBirthDate(): string
    {
        return $this->birthDate->format('Y-m-d');
    }

    public function setBirthDate(\DateTime $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getPlatform(): Platform
    {
        return Platform::from($this->platform);
    }

    public function setPlatform(Platform $platform): void
    {
        $this->platform = $platform->value;
    }

    public function getGender(): Gender
    {
        return Gender::from($this->gender);
    }

    public function setGender(Gender $gender): void
    {
        $this->gender = $gender->value;
    }

    public function getCouple(): Couple
    {
        return Couple::from($this->couple);
    }

    public function setCouple(Couple $couple): void
    {
        $this->couple = $couple->value;
    }

    public function getZodiac(): Zodiac
    {
        return Zodiac::from($this->zodiac);
    }

    public function setZodiac(Zodiac $zodiac): void
    {
        $this->zodiac = $zodiac->value;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): void
    {
        $this->tags = $tags;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(?string $media): void
    {
        $this->media = $media;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
