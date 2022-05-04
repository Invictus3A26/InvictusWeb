<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Airport
 *
 * @ORM\Table(name="airport")
 * @ORM\Entity
 */
class Airport
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_aeroport", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAeroport;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_aeroport", type="string", length=500, nullable=false)
     */
    private $nomAeroport;

    /**
     * @var string
     *
     * @ORM\Column(name="ville_aeroport", type="string", length=500, nullable=false)
     */
    private $villeAeroport;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=500, nullable=false)
     */
    private $pays;


}
