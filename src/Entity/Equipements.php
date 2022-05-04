<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipements
 *
 * @ORM\Table(name="equipements", indexes={@ORM\Index(name="fk", columns={"id_departement"})})
 * @ORM\Entity
 */
class Equipements
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
     * @ORM\Column(name="typeEquipement", type="string", length=30, nullable=false)
     */
    private $typeequipement;

    /**
     * @var string
     *
     * @ORM\Column(name="nomEquipement", type="string", length=30, nullable=false)
     */
    private $nomequipement;

    /**
     * @var string
     *
     * @ORM\Column(name="detailEquipement", type="string", length=30, nullable=false)
     */
    private $detailequipement;

    /**
     * @var string
     *
     * @ORM\Column(name="zoneEquipement", type="string", length=30, nullable=false)
     */
    private $zoneequipement;

    /**
     * @var string
     *
     * @ORM\Column(name="etatEquipement", type="string", length=30, nullable=false)
     */
    private $etatequipement;

    /**
     * @var \Departement
     *
     * @ORM\ManyToOne(targetEntity="Departement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_departement", referencedColumnName="id")
     * })
     */
    private $idDepartement;


}
