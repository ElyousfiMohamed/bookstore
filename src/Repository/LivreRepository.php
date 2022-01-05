<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    // /**
    //  * @return Livre[] Returns an array of Livre objects
    //  */
    public function findByTitre($value,$note,$inf,$sup)
    {
        if(empty($inf)){
            $inf=1900;
        }
        
        if(empty($sup)){
            $sup=2020;
        }

        if(empty($note)){
            $note=0;
        }


        $inf=$inf."-1-1";
        $sup=$sup."-1-1";

        return $this->createQueryBuilder('l')
            ->andWhere('l.titre like :val')
            ->andWhere('l.date_de_parution BETWEEN :inf AND :sup')
            ->andWhere('l.note > :noteMin')
            ->setParameter('val', "%".$value."%")
            ->setParameter('inf', $inf)
            ->setParameter('sup', $sup)
            ->setParameter('noteMin', $note)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
