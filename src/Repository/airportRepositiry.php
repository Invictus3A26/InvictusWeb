<?php

namespace App\Repository;

use App\Entity\Airport;
use App\Entity\Vols;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class airportRepositiry extends ServiceEntityRepository
{
    /**
     * @return void
     */

    public function __construct(PersistenceManagerRegistry $registry)
    {
        parent::__construct($registry, Airport::class);
    }
}
