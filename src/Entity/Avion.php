<?php

namespace App\Entity;

use App\Repository\AvionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=AvionRepository::class)
 */
class Avion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * *@Assert\NotBlank(message=" Code Avion doit etre non vide")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(name="CodeAvion",type="string", length=50)
     */
    private $CodeAvion;

    /**
     * *@Assert\NotBlank(message=" Type Avion doit etre non vide")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(name="TypeA",type="string", length=50)
     */
    private $TypeA;

    /**
     * *@Assert\NotBlank(message=" Model d'avion doit etre non vide")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(name="Model",type="string", length=50)
     */
    private $Model;

    /**
     * *@Assert\NotBlank(message=" Nombre de passager doit etre non vide")
     * @Assert\Type("integer",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(name="PassagerN",type="integer")
     */
    private $PassagerN;

    /**
     * @ORM\ManyToOne(targetEntity=Compagnie::class, inversedBy="avions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $CodeC;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeAvion(): ?string
    {
        return $this->CodeAvion;
    }

    public function setCodeAvion(string $CodeAvion): self
    {
        $this->CodeAvion = $CodeAvion;

        return $this;
    }

    public function getTypeA(): ?string
    {
        return $this->TypeA;
    }

    public function setTypeA(string $TypeA): self
    {
        $this->TypeA = $TypeA;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->Model;
    }

    public function setModel(string $Model): self
    {
        $this->Model = $Model;

        return $this;
    }

    public function getPassagerN(): ?int
    {
        return $this->PassagerN;
    }

    public function setPassagerN(int $PassagerN): self
    {
        $this->PassagerN = $PassagerN;

        return $this;
    }

    public function getCodeC(): ?Compagnie
    {
        return $this->CodeC;
    }

    public function setCodeC(?Compagnie $CodeC): self
    {
        $this->CodeC = $CodeC;

        return $this;
    }
}
