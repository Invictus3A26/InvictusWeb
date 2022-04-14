<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Compagnie
 *
 * @ORM\Table(name="compagnie", indexes={@ORM\Index(name="aeroport_compagnie", columns={"id_aeroport"})})
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
     * @var float
     *
     * @ORM\Column(name="PoidsM", type="float", precision=10, scale=0, nullable=false)
     */
    private $poidsm;

    /**
     * @var float
     *
     * @ORM\Column(name="PoidsS", type="float", precision=10, scale=0, nullable=false)
     */
    private $poidss;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     */
    private $description;

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
     * Get the value of codeIata
     *
     * @return  string
     */ 
    public function getCodeIata()
    {
        return $this->codeIata;
    }

    /**
     * Set the value of codeIata
     *
     * @param  string  $codeIata
     *
     * @return  self
     */ 
    public function setCodeIata(string $codeIata)
    {
        $this->codeIata = $codeIata;

        return $this;
    }

    /**
     * Get the value of nomcom
     *
     * @return  string
     */ 
    public function getNomcom()
    {
        return $this->nomcom;
    }

    /**
     * Set the value of nomcom
     *
     * @param  string  $nomcom
     *
     * @return  self
     */ 
    public function setNomcom(string $nomcom)
    {
        $this->nomcom = $nomcom;

        return $this;
    }
}
