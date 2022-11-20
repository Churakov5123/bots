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
 *
 * })
 *
 * @ORM\Entity(repositoryClass="App\Bot\Dating\Modules\Profile\Repository\StatisticRepository")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Statistic extends ArrayExpressible
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
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     */
    protected int $fakeCount = 0;

    /**
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     */
    protected int $realCount = 0;

    /**
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     */
    protected int $matchCount = 0;

    /**
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     */
    protected int $todayRealCount = 0;

    /**
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     */
    protected int $todayFakeCount = 0;

    /**
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     */
    protected int $todayMatchCount = 0;

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

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getFakeCount(): int
    {
        return $this->fakeCount;
    }

    public function setFakeCount(int $fakeCount): void
    {
        $this->fakeCount = $fakeCount;
    }

    public function getRealCount(): int
    {
        return $this->realCount;
    }

    public function setRealCount(int $realCount): void
    {
        $this->realCount = $realCount;
    }

    public function getTodayRealCount(): int
    {
        return $this->todayRealCount;
    }

    public function setTodayRealCount(int $todayRealCount): void
    {
        $this->todayRealCount = $todayRealCount;
    }

    public function getTodayFakeCount(): int
    {
        return $this->todayFakeCount;
    }

    public function setTodayFakeCount(int $todayFakeCount): void
    {
        $this->todayFakeCount = $todayFakeCount;
    }

    public function getMatchCount(): int
    {
        return $this->matchCount;
    }

    public function setMatchCount(int $matchCount): void
    {
        $this->matchCount = $matchCount;
    }

    public function getTodayMatchCount(): int
    {
        return $this->todayMatchCount;
    }

    public function setTodayMatchCount(int $todayMatchCount): void
    {
        $this->todayMatchCount = $todayMatchCount;
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
