<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vols
 *
 * @ORM\Table(name="vols", indexes={@ORM\Index(name="id_comp", columns={"id_comp"}), @ORM\Index(name="id_escale", columns={"id_escale"}), @ORM\Index(name="type_avion", columns={"type_avion"}), @ORM\Index(name="id_aeroport", columns={"id_aeroport"})})
 * @ORM\Entity
 * @UniqueEntity("numVol")
 */
class Vols
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_vol", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     */
    private $idVol;

    /**
     * @var int
     * @Assert\NotBlank
     * @Assert\Positive
     * @ORM\Column(name="num_vol", type="integer", nullable=false,unique=true)
     */
    private $numVol;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Date
     * @ORM\Column(name="date_depart_vol", type="string", length=200, nullable=false)
     */
    private $dateDepartVol;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Date
     * @ORM\Column(name="date_arrive_vol", type="string", length=200, nullable=false)
     */
    private $dateArriveVol;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Time
     * @ORM\Column(name="heure_depart_vol", type="string", length=200, nullable=false)
     */
    private $heureDepartVol;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Time
     * @ORM\Column(name="heure_arrive_vol", type="string", length=200, nullable=false)
     */
    private $heureArriveVol;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="type_vol", type="string", length=200, nullable=false)
     */
    private $typeVol;

    /**
     * @var int
     * @Assert\NotBlank
     * @Assert\Positive
     * @Assert\LessThan(500)
     * @ORM\Column(name="nombrePassager_vol", type="integer", nullable=false)
     */
    private $nombrepassagerVol;

    /**
     * @var string
     * @Assert\NotBlank
     * 
     * @Assert\Time
     * @ORM\Column(name="duree_retard_vol", type="string", length=100, nullable=false)
     */
    private $dureeRetardVol;

    /**
     * @var bool
     * 
     * @ORM\Column(name="annulation_vol", type="boolean", nullable=false)
     */
    private $annulationVol;

    /**
     * @var \Compagnie
     * 
     * @ORM\ManyToOne(targetEntity="Compagnie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_comp", referencedColumnName="Code_IATA")
     * })
     */
    private $idComp;

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
     * Get the value of idVol
     *
     * @return  int
     */ 
    public function getIdVol()
    {
        return $this->idVol;
    }

    /**
     * Set the value of idVol
     *
     * @param  int  $idVol
     *
     * @return  self
     */ 
    public function setIdVol(int $idVol)
    {
        $this->idVol = $idVol;

        return $this;
    }

    /**
     * Get the value of numVol
     *
     * @return  int
     */ 
    public function getNumVol()
    {
        return $this->numVol;
    }

    /**
     * Set the value of numVol
     *
     * @param  int  $numVol
     *
     * @return  self
     */ 
    public function setNumVol(int $numVol)
    {
        $this->numVol = $numVol;

        return $this;
    }

    /**
     * Get the value of dateDepartVol
     *
     * @return  string
     */ 
    public function getDateDepartVol()
    {
        return $this->dateDepartVol;
    }

    /**
     * Set the value of dateDepartVol
     *
     * @param  string  $dateDepartVol
     *
     * @return  self
     */ 
    public function setDateDepartVol(string $dateDepartVol)
    {
        $this->dateDepartVol = $dateDepartVol;

        return $this;
    }

    /**
     * Get the value of dateArriveVol
     *
     * @return  string
     */ 
    public function getDateArriveVol()
    {
        return $this->dateArriveVol;
    }

    /**
     * Set the value of dateArriveVol
     *
     * @param  string  $dateArriveVol
     *
     * @return  self
     */ 
    public function setDateArriveVol(string $dateArriveVol)
    {
        $this->dateArriveVol = $dateArriveVol;

        return $this;
    }

    /**
     * Get the value of heureDepartVol
     *
     * @return  string
     */ 
    public function getHeureDepartVol()
    {
        return $this->heureDepartVol;
    }

    /**
     * Set the value of heureDepartVol
     *
     * @param  string  $heureDepartVol
     *
     * @return  self
     */ 
    public function setHeureDepartVol(string $heureDepartVol)
    {
        $this->heureDepartVol = $heureDepartVol;

        return $this;
    }

    /**
     * Get the value of heureArriveVol
     *
     * @return  string
     */ 
    public function getHeureArriveVol()
    {
        return $this->heureArriveVol;
    }

    /**
     * Set the value of heureArriveVol
     *
     * @param  string  $heureArriveVol
     *
     * @return  self
     */ 
    public function setHeureArriveVol(string $heureArriveVol)
    {
        $this->heureArriveVol = $heureArriveVol;

        return $this;
    }

    /**
     * Get the value of typeVol
     *
     * @return  string
     */ 
    public function getTypeVol()
    {
        return $this->typeVol;
    }

    /**
     * Set the value of typeVol
     *
     * @param  string  $typeVol
     *
     * @return  self
     */ 
    public function setTypeVol(string $typeVol)
    {
        $this->typeVol = $typeVol;

        return $this;
    }

    /**
     * Get the value of nombrepassagerVol
     *
     * @return  int
     */ 
    public function getNombrepassagerVol()
    {
        return $this->nombrepassagerVol;
    }

    /**
     * Set the value of nombrepassagerVol
     *
     * @param  int  $nombrepassagerVol
     *
     * @return  self
     */ 
    public function setNombrepassagerVol(int $nombrepassagerVol)
    {
        $this->nombrepassagerVol = $nombrepassagerVol;

        return $this;
    }

    /**
     * Get the value of dureeRetardVol
     *
     * @return  string
     */ 
    public function getDureeRetardVol()
    {
        return $this->dureeRetardVol;
    }

    /**
     * Set the value of dureeRetardVol
     *
     * @param  string  $dureeRetardVol
     *
     * @return  self
     */ 
    public function setDureeRetardVol(string $dureeRetardVol)
    {
        $this->dureeRetardVol = $dureeRetardVol;

        return $this;
    }

    /**
     * Get the value of annulationVol
     *
     * @return  bool
     */ 
    public function getAnnulationVol()
    {
        return $this->annulationVol;
    }

    /**
     * Set the value of annulationVol
     *
     * @param  bool  $annulationVol
     *
     * @return  self
     */ 
    public function setAnnulationVol(bool $annulationVol)
    {
        $this->annulationVol = $annulationVol;

        return $this;
    }

    /**
     * Get the value of idComp
     *
     * @return  \Compagnie
     */ 
    public function getIdComp()
    {
        return $this->idComp;
    }

    /**
     * Set the value of idComp
     *
     * @param  \Compagnie  $idComp
     *
     * @return  self
     */ 
    public function setIdComp(Compagnie $idComp)
    {
        $this->idComp = $idComp;

        return $this;
    }

    /**
     * Get the value of typeAvion
     *
     * @return  \Avion
     */ 
    public function getTypeAvion()
    {
        return $this->typeAvion;
    }

    /**
     * Set the value of typeAvion
     *
     * @param  \Avion  $typeAvion
     *
     * @return  self
     */ 
    public function setTypeAvion(Avion $typeAvion)
    {
        $this->typeAvion = $typeAvion;

        return $this;
    }

    /**
     * Get the value of idAeroport
     *
     * @return  \Airport
     */ 
    public function getIdAeroport()
    {
        return $this->idAeroport;
    }

    /**
     * Set the value of idAeroport
     *
     * @param  \Airport  $idAeroport
     *
     * @return  self
     */ 
    public function setIdAeroport(Airport $idAeroport)
    {
        $this->idAeroport = $idAeroport;

        return $this;
    }

    /**
     * Get the value of idEscale
     *
     * @return  \Escale
     */ 
    public function getIdEscale()
    {
        return $this->idEscale;
    }

    /**
     * Set the value of idEscale
     *
     * @param  \Escale  $idEscale
     *
     * @return  self
     */ 
    public function setIdEscale(Escale $idEscale)
    {
        $this->idEscale = $idEscale;

        return $this;
    }
}
