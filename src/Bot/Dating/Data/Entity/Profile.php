<?php

declare(strict_types=1);

namespace App\Bot\Dating\Data\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table
 * @ORM\Entity(repositoryClass="App\Bot\Dating\Modules\Profile\Repository\ProfileRepository")
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
    protected ?string $name = '';

    /**
     * @var string[]
     *
     * @ORM\Column(type="json")
     */
    protected array $countries = [];

    /**
     * @ORM\Column(name="is_active", type="boolean")
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return string[]
     */
    public function getCountries(): array
    {
        if (null == $this->countries) {
            return [];
        }

        return $this->countries;
    }

    /**
     * @param string[] $countries
     */
    public function setCountries(array $countries): void
    {
        $this->countries = $countries;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
