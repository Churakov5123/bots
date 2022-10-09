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

    public function getListByParams(array $param, int $limit): array
    {
        $query = $this
            ->createQueryBuilder('t');

        if (isset($param['city'])) {
            $query
                ->andwhere('t.city = :city')
                ->setParameters([
                    'city' => $param['city'],
                ]);
        }

//        Пока без платформы. Неимеет смысл сразу писать на все платформы пока не работет нормально хотябы одна

//        if (isset($param['platform'])) {
//            $query
//                ->where('t.platform = :platform')
//                ->setParameters([
//                    'platform' => $param['platform']
//                ]);
//        }
//     Режимы поиска тоже поскольку - в идеале нужно прорабатывать каждый режим поиск отдельно!!! в одтельным клссом
//        if (isset($param['searchMode'])) {
//            $query
//                ->where('t.searchMode = :searchMode')
//                ->setParameters([
//                    'searchMode' => $param['searchMode']
//                ]);
//        }

        if (isset($param['tag'])) {
            $query
                ->andwhere('t.tag = :tag')
                ->setParameters([
                    'tag' => $param['tag'],
                ]);
        }

        if (isset($param['couple'])) {
            $query
                ->andwhere('t.gender = :gender')
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
            ->setMaxResults($limit)
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
