<?php

namespace App\Repository;

use App\Entity\Avion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Avion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avion[]    findAll()
 * @method Avion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avion::class);
    }
    /**
     * Recherche les compagnies en fonction du formulaire
     * @return void
     */
    public function search($mots = null, $type = null){
        $query = $this->createQueryBuilder('a');

        if($mots != null){
            $query->Where('MATCH_AGAINST(a.CodeAvion) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots);

        }
        return $query->getQuery()->getResult();
    }


    /**
    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Avion $entity, bool $flush = true): void
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
    public function remove(Avion $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Avion[] Returns an array of Avion objects
    //  */
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
    public function findOneBySomeField($value): ?Avion
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
