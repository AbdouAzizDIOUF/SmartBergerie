<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Users::class);
    }


    public function findFinAdmin($role)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.roles =:roles')
            ->setParameter('roles', $role)
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Users[] Returns an array of Users objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Users
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    /**
     * @return Users[]
     */
    public function findAdmin(): array
    {
        return $this->findVisibleQueryAdministrateurs()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Users[]
     */
    public function findClient(): array
    {
        return $this->findVisibleQueryClients()
            ->getQuery()
            ->getResult();
    }

    /**
     * findVisibleQueryAdministrateurs selection des elements ayant solde a false
     * @return QueryBuilder
     */
    private function findVisibleQueryAdministrateurs(): QueryBuilder
    {
        return $this->createQueryBuilder('admin') //cree la requete et lui attribue un alliase "p"
        ->where('admin.roles <> ROLE_USER');
    }

    /**
     * findVisibleQueryAdministrateurs selection des elements ayant solde a false
     * @return QueryBuilder
     */
    private function findVisibleQueryClients(): QueryBuilder
    {
        return $this->createQueryBuilder('client') //cree la requete et lui attribue un alliase "p"
        ->where('client.roles = ROLE_USER');
    }
}
