<?php

namespace App\Repository;

use App\Entity\Gite;
use App\Entity\GiteSearch;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Gite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gite[]    findAll()
 * @method Gite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gite::class);
    }

    /**
     * @return Gite[] Returns an array of Gite objects
     */
    public function findLastGite()
    {
        return $this->createQueryBuilder('g')
            ->orderBy('g.created_at', 'DESC')
            ->setMaxResults(9)
            ->getQuery()
            ->getResult();
    }
    public function findAllGiteSearch(GiteSearch $search): array
    {
        $query = $this->createQueryBuilder('g');
        if ($search->getMinSurface()) {
            $query = $query
                ->andWhere('g.surface > :minsurface')
                ->setParameter('minsurface', $search->getMinSurface());
        }
        if ($search->getMaxBedrooms()) {
            $query = $query
                ->andWhere('g.bedrooms < :maxBedrooms')
                ->setParameter('maxBedrooms', $search->getMaxBedrooms());
        }
        if ($search->getCity()) {
            $query = $query

                ->andWhere('g.city = :city')
                ->setParameter('city', $search->getCity());
        }

        return $query->getQuery()->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Gite
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
