<?php

namespace App\Repository;

use App\Entity\DescriptSite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DescriptSite|null find($id, $lockMode = null, $lockVersion = null)
 * @method DescriptSite|null findOneBy(array $criteria, array $orderBy = null)
 * @method DescriptSite[]    findAll()
 * @method DescriptSite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DescriptSiteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DescriptSite::class);
    }

    // /**
    //  * @return DescriptSite[] Returns an array of DescriptSite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DescriptSite
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
