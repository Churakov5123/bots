<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Statistic\Repository;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Data\Entity\Statistic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StatisticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Statistic::class);
    }

    public function remove(Profile $profile): void
    {
        $em = $this->getEntityManager();
        $em->remove($profile);
        $em->flush($profile);
    }

    public function save(Profile $profile): void
    {
        $em = $this->getEntityManager();
        $em->persist($profile);
        $em->flush($profile);
    }
}
