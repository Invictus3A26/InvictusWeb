<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Departement
 *
 * @ORM\Table(name="departement")
 * @ORM\Entity
 */
class Departement
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
     * @Assert\NotBlank(message="nom departement doir étre remplie")
     * @Assert\Type("string",message="la valeur {{ value }} doit etre string {{ type }}.")
     * @Assert\Length(
     *      min = 4,
     *      max = 10,
     *      minMessage = "nom equipement doit depassée {{ limit }} characters",
     *      maxMessage = "nom equipement ne deppase pas {{ limit }} characters"
     * )
     * @ORM\Column(name="nomDepartement", type="string", length=30, nullable=false)
     */
    private $nomdepartement;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="zone departement doir étre remplie")
     * 
     * @ORM\Column(name="zoneDepartement", type="string", length=30, nullable=false)
     */
    private $zonedepartement;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="detail departement doir étre remplie")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "nom equipement doit depassée {{ limit }} characters",
     *      maxMessage = "nom equipement ne deppase pas {{ limit }} characters"
     * )
     * 
     * @ORM\Column(name="detailDepartement", type="string", length=30, nullable=false)
     */
    private $detaildepartement;



    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  int  $id
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nomdepartement
     *
     * @return  string
     */ 
    public function getNomdepartement()
    {
        return $this->nomdepartement;
    }

    /**
     * Set the value of nomdepartement
     *
     * @param  string  $nomdepartement
     *
     * @return  self
     */ 
    public function setNomdepartement(string $nomdepartement)
    {
        $this->nomdepartement = $nomdepartement;

        return $this;
    }

    /**
     * Get the value of zonedepartement
     *
     * @return  string
     */ 
    public function getZonedepartement()
    {
        return $this->zonedepartement;
    }

    /**
     * Set the value of zonedepartement
     *
     * @param  string  $zonedepartement
     *
     * @return  self
     */ 
    public function setZonedepartement(string $zonedepartement)
    {
        $this->zonedepartement = $zonedepartement;

        return $this;
    }

    /**
     * Get the value of detaildepartement
     *
     * @return  string
     */ 
    public function getDetaildepartement()
    {
        return $this->detaildepartement;
    }

    /**
     * Set the value of detaildepartement
     *
     * @param  string  $detaildepartement
     *
     * @return  self
     */ 
    public function setDetaildepartement(string $detaildepartement)
    {
        $this->detaildepartement = $detaildepartement;

        return $this;
    }
}
