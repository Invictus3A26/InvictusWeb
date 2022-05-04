<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vols
 *
 * @ORM\Table(name="vols", uniqueConstraints={@ORM\UniqueConstraint(name="num_vol", columns={"num_vol"})}, indexes={@ORM\Index(name="vol2", columns={"id_comp"}), @ORM\Index(name="vol3", columns={"id_escale"}), @ORM\Index(name="vol4", columns={"type_avion"}), @ORM\Index(name="vol1", columns={"id_aeroport"})})
 * @ORM\Entity
 */
class Vols
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_vol", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idVol;

    /**
     * @var int
     *
     * @ORM\Column(name="num_vol", type="integer", nullable=false)
     */
    private $numVol;

    /**
     * @var string
     *
     * @ORM\Column(name="date_depart_vol", type="string", length=200, nullable=false)
     */
    private $dateDepartVol;

    /**
     * @var string
     *
     * @ORM\Column(name="date_arrivé_vol", type="string", length=200, nullable=false)
     */
    private $dateArrivéVol;

    /**
     * @var string
     *
     * @ORM\Column(name="heure_depart_vol", type="string", length=200, nullable=false)
     */
    private $heureDepartVol;

    /**
     * @var string
     *
     * @ORM\Column(name="heure_arrivé_vol", type="string", length=200, nullable=false)
     */
    private $heureArrivéVol;

    /**
     * @var string
     *
     * @ORM\Column(name="type_vol", type="string", length=200, nullable=false)
     */
    private $typeVol;

    /**
     * @var int
     *
     * @ORM\Column(name="nombrePassager_vol", type="integer", nullable=false)
     */
    private $nombrepassagerVol;

    /**
     * @var string
     *
     * @ORM\Column(name="durée_retard_vol", type="string", length=100, nullable=false)
     */
    private $duréeRetardVol;

    /**
     * @var bool
     *
     * @ORM\Column(name="annulation_vol", type="boolean", nullable=false)
     */
    private $annulationVol;

    /**
     * @var \Avion
     *
     * @ORM\ManyToOne(targetEntity="Avion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_avion", referencedColumnName="CodeAvion")
     * })
     */
    private $typeAvion;

    /**
     * @var \Airport
     *
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_aeroport", referencedColumnName="id_aeroport")
     * })
     */
    private $idAeroport;

    /**
     * @var \Escale
     *
     * @ORM\ManyToOne(targetEntity="Escale")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_escale", referencedColumnName="id_escale")
     * })
     */
    private $idEscale;

    /**
     * @var \Compagnie
     *
     * @ORM\ManyToOne(targetEntity="Compagnie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_comp", referencedColumnName="Code_IATA")
     * })
     */
    private $idComp;


}
