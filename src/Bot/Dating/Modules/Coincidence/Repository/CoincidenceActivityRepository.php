<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Coincidence\Repository;

use App\Bot\Dating\Data\Entity\CoincidenceActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CoincidenceActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoincidenceActivity::class);
    }

    public function remove(CoincidenceActivity $coincidence): void
    {
        $em = $this->getEntityManager();
        $em->remove($coincidence);
        $em->flush($coincidence);
    }

    public function save(CoincidenceActivity $coincidence): void
    {
        $em = $this->getEntityManager();
        $em->persist($coincidence);
        $em->flush($coincidence);
    }

    /**
     * оптимизировать.
     *
     * @return CoincidenceActivity[]
     */
    public function getAllByLastFiftyMinutes(): array
    {
        return $this
            ->createQueryBuilder('t')
            ->where('t.createdAt >= :interval')
            ->andWhere('t.createdAt <= :now')
            ->setParameters([
                'interval' => (new \DateTimeImmutable())->add(
                    new \DateInterval('30m')
                ), // minuse 30min
                'now' => new \DateTimeImmutable(),
            ])
            ->orderBy('t.createdAt', 'DESC')
            ->groupBy('t.groupBy')
            ->getQuery()
            ->getScalarResult();
    }

    /**
     * оптимизировать.
     *
     * @return CoincidenceActivity[]
     */
    public function getAllByLastMonth(): array
    {
        return $this
            ->createQueryBuilder('t')
            ->where('t.createdAt >= :interval')
            ->andWhere('t.createdAt <= :now')
            ->setParameters([
                'interval' => (new \DateTimeImmutable())->add(
                    new \DateInterval('1month')
                ), // minuse 1 month
                'now' => new \DateTimeImmutable(),
            ])
            ->orderBy('t.createdAt', 'DESC')
            ->groupBy('t.groupBy')
            ->getQuery()
            ->getScalarResult();
    }
}
