<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Image\Repository;

use App\Bot\Dating\Data\Entity\Image;
use App\Bot\Dating\Data\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function getImagesByProfile(Profile $profile): array
    {
        return $this
            ->createQueryBuilder('a')
            ->where('a.profile_id = :profile_id')
            ->setParameters([
                'profile_id' => $profile,
            ])
            ->getQuery()
            ->getResult();
    }

    public function save(Image $group): void
    {
        $em = $this->getEntityManager();
        $em->persist($group);
        $em->flush($group);
    }
}
