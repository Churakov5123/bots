<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Statistic\Repository;

use App\Bot\Dating\Data\Entity\Statistic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StatisticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Statistic::class);
    }

    public function getStatisticByCurrentTime(\DateTimeImmutable $time): ?Statistic
    {
        return $this
            ->createQueryBuilder('t')
            ->andWhere('t.createdAt >= :start_date')
            ->andWhere('t.createdAt <= :end_date')
            ->setParameters(
                [
                    'start_date', $time->modify('00:00:00'),
                    'end_date', $time->modify('23:59:59'),
                ]
            )
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function remove(Statistic $statistic): void
    {
        $em = $this->getEntityManager();
        $em->remove($statistic);
        $em->flush($statistic);
    }

    public function save(Statistic $statistic): void
    {
        $em = $this->getEntityManager();
        $em->persist($statistic);
        $em->flush($statistic);
    }
}
