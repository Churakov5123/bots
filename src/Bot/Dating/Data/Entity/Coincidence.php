<?php

declare(strict_types=1);

namespace App\Bot\Dating\Data\Entity;

use App\Bot\Dating\Components\Entity\ArrayExpressible;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Table(indexes={
 *      @ORM\Index(columns={"created_at"}),
 * })
 *
 * @ORM\Entity(repositoryClass="App\Bot\Dating\Modules\Profile\Repository\CoincidenceRepository")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Coincidence extends ArrayExpressible
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
     * @ORM\ManyToOne(targetEntity="Profile", inversedBy="coincidences", cascade={"persist", "remove"})
     *
     * @Serializer\Expose
     */
    protected Profile $chooseProfile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Expose
     */
    protected string $chosenProfile;

    /**
     * @ORM\Column(name="is_like", type="boolean")
     *
     * @Serializer\Expose
     */
    protected bool $like;

    /**
     * @ORM\Column(type="datetime_immutable")
     *
     * @Serializer\Expose
     */
    protected \DateTimeImmutable $createdAt;

    public function __construct(
        Profile $chooseProfile,
        string $chosenProfile,
        bool $like
    ) {
        $this->chooseProfile = $chooseProfile;
        $this->chosenProfile = $chosenProfile;
        $this->like = $like;

        $this->createdAt = new \DateTimeImmutable();
    }

    public function getChooseProfile(): Profile
    {
        return $this->chooseProfile;
    }

    public function setChooseProfile(Profile $chooseProfile): void
    {
        $this->chooseProfile = $chooseProfile;
    }

    public function getChosenProfile(): string
    {
        return $this->chosenProfile;
    }

    public function setChosenProfile(string $chosenProfile): void
    {
        $this->chosenProfile = $chosenProfile;
    }

    public function isLike(): bool
    {
        return $this->like;
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
