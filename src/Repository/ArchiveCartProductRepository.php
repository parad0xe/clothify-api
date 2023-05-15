<?php

namespace App\Repository;

use App\Entity\ArchiveCartProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArchiveCartProduct>
 *
 * @method ArchiveCartProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArchiveCartProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArchiveCartProduct[]    findAll()
 * @method ArchiveCartProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArchiveCartProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArchiveCartProduct::class);
    }

    public function save(ArchiveCartProduct $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ArchiveCartProduct $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ArchiveCartProduct[] Returns an array of ArchiveCartProduct objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ArchiveCartProduct
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
