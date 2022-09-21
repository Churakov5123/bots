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
            ->where('a.profile = :profile')
            ->setParameters([
                'profile' => $profile,
            ])
            ->getQuery()
            ->getResult();
    }

    public function remove(Image $image): void
    {
        $em = $this->getEntityManager();
        $em->remove($image);
        $em->flush($image);
    }

    public function save(Image $image): void
    {
        $em = $this->getEntityManager();
        $em->persist($image);
        $em->flush($image);
    }
}
