<?php

namespace App\Repository;

use App\Entity\VinylMix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VinylMix>
 */
class VinylMixRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VinylMix::class);
    }

    /**
     * @return VinylMix[] Returns an array of VinylMix objects
     */
    public function findAllOrderedByVotes(string $genre = null): array
    {
        $queryBuilder = $this->addOrderByVotesQueryBuilder();

        if($genre){
            $queryBuilder->andWhere('mix.genre = :genre')
            ->setParameter('genre', $genre);
        }


        return $queryBuilder
            ->getQuery()
            ->getResult();
    }


    private function addOrderByVotesQueryBuilder(QueryBuilder $builder =  null) : QueryBuilder
    {
        $builder = $builder ?? $this->createQueryBuilder('mix');

        return $builder->orderBy('mix.votes', 'DESC');

    }

    //    public function findOneBySomeField($value): ?VinylMix
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
