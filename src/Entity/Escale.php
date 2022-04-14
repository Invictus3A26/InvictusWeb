<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Escale
 *
 * @ORM\Table(name="escale", indexes={@ORM\Index(name="aeroport_destination", columns={"aeroport_destination"}), @ORM\Index(name="aeroport_depart", columns={"aeroport_depart"})})
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
     * @Assert\NotBlank(message="heure arrivé escale doir étre remplie")
     *@Assert\Time
     * @ORM\Column(name="heureArriveEscale", type="string", length=50, nullable=false)
     */
    private $heurearriveescale;

    /**
     * @var string A "H:i" formatted value
     * @Assert\Time
     * 
     * 
     * @Assert\NotBlank(message="heure depart escale doit etre remplie")
     *
     * @ORM\Column(name="heureDepartEscale", type="string", length=50, nullable=false)
     */
    private $heuredepartescale;

    /**
     * @var string
     * @Assert\Time
     *@Assert\NotBlank(message="durée escaledoir étre remplie")
     * @ORM\Column(name="duree", type="string", length=50, nullable=false)
     */
    private $duree;

    /**
     * @var \Airport
     *
     * @ORM\ManyToOne(targetEntity="Airport")
     * 
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aeroport_destination", referencedColumnName="id_aeroport")
     * })
     */
    private $aeroportDestination;

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
     * Get the value of idEscale
     *
     * @return  int
     */ 
    public function getIdEscale()
    {
        return $this->idEscale;
    }

    /**
     * Set the value of idEscale
     *
     * @param  int  $idEscale
     *
     * @return  self
     */ 
    public function setIdEscale(int $idEscale)
    {
        $this->idEscale = $idEscale;

        return $this;
    }

    /**
     * Get the value of aeroportDepart
     *
     * @return  \Airport
     */ 
    public function getAeroportDepart()
    {
        return $this->aeroportDepart;
    }

    /**
     * Set the value of aeroportDepart
     *
     * @param  \Airport  $aeroportDepart
     *
     * @return  self
     */ 
    public function setAeroportDepart(Airport $aeroportDepart)
    {
        $this->aeroportDepart = $aeroportDepart;

        return $this;
    }

    /**
     * Get the value of aeroportDestination
     *
     * @return  \Airport
     */ 
    public function getAeroportDestination()
    {
        return $this->aeroportDestination;
    }

    /**
     * Set the value of aeroportDestination
     *
     * @param  \Airport  $aeroportDestination
     *
     * @return  self
     */ 
    public function setAeroportDestination(Airport $aeroportDestination)
    {
        $this->aeroportDestination = $aeroportDestination;

        return $this;
    }

    /**
     * Get the value of duree
     *
     * @return  string
     */ 
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set the value of duree
     *
     * @param  string  $duree
     *
     * @return  self
     */ 
    public function setDuree(string $duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get the value of heurearriveescale
     *
     * @return  string
     */ 
    public function getHeurearriveescale()
    {
        return $this->heurearriveescale;
    }

    /**
     * Set the value of heurearriveescale
     *
     * @param  string  $heurearriveescale
     *
     * @return  self
     */ 
    public function setHeurearriveescale(string $heurearriveescale)
    {
        $this->heurearriveescale = $heurearriveescale;

        return $this;
    }

    /**
     * Get the value of heuredepartescale
     *
     * @return  string
     */ 
    public function getHeuredepartescale()
    {
        return $this->heuredepartescale;
    }

    /**
     * Set the value of heuredepartescale
     *
     * @param  string  $heuredepartescale
     *
     * @return  self
     */ 
    public function setHeuredepartescale(string $heuredepartescale)
    {
        $this->heuredepartescale = $heuredepartescale;

        return $this;
    }
}
