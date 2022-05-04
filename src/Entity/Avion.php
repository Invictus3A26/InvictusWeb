<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avion
 *
 * @ORM\Table(name="avion", indexes={@ORM\Index(name="Fk_CA", columns={"CodeC"})})
 * @ORM\Entity
 */
class Avion
{
    /**
     * @var string
     *
     * @ORM\Column(name="CodeAvion", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeavion;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeA", type="string", length=50, nullable=false)
     */
    private $typea;

    /**
     * @var string
     *
     * @ORM\Column(name="Model", type="string", length=50, nullable=false)
     */
    private $model;

    /**
     * @var float
     *
     * @ORM\Column(name="PassagerN", type="float", precision=10, scale=0, nullable=false)
     */
    private $passagern;

    /**
     * @var \Compagnie
     *
     * @ORM\ManyToOne(targetEntity="Compagnie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeC", referencedColumnName="Code_IATA")
     * })
     */
    private $codec;


}
