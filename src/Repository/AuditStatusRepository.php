<?php

namespace App\Repository;

use App\Entity\AuditStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AuditStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuditStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuditStatus[]    findAll()
 * @method AuditStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuditStatusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AuditStatus::class);
    }

//    /**
//     * @return AuditStatus[] Returns an array of AuditStatus objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AuditStatus
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
