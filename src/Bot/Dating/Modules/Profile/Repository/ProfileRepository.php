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

    /**
     * Точечный приватный поиск по тегу (совпадению пары и тега).
     */
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

    /**
     * Базовый поиск.
     *
     * @param array $param
     *
     * @return array
     */
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

    public function getListByParams(array $param): array
    {
        $query = $this
            ->createQueryBuilder('t');

        if (isset($param['city'])) {
            $query
                ->Where('t.city = :city')
                ->setParameters([
                    'city' => $param['city'],
                ]);
        }

        if (isset($param['platform'])) {  // пока одна платформа
            $query
                ->andWhere('t.platform = :platform')
                ->setParameters([
                    'platform' => $param['platform'],
                ]);
        }

        if (isset($param['searchMode'])) {
            $query
                ->andWhere('t.searchMode = :searchMode')
                ->setParameters([
                    'searchMode' => $param['searchMode'],
                ]);
        }

        if (isset($param['tag'])) {
            $query
                ->Where('t.tag = :tag')
                ->setParameters([
                    'tag' => $param['tag'],
                ]);
        }

        if (isset($param['couple'])) {
            $query
                ->Where('t.gender = :gender')
                ->setParameters([
                    'gender' => $param['couple'],
                ]);
        }

        if (isset($param['searchAgeDiapazone'])) {
            $query
                ->andWhere('t.age >= :start_age')
                ->andWhere('t.age <= :end_age')
                ->setParameter('start_age', $param['searchAgeDiapazone'][0])
                ->setParameter('end_age', $param['searchAgeDiapazone'][1]);
        }

        return $query
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
