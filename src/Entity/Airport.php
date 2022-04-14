<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Airport
 *
 * @ORM\Table(name="airport")
 * @ORM\Entity
 * @UniqueEntity("nomAeroport")
 */
class Airport
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_aeroport", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAeroport;

    /**
     * 
     * @Assert\NotBlank(message="nom aeroport doir étre remplie")
     * 
     * 
     * @var string
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "Your aeroport name must be at least 5 characters long",
     *      maxMessage = "Your first name cannot be longer than 50 characters"
     * )
     * 
     * @ORM\Column(name="nom_aeroport", type="string", length=500, nullable=false,unique=true)
     */
    private $nomAeroport;

    /**
     * @var string
     * @Assert\NotBlank(message="ville aeroport doir étre remplie")
     *
     * @ORM\Column(name="ville_aeroport", type="string", length=500, nullable=false)
     */
    private $villeAeroport;

    /**
     * @var string
     *@Assert\Country
     * @Assert\NotBlank(message="pays doir étre remplie")
     * @ORM\Column(name="pays", type="string", length=500, nullable=false)
     */
    private $pays;



    /**
     * Get the value of idAeroport
     *
     * @return  int
     */ 
    public function getIdAeroport()
    {
        return $this->idAeroport;
    }

    /**
     * Set the value of idAeroport
     *
     * @param  int  $idAeroport
     *
     * @return  self
     */ 
    public function setIdAeroport(int $idAeroport)
    {
        $this->idAeroport = $idAeroport;

        return $this;
    }

    /**
     * Get the value of nomAeroport
     *
     * @return  string
     */ 
    public function getNomAeroport()
    {
        return $this->nomAeroport;
    }

    /**
     * Set the value of nomAeroport
     *
     * @param  string  $nomAeroport
     *
     * @return  self
     */ 
    public function setNomAeroport(string $nomAeroport)
    {
        $this->nomAeroport = $nomAeroport;

        return $this;
    }

    /**
     * Get the value of villeAeroport
     *
     * @return  string
     */ 
    public function getVilleAeroport()
    {
        return $this->villeAeroport;
    }

    /**
     * Set the value of villeAeroport
     *
     * @param  string  $villeAeroport
     *
     * @return  self
     */ 
    public function setVilleAeroport(string $villeAeroport)
    {
        $this->villeAeroport = $villeAeroport;

        return $this;
    }

    /**
     * Get the value of pays
     *
     * @return  string
     */ 
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set the value of pays
     *
     * @param  string  $pays
     *
     * @return  self
     */ 
    public function setPays(string $pays)
    {
        $this->pays = $pays;

        return $this;
    }
}
