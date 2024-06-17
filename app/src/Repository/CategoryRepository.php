<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function save(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findAllOrder(): array
    {
//        $dql = 'SELECT category FROM App\Entity\Category as category ORDER BY category.name ASC';

        $qb = $this->addGroupByCategoryAndCountFortunes()
            ->addOrderBy('category.name', Criteria::ASC);

        $query = $qb->getQuery();


        return $query->getResult();
    }


    private function addGroupByCategoryAndCountFortunes(QueryBuilder $qB = null): QueryBuilder
    {
        return ($qB ?? $this->createQueryBuilder('category'))
            ->addSelect('COUNT (fortuneCookie.id) AS fortuneCookiesTotal')
            ->leftJoin('category.fortuneCookies', 'fortuneCookie')
            ->addGroupBy('category.id');
    }

    /**
     * @return Category[]
     */
    public function search(string $term): array
    {
        $termList = explode(' ', $term);
        $qB = $this->addOrderByCategoryName();

        return $this->addGroupByCategoryAndCountFortunes($qB)
            ->andWhere('category.name LIKE :searchTerm OR category.name IN (:termList) OR category.iconKey LIKE :searchTerm OR fortuneCookie.fortune LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $term . '%')
            ->setParameter('termList', $termList)
            ->getQuery()
            ->getResult();
    }


    public function findWithFortunesJoin(int $id): ?Category
    {

        return $this->addFortuneCookieJoinAndSelect()
            ->andWhere('category.id = :id')
            ->setParameter('id', $id)
            ->orderBy('RAND()', Criteria::ASC)
            ->getQuery()
            ->getOneOrNullResult();
    }


    private function addFortuneCookieJoinAndSelect(QueryBuilder $qB = null): QueryBuilder
    {
        return ($qB ?? $this->createQueryBuilder('category'))->addSelect('fortuneCookie')
            ->leftJoin('category.fortuneCookies', 'fortuneCookie');

    }

    private function addOrderByCategoryName(QueryBuilder $qB = null): QueryBuilder
    {
        return ($qB ?? $this->createQueryBuilder('category'))
            ->addOrderBy('category.name', Criteria::ASC);
    }
//    /**
//     * @return Category[] Returns an array of Category objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Category
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
