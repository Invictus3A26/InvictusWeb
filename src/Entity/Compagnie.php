<?php

namespace App\Entity;

use App\Repository\CompagnieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Images;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=CompagnieRepository::class)
 *  @ORM\Table(name="compagnie", indexes={@ORM\Index(columns={"Code_IATA", "NomCom"}, flags={"fulltext"})})
 */
class Compagnie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id",type="integer", length=50)
     */
    private $id;
    /**
     *@Assert\NotBlank(message=" Code Compagnie doit etre non vide")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(name="Code_IATA",type="string", length=50 )
     */
    private $Code_IATA;

    /**
     *@Assert\NotBlank(message=" Nom compagnie doit etre non vide")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(name="NomCom",type="string", length=50)
     */
    private $NomCom;

    /**
     *@Assert\NotBlank(message=" Lien doit etre non vide")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Url (message = "The url '{{ value }}' is not a valid url")
     * @ORM\Column(name="Link",type="string", length=50)
     */
    private $Link;

    /**
     *@Assert\NotBlank(message=" veuiller ajouter une pays")
     * @Assert\Country
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(name="Pays",type="string", length=50)
     */
    private $Pays;

    /**
     *@Assert\NotBlank(message="Veuiller ajouter un entier S'il vous plait")
     * @Assert\Type("integer",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(name="Number",type="integer")
     */
    private $Number;

    /**
     * @Assert\NotBlank(message=" veuiller ajouter Siege de compagnie")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(name="Siege",type="string", length=50)
     */
    private $Siege;

    /**
     * @Assert\NotBlank(message=" veuiller ajouter l'aeroport de base")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(name="AeBase",type="string", length=50)
     */
    private $AeBase;

    /**
     * @Assert\NotBlank(message=" veuiller ajouter le numéros de passager")
     * @Assert\Type("integer",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(name="PassagerNum",type="integer")
     */
    private $PassagerNum;

    /**
     * @Assert\NotBlank(message=" veuiller ajouter la descpriton de compagnie")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(name="Description",type="string", length=255)
     */
    private $Description;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="compagnies", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=Avion::class, mappedBy="CodeC", orphanRemoval=true ,cascade={"persist"})
     */
    private $avions;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $color;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->avions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeIATA(): ?string
    {
        return $this->Code_IATA;
    }

    public function setCodeIATA(string $Code_IATA): self
    {
        $this->Code_IATA = $Code_IATA;

        return $this;
    }

    public function getNomCom(): ?string
    {
        return $this->NomCom;
    }

    public function setNomCom(string $NomCom): self
    {
        $this->NomCom = $NomCom;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->Link;
    }

    public function setLink(string $Link): self
    {
        $this->Link = $Link;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->Pays;
    }

    public function setPays(string $Pays): self
    {
        $this->Pays = $Pays;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->Number;
    }

    public function setNumber(int $Number): self
    {
        $this->Number = $Number;

        return $this;
    }

    public function getSiege(): ?string
    {
        return $this->Siege;
    }

    public function setSiege(string $Siege): self
    {
        $this->Siege = $Siege;

        return $this;
    }

    public function getAeBase(): ?string
    {
        return $this->AeBase;
    }

    public function setAeBase(string $AeBase): self
    {
        $this->AeBase = $AeBase;

        return $this;
    }

    public function getPassagerNum(): ?int
    {
        return $this->PassagerNum;
    }

    public function setPassagerNum(int $PassagerNum): self
    {
        $this->PassagerNum = $PassagerNum;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setCompagnies($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getAnnonces() === $this) {
                $image->setAnnonces(null);
            }
        }
            return $this;
        }

    /**
     * @return Collection<int, Avion>
     */
    public function getAvions(): Collection
    {
        return $this->avions;
    }

    public function addAvion(Avion $avion): self
    {
        if (!$this->avions->contains($avion)) {
            $this->avions[] = $avion;
            $avion->setCodeC($this);
        }

        return $this;
    }

    public function removeAvion(Avion $avion): self
    {
        if ($this->avions->removeElement($avion)) {
            // set the owning side to null (unless already changed)
            if ($avion->getCodeC() === $this) {
                $avion->setCodeC(null);
            }
        }

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }




}
