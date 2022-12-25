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
                'interval' => (new \DateTimeImmutable())->sub(
                    new \DateInterval('P0Y0DT0H15M')
                ),
                'now' => new \DateTimeImmutable(),
            ])
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
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
                'interval' => (new \DateTimeImmutable())->sub(
                    new \DateInterval('P0Y01M0DT0H0M')
                ),
                'now' => new \DateTimeImmutable(),
            ])
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
