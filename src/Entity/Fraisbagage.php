<?php

namespace App\Entity;

use App\Repository\FraisbagageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FraisbagageRepository::class)
 */
class Fraisbagage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *@Assert\NotBlank(message=" poids doit etre non vide")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(type="string", length=255)
     */
    private $poids;

    /**
     *@Assert\NotBlank(message=" dimension doit etre non vide")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(type="string", length=255)
     */
    private $dimension;

    /**
     *@Assert\NotBlank(message="Veuiller ajouter une tarifs de base S'il vous plait")
     * @Assert\Type("integer",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(type="integer")
     */
    private $tarifs_base;

    /**
     *@Assert\NotBlank(message="Veuiller ajouter une tarifs de cconfort  S'il vous plait")
     * @Assert\Type("integer",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(type="integer")
     */
    private $tarifs_confort;

    /**
     *@Assert\NotBlank(message="Veuiller ajouter un montant S'il vous plait")
     * @Assert\Type("integer",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(type="integer")
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity=Bagage::class, inversedBy="fraisbagages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bagage_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoids(): ?string
    {
        return $this->poids;
    }

    public function setPoids(string $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getDimension(): ?string
    {
        return $this->dimension;
    }

    public function setDimension(string $dimension): self
    {
        $this->dimension = $dimension;

        return $this;
    }

    public function getTarifsBase(): ?int
    {
        return $this->tarifs_base;
    }

    public function setTarifsBase(int $tarifs_base): self
    {
        $this->tarifs_base = $tarifs_base;

        return $this;
    }

    public function getTarifsConfort(): ?int
    {
        return $this->tarifs_confort;
    }

    public function setTarifsConfort(int $tarifs_confort): self
    {
        $this->tarifs_confort = $tarifs_confort;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getBagageId(): ?Bagage
    {
        return $this->bagage_id;
    }

    public function setBagageId(?Bagage $bagage_id): self
    {
        $this->bagage_id = $bagage_id;

        return $this;
    }

}
