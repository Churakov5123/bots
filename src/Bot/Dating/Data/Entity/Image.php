<?php

declare(strict_types=1);

namespace App\Bot\Dating\Data\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Ramsey\Uuid\Doctrine\UuidGenerator;

/**
 * @ORM\Table(indexes={
 *      @ORM\Index(columns={"profile_id"}),
 * })
 *
 * @ORM\Entity(repositoryClass="App\Bot\Dating\Modules\Image\Repository\ImageRepository")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Image
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    protected string $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected string $name;

    /**
     * @ORM\Column(name="path", type="string", length=255)
     */
    protected string $path;

    /**
     * @ORM\ManyToOne(targetEntity="Profile", inversedBy="images")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
     */
    protected $profile;

    public function __construct(string $name, string $path, Profile $profile)
    {
        $this->name = $name;
        $this->path = $path;
        $this->profile = $profile;
    }

    /**
     * @return \Ramsey\Uuid\UuidInterface
     */
    public function getId(): \Ramsey\Uuid\UuidInterface|string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile): void
    {
        $this->profile = $profile;
    }
}
