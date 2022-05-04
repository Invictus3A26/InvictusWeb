<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Compagnie
 *
 * @ORM\Table(name="compagnie")
 * @ORM\Entity
 */
class Compagnie
{
    /**
     * @var string
     *
     * @ORM\Column(name="Code_IATA", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeIata;

    /**
     * @var string
     *
     * @ORM\Column(name="NomCom", type="string", length=50, nullable=false)
     */
    private $nomcom;

    /**
     * @var string
     *
     * @ORM\Column(name="Link", type="string", length=50, nullable=false)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="Pays", type="string", length=50, nullable=false)
     */
    private $pays;

    /**
     * @var int
     *
     * @ORM\Column(name="Number", type="integer", nullable=false)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="Siege", type="string", length=50, nullable=false)
     */
    private $siege;

    /**
     * @var string
     *
     * @ORM\Column(name="AeBase", type="string", length=50, nullable=false)
     */
    private $aebase;

    /**
     * @var float
     *
     * @ORM\Column(name="PassagerNum", type="float", precision=10, scale=0, nullable=false)
     */
    private $passagernum;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     */
    private $description;


}
