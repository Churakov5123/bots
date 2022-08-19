<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Repository;

use App\Bot\Dating\Data\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profile::class);
    }

    public function getProfileByLogin(string $login): ?Profile
    {
        return $this
            ->createQueryBuilder('a')
            ->where('a.login = :login')
            ->setParameters([
                'login' => $login,
            ])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(Profile $group): void
    {
        $em = $this->getEntityManager();
        $em->persist($group);
        $em->flush($group);
    }
}
