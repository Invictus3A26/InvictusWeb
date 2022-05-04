<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departement
 *
 * @ORM\Table(name="departement")
 * @ORM\Entity
 */
class Departement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomDepartement", type="string", length=30, nullable=false)
     */
    private $nomdepartement;

    /**
     * @var string
     *
     * @ORM\Column(name="zoneDepartement", type="string", length=30, nullable=false)
     */
    private $zonedepartement;

    /**
     * @var string
     *
     * @ORM\Column(name="detailDepartement", type="string", length=30, nullable=false)
     */
    private $detaildepartement;


}
