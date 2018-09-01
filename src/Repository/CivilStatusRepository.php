<?php

namespace App\Repository;

use App\Entity\CivilStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CivilStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method CivilStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method CivilStatus[]    findAll()
 * @method CivilStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CivilStatusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CivilStatus::class);
    }

//    /**
//     * @return CivilStatus[] Returns an array of CivilStatus objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CivilStatus
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
