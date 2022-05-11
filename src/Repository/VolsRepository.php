<?php
namespace App\Repository;

use App\Entity\Vols;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class VolsRepository extends ServiceEntityRepository
{
/**
 * @return void
 */

public function __construct(PersistenceManagerRegistry $registry)
{
    parent::__construct($registry, Vols::class);
}

public function search($mot){
    $query = $this->createQueryBuilder('a');
    $query->where('a.typeVol = :mot ')->setParameter('mot',$mot);
    return $query->getQuery()->getResult();
}



/** 
 * @return void
 */


public function barDep(){
    return $this->createQueryBuilder('u')
    ->select('count(u.idVol)')
    ->where('u.typeVol LIKE :Vol ')
    ->setParameter('Vol','Depart')
    ->getQuery()
    ->getSingleScalarResult();
}



/** 
 * @return void
 */


public function sumDep(){
    return $this->createQueryBuilder('u')
    ->select('sum(u.nombrepassagerVol)')
    ->where('u.typeVol LIKE :Vol ')
    ->setParameter('Vol','Depart')
    ->getQuery()
    ->getSingleScalarResult();
}


/** 
 * @return void
 */


public function barArr(){
    return $this->createQueryBuilder('u')
    ->select('count(u.idVol)')
    ->where('u.typeVol LIKE :Vol ')
    ->setParameter('Vol','Arrivé')
    ->getQuery()
    ->getSingleScalarResult();
}

public function sumArr(){
    return $this->createQueryBuilder('u')
    ->select('sum(u.nombrepassagerVol)')
    ->where('u.typeVol LIKE :Vol ')
    ->setParameter('Vol','Arrivé')
    ->getQuery()
    ->getSingleScalarResult();
}




}