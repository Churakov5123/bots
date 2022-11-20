<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Coincidence\Repository;

use App\Bot\Dating\Data\Entity\Coincidence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CoincidenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coincidence::class);
    }

    public function remove(Coincidence $coincidence): void
    {
        $em = $this->getEntityManager();
        $em->remove($coincidence);
        $em->flush($coincidence);
    }

    public function save(Coincidence $coincidence): void
    {
        $em = $this->getEntityManager();
        $em->persist($coincidence);
        $em->flush($coincidence);
    }
}
