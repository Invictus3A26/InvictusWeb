<?php

namespace App\Repository;

use App\Entity\Bagage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bagage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bagage|null findOneBy(array $criteria, array $orderBy = null)
 * @method allBagage[]    findAll()
 * @method Bagage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BagageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bagage::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Bagage $entity, bool $flush = true): void
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
    public function remove(Bagage $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    /**
     * Recherche les compagnies en fonction du formulaire
     * @return void
     */
    public function search($mots = null, $type = null){
        $query = $this->createQueryBuilder('a');

        if($mots != null){
            $query->Where('MATCH_AGAINST(a.poids, a.dimension) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots);

        }
        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Bagage[] Returns an array of Bagage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bagage
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
