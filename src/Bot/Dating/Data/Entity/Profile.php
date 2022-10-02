<?php

declare(strict_types=1);

namespace App\Bot\Dating\Data\Entity;

use App\Bot\Dating\Modules\Horoscope\Enum\AstrologyHoroscope;
use App\Bot\Dating\Modules\Horoscope\Enum\ChineseHoroscope;
use App\Bot\Dating\Modules\Profile\Enum\Couple;
use App\Bot\Dating\Modules\Profile\Enum\Gender;
use App\Bot\Dating\Modules\Profile\Enum\Hobby;
use App\Bot\Dating\Modules\Profile\Enum\Platform;
use App\Bot\Dating\Modules\Profile\Enum\SearchMode;
use App\Bot\Dating\Modules\Profile\Enum\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(indexes={
 *      @ORM\Index(columns={"is_active"}),
 *      @ORM\Index(columns={"is_fake"}),
 *      @ORM\Index(columns={"city"}),
 *      @ORM\Index(columns={"country_code"}),
 *      @ORM\Index(columns={"astrology_horoscope"}),
 *      @ORM\Index(columns={"chinese_horoscope"}),
 *      @ORM\Index(columns={"age"}),
 *      @ORM\Index(columns={"tag"}),
 *      @ORM\Index(columns={"search_mode"}),
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
     * @ORM\Column(type="string", length=64, unique=true)
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
    protected \DateTime $birthDate;

    /**
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     */
    protected int $age;

    /**
     * @var int[]
     *
     * @ORM\Column(type="json")
     *
     * @Serializer\Expose
     */
    protected array $searchAgeDiapazone;

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
     * @Assert\Choice(callback={"App\Bot\Dating\Modules\Profile\Enum\SearchMode", "SearchMode::cases()"})
     *
     * @Serializer\Expose
     */
    protected int $searchMode;

    /**
     * @ORM\Column(type="smallint")
     *
     * @Assert\Choice(callback={"App\Bot\Dating\Modules\Profile\Enum\HoroscopeValueObject", "HoroscopeValueObject::cases()"})
     *
     * @Serializer\Expose
     */
    protected int $astrologyHoroscope;

    /**
     * @ORM\Column(type="smallint")
     *
     * @Assert\Choice(callback={"App\Bot\Dating\Modules\Profile\Enum\HoroscopeValueObject", "HoroscopeValueObject::cases()"})
     *
     * @Serializer\Expose
     */
    protected int $chineseHoroscope;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Assert\Choice(callback={"App\Bot\Dating\Modules\Profile\Enum\Tag", "Tag::cases()"})
     *
     * @Serializer\Expose
     */
    protected ?int $tag = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Serializer\Expose
     */
    protected ?string $description = null;

    /**
     * @var Image[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Image", mappedBy="profile", cascade={"persist", "remove"})
     * @Serializer\Expose
     * @Serializer\Accessor(setter="setImages")
     * @Serializer\SerializedName("images")
     */
    protected Collection $images;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\Choice(callback={"App\Bot\Dating\Modules\Profile\Enum\Hobby", "Hobby::cases()"})
     *
     * @Serializer\Expose
     */
    protected ?int $hobby = null;

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
     * @ORM\Column(name="is_fake", type="boolean")
     *
     * @Serializer\Expose
     */
    protected bool $fake = false;

    /**
     * @ORM\Column(type="datetime_immutable")
     *
     * @Serializer\Expose
     */
    protected ?\DateTimeImmutable $lastActivity = null;

    /**
     * @ORM\Column(type="datetime_immutable")
     *
     * @Serializer\Expose
     */
    protected \DateTimeImmutable $createdAt;

    public function __construct(
        string $login,
        string $name,
        \DateTime $birthDate,
        AstrologyHoroscope $astrologyHoroscope,
        ChineseHoroscope $chineseHoroscope,
        string $countryCode,
        string $city,
        Gender $gender,
        Platform $platform,
        Couple $couple,
        array $searchAgeDiapazone,
        ?Tag $tag = null,
        ?string $description = null,
        ?Hobby $hobby = null,
    ) {
        $this->login = $login;
        $this->name = $name;
        $this->birthDate = $birthDate;
        $this->astrologyHoroscope = $astrologyHoroscope->value;
        $this->chineseHoroscope = $chineseHoroscope->value;
        $this->countryCode = $countryCode;
        $this->city = $city;
        $this->gender = $gender->value;
        $this->platform = $platform->value;
        $this->couple = $couple->value;
        $this->searchMode = SearchMode::from(1)->value; // тут пока будет базовый поиск но потом можно будет менять режим поиска
        $this->age = $this->calculateAge($birthDate);
        $this->searchAgeDiapazone = $searchAgeDiapazone;
        $this->tag = $tag?->value;
        $this->description = $description;
        $this->images = new ArrayCollection();
        $this->hobby = $hobby;

        $this->locale = 'ru';
        $this->lang = 'ru';
        $this->active = true;
        $this->lastActivity = new \DateTimeImmutable();
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @return \Ramsey\Uuid\UuidInterface
     */
    public function getId(): \Ramsey\Uuid\UuidInterface|string|null
    {
        return $this->id;
    }

    public function isActive(): bool
    {
        return true === $this->active;
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
        return $this->birthDate->format('d-m-Y');
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

    public function getTag(): ?Tag
    {
        return Tag::from($this->tag);
    }

    public function setTag(?Tag $tag): void
    {
        $this->tag = $tag->value;
    }

    public function getAstrologyHoroscope(): AstrologyHoroscope
    {
        return AstrologyHoroscope::from($this->astrologyHoroscope);
    }

    public function setAstrologyHoroscope(AstrologyHoroscope $astrologyHoroscope): void
    {
        $this->astrologyHoroscope = $astrologyHoroscope->value;
    }

    public function getChineseHoroscope(): ChineseHoroscope
    {
        return ChineseHoroscope::from($this->chineseHoroscope);
    }

    public function setChineseHoroscope(ChineseHoroscope $chineseHoroscope): void
    {
        $this->chineseHoroscope = $chineseHoroscope->value;
    }

    public function getHobby(): ?Hobby
    {
        return $this->hobby ? Hobby::from($this->hobby) : $this->hobby;
    }

    public function setHobby(?Hobby $hobby): void
    {
        $this->hobby = $hobby?->value;
    }

    /**
     * @return iterable|Image[]
     */
    public function getImages(): iterable
    {
        return $this->images;
    }

    /**
     * @param ArrayCollection|Image[] $images
     */
    public function setImages(iterable $images): void
    {
        $this->images = $images;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }

    public function addImage(Image $img): void
    {
        $img->setProfile($this);

        $this->images[] = $img;
    }

    public function calculateAge(\DateTime $birthDate): int
    {
        $diff = (((new \DateTime())->getTimestamp() - $birthDate->getTimestamp()) / (60 * 60 * 24 * 365));

        return (int) floor($diff);
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(\DateTime $birthDate): void
    {
        $this->age = $this->calculateAge($birthDate);
    }

    public function getSearchMode(): SearchMode
    {
        return SearchMode::from($this->searchMode);
    }

    public function setSearchMode(SearchMode $searchMode): void
    {
        $this->searchMode = $searchMode->value;
    }

    public function getSearchAgeDiapazone(): array
    {
        return $this->searchAgeDiapazone;
    }

    public function setSearchAgeDiapazone(array $searchAgeDiapazone): void
    {
        $this->searchAgeDiapazone = $searchAgeDiapazone;
    }

    public function setFake(bool $fake): void
    {
        $this->fake = $fake;
    }

    public function getLastActivity(): ?\DateTimeImmutable
    {
        return $this->lastActivity;
    }

    public function setLastActivity(?\DateTimeImmutable $lastActivity): void
    {
        $this->lastActivity = $lastActivity;
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
