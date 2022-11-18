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
 *      @ORM\Index(columns={"choose_profile"}),
 *      @ORM\Index(columns={"chosen_profile"}),
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
     * @ORM\Column(type="string", length=64, unique=true)
     *
     * @Serializer\Expose
     */
    protected string $chooseProfile;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
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
    ) {
        $this->createdAt = new \DateTimeImmutable();
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
