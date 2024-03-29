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

    public function getCreatedProfileByCurrentTime(\DateTimeImmutable $time, bool $isFake): array
    {
        return $this
            ->createQueryBuilder('t')
            ->where('t.fake = :fake')
            ->setParameter('fake', $isFake)
            ->andWhere('t.createdAt >= :start_date')
            ->andWhere('t.createdAt <= :end_date')
            ->setParameter('start_date', $time->modify('00:00:00'))
            ->setParameter('end_date', $time->modify('23:59:59'))
            ->getQuery()
            ->getResult();
    }

    public function getCreatedProfileBySign(bool $isFake): array
    {
        return $this
            ->createQueryBuilder('t')
            ->andWhere('t.fake = :fake')
            ->setParameters(
                [
                    'fake' => $isFake,
                ]
            )
            ->getQuery()
            ->getResult();
    }

    public function getListForPrivateTemplate(array $param): array
    {
        return $this
            ->createQueryBuilder('t')
            ->where('t.city = :city')
            ->andWhere('t.tag = :tag')
            ->andWhere('t.couple = :couple')
            ->andWhere('t.gender = :gender')
            ->andWhere('t.age >= :start_age')
            ->andWhere('t.age <= :end_age')
            ->setParameters([
                'city' => $param['city'],
                'tag' => $param['tag'],
                'couple' => $param['gender'],
                'gender' => $param['couple'],
                'start_age' => $param['searchAgeDiapazone'][0],
                'end_age' => $param['searchAgeDiapazone'][1],
            ])
            ->orderBy('t.lastActivity', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getListForBaseTemplate(array $param): array
    {
        return $this
            ->createQueryBuilder('t')
            ->where('t.city = :city')
            ->andWhere('t.gender = :gender')
            ->andWhere('t.age >= :start_age')
            ->andWhere('t.age <= :end_age')
            ->setParameters([
                'city' => $param['city'],
                'gender' => $param['couple'],
                'start_age' => $param['searchAgeDiapazone'][0],
                'end_age' => $param['searchAgeDiapazone'][1],
            ])
            ->orderBy('t.lastActivity', 'DESC')
            ->getQuery()
            ->getResult();
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

    public function findByAffiliateCode(string $affiliateCode): ?Profile
    {
        return $this
            ->createQueryBuilder('a')
            ->where('a.affiliateCode = :affiliateCode')
            ->setParameters([
                'affiliateCode' => $affiliateCode,
            ])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
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
