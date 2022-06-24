<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Repository;

use App\Bot\Dating\Data\Entity\Profile;
use Doctrine\ORM\EntityRepository;

class ProfileRepository extends EntityRepository
{
    public function save(Profile $group): void
    {
        $em = $this->getEntityManager();
        $em->persist($group);
        $em->flush($group);
    }
}
