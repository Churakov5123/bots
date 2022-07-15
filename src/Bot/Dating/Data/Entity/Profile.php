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
     * @var int[]
     *
     * @ORM\Column(type="json")
     *
     * @Serializer\Expose
     */
    protected array $matchingZodiacs = [];

    /**
     * @var string[]
     *
     * @ORM\Column(type="json")
     *
     * @Serializer\Expose
     */
    protected array $tags = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Serializer\Expose
     */
    protected ?string $description = null;

    /**
     * @var string[]
     *
     * @ORM\Column(type="json")
     *
     * @Serializer\Expose
     */
    protected array $media = [];

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
        ?array $tags = null,
        ?string $description = null,
        ?array $media = null,
    ) {
        $this->login = $login;
        $this->name = $name;
        $this->birthDate = new \DateTime($birthDate);
        $this->countryCode = $countryCode;
        $this->city = $city;
        $this->gender = $gender->value;
        $this->platform = $platform->value;
        $this->couple = $couple->value;
        $this->zodiac = $this->calculateZodiac($birthDate)->value;
        $this->matchingZodiacs = $this->getMatchingZodiacs($this->getZodiac($birthDate));
        $this->tags = $tags?? [];
        $this->description = $description;
        $this->media = $media ?? [];

        $this->locale = 'ru';
        $this->lang = 'ru';
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

    /**
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param string[] $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param string $birthDate
     *
     * @return Zodiac
     */
    public function calculateZodiac(string $birthDate): Zodiac
    {
       return  Zodiac::from(1);
    }

    /**
     * Логика для получения совпадений с другими зодиаками.
     *
     * @param Zodiac $zodiac
     *
     * @return int[]
     */
    public function getMatchingZodiacs(Zodiac $zodiac):array
    {
        return [];
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
