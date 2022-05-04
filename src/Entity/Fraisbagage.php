<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fraisbagage
 *
 * @ORM\Table(name="FraisBagage")
 * @ORM\Entity
 */
class Fraisbagage
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
     * @ORM\Column(name="poids", type="string", length=30, nullable=false)
     */
    private $poids;

    /**
     * @var string
     *
     * @ORM\Column(name="dimension", type="string", length=30, nullable=false)
     */
    private $dimension;

    /**
     * @var int
     *
     * @ORM\Column(name="tarifs_base", type="integer", nullable=false)
     */
    private $tarifsBase;

    /**
     * @var int
     *
     * @ORM\Column(name="tarifs_confort", type="integer", nullable=false)
     */
    private $tarifsConfort;

    /**
     * @var int
     *
     * @ORM\Column(name="montant", type="integer", nullable=false)
     */
    private $montant;


}
