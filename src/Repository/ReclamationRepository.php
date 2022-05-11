<?php

namespace App\Repository;

use App\Entity\Reclamation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reclamation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reclamation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reclamation[]    findAll()
 * @method Reclamation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamation::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Reclamation $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Reclamation $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


  

    // /**
    //  * @return Reclamation[] Returns an array of Reclamation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reclamation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


     /**
     * Recherche les Reclamations en fonction du formulaire
     * @return void
     */
    public function search($mot = null, $type = null){
        $query = $this->createQueryBuilder('a');

        if($mot != null){
            $query->Where('a.nom = :mot') ->setParameter('mot', $mot);

        }
        return $query->getQuery()->getResult();
    }

 



    public function barDep(){
        return $this->createQueryBuilder('r')
        ->select('count(r.id)')
        ->where('r.type LIKE :reclamation')
        ->setParameter('reclamation','bagage')
        ->getQuery()
        ->getSingleScalarResult();
    }

    public function barArr(){
        return $this->createQueryBuilder('r')
        ->select('count(r.id)')
        ->where('r.type LIKE :reclamation')
        ->setParameter('reclamation','diwana')
        ->getQuery()
        ->getSingleScalarResult();
    }

    public function findInput($value)
    {
        return $this->createQueryBuilder('r')
            ->Where('r.nom LIKE :nom')
            ->setParameter('nom', "%".$value."%")
            ->getQuery()
            ->getResult()
            ;
    }



  
}
