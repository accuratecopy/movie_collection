<?php

namespace App\Repository;

use App\Entity\TVShow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TVShow|null find($id, $lockMode = null, $lockVersion = null)
 * @method TVShow|null findOneBy(array $criteria, array $orderBy = null)
 * @method TVShow[]    findAll()
 * @method TVShow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TVShowRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TVShow::class);
    }

    // /**
    //  * @return TVShow[] Returns an array of TVShow objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TVShow
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
