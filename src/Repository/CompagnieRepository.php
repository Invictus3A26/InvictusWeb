<?php

namespace App\Repository;

use App\Entity\Compagnie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Compagnie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Compagnie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Compagnie[]    findAll()
 * @method Compagnie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompagnieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Compagnie::class);
    }
    /**
     * Recherche les compagnies en fonction du formulaire
     * @return void
     */
    public function search($mots = null, $type = null){
        $query = $this->createQueryBuilder('a');

        if($mots != null){
            $query->Where('MATCH_AGAINST(a.Code_IATA, a.NomCom) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots);

        }
        return $query->getQuery()->getResult();
    }


    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Compagnie $entity, bool $flush = true): void
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
    public function remove(Compagnie $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Compagnie[] Returns an array of Compagnie objects
    //  */
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
    public function findOneBySomeField($value): ?Compagnie
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
