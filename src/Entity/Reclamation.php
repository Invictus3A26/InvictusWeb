<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=ReclamationRepository::class)
 * 
 */



class Reclamation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\Email
     * @Groups("posts:read")
     * @Groups("reclamations")
     * @var string A "Y-m-d" formatted value
  
     */
    private $id;

    /**
     * @Assert\NotBlank(message=" Nom doit etre non vide")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your Name must be at least {{ limit }} characters long",
     *      maxMessage = "Your Name cannot be longer than {{ limit }} characters"
     * )
     * @Groups("posts:read")
     * @Groups("reclamations")
     */
    private $nom;

    /**
     * *@Assert\NotBlank(message=" Prenom doit etre non vide")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     * @Groups("posts:read")
     * @Groups("reclamations")
     */
    private $prenom;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="4096")
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * @ORM\Column(type="string", length=255)
     * @ORM\Column(name="email", type="string", length=500, nullable=false,unique=true)
     * @Groups("posts:read")
     * @Groups("reclamations")
     */
    private $email;

    /**
     * *@Assert\NotBlank(message="Veuiller ajouter un entier S'il vous plait")
     * @Assert\Type("integer",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(type="integer")
     * @Assert\Length(
     *      min = 8,
     *      max = 50,
     *      minMessage = "Your Phone Number must be at least {{ limit }} characters long",
     *      maxMessage = "Your Phone Number cannot be longer than {{ limit }} characters"
     * )
     * @Groups("posts:read")
     * @Groups("reclamations")
    
     */
    private $tel;



    /**
     * *@Assert\NotBlank(message=" Etat doit etre non vide")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")
     * @Groups("reclamations")
     */
    private $etat;

    /**
     * *@Assert\NotBlank(message=" Description doit etre non vide")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(type="string", length=255)
     * @Groups("posts:read")
     * @Groups("reclamations")
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     * @Groups("posts:read")
     * @Groups("reclamations")
     */
    private $date_reclamation;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="reclamations")
     * @Groups("posts:read")
     * @Groups("reclamations")
     */
    private $type;



    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

        return $this;
    }



    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateReclamation(): ?\DateTimeInterface
    {
        return $this->date_reclamation;
    }

    public function setDateReclamation(\DateTimeInterface $date_reclamation): self
    {
        $this->date_reclamation = $date_reclamation;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }
}
