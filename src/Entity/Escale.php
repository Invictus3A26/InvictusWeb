<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Escale
 *
 * @ORM\Table(name="escale", indexes={@ORM\Index(name="escale1", columns={"aeroport_depart"}), @ORM\Index(name="escale2", columns={"aeroport_destination"})})
 * @ORM\Entity
 */
class Escale
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_escale", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEscale;

    /**
     * @var string
     *
     * @ORM\Column(name="heureArriveEscale", type="string", length=50, nullable=false)
     */
    private $heurearriveescale;

    /**
     * @var string
     *
     * @ORM\Column(name="heureDepartEscale", type="string", length=50, nullable=false)
     */
    private $heuredepartescale;

    /**
     * @var string
     *
     * @ORM\Column(name="durée", type="string", length=50, nullable=false)
     */
    private $durée;

    /**
     * @var \Airport
     *
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aeroport_depart", referencedColumnName="id_aeroport")
     * })
     */
    private $aeroportDepart;

    /**
     * @var \Airport
     *
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aeroport_destination", referencedColumnName="id_aeroport")
     * })
     */
    private $aeroportDestination;


}
