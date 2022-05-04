<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bagage
 *
 * @ORM\Table(name="Bagage", indexes={@ORM\Index(name="id_userr", columns={"id_userr"})})
 * @ORM\Entity
 */
class Bagage
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
     * @ORM\Column(name="poidsM", type="string", length=30, nullable=false)
     */
    private $poidsm;

    /**
     * @var string
     *
     * @ORM\Column(name="poidsS", type="string", length=30, nullable=false)
     */
    private $poidss;

    /**
     * @var string
     *
     * @ORM\Column(name="dimension", type="string", length=30, nullable=false)
     */
    private $dimension;

    /**
     * @var int
     *
     * @ORM\Column(name="num_valise", type="integer", nullable=false)
     */
    private $numValise;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_userr", referencedColumnName="id")
     * })
     */
    private $idUserr;


}
