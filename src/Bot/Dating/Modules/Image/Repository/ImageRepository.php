<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Image\Repository;

use App\Bot\Dating\Data\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function save(Image $group): void
    {
        $em = $this->getEntityManager();
        $em->persist($group);
        $em->flush($group);
    }
}
