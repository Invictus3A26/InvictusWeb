<?php

namespace App\Entity;

use App\Repository\BagageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BagageRepository::class)
 * @ORM\Table(name="Bagage", indexes={@ORM\Index(columns={"poids", "dimension"}, flags={"fulltext"})})
 */
class Bagage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @groups("fraisbagage")
     * @Groups("posts:read")
     */
    private $id;

    /**
     *@Assert\NotBlank(message=" poids doit etre non vide")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(type="string", length=255, nullable=true)
     * @groups("fraisbagage")
     * @Groups("posts:read")
     */
    private $poids;

    /**
     *@Assert\NotBlank(message=" poids M doit etre non vide")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(type="string", length=255)
     * @groups("fraisbagage")
     * @Groups("posts:read")
     */
    private $poidsM;

    /**
     *@Assert\NotBlank(message=" poids S doit etre non vide")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(type="string", length=255)
     * @groups("fraisbagage")
     * @Groups("posts:read")
     */
    private $poidsS;

    /**
     *@Assert\NotBlank(message=" dimension doit etre non vide")
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     * @ORM\Column(type="string", length=255)
     * @groups("fraisbagage")
     * @Groups("posts:read")
     */
    private $dimension;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *@Assert\NotBlank(message="Veuiller ajouter un numero de valise  S'il vous plait")
     * @Assert\Type("integer",message="The value {{ value }} is not a valid {{ type }}.")
     * @groups("fraisbagage")
     * @Groups("posts:read")
     */
    private $num_valise;

    /**
     * @ORM\OneToMany(targetEntity=Fraisbagage::class, mappedBy="bagage_id", orphanRemoval=true ,cascade={"persist"})
     */
    private $fraisbagages;

    /**
     * @var \User
     * 
     * @ORM\ManyToOne(targetEntity="User")
     * 
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_userr", referencedColumnName="id")
     * })
     * @Groups("fraisbagage")
     */

    private $id_userr;



    public function __construct()
    {
        $this->fraisbagages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoids(): ?string
    {
        return $this->poids;
    }

    public function setPoids(?string $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getPoidsM(): ?string
    {
        return $this->poidsM;
    }

    public function setPoidsM(string $poidsM): self
    {
        $this->poidsM = $poidsM;

        return $this;
    }

    public function getPoidsS(): ?string
    {
        return $this->poidsS;
    }

    public function setPoidsS(string $poidsS): self
    {
        $this->poidsS = $poidsS;

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

    public function getNumValise(): ?int
    {
        return $this->num_valise;
    }

    public function setNumValise(?int $num_valise): self
    {
        $this->num_valise = $num_valise;

        return $this;
    }

    /**
     * @return Collection<int, Fraisbagage>
     */
    public function getFraisbagages(): Collection
    {
        return $this->fraisbagages;
    }

    public function addFraisbagage(Fraisbagage $fraisbagage): self
    {
        if (!$this->fraisbagages->contains($fraisbagage)) {
            $this->fraisbagages[] = $fraisbagage;
            $fraisbagage->setBagageId($this);
        }

        return $this;
    }

    public function removeFraisbagage(Fraisbagage $fraisbagage): self
    {
        if ($this->fraisbagages->removeElement($fraisbagage)) {
            // set the owning side to null (unless already changed)
            if ($fraisbagage->getBagageId() === $this) {
                $fraisbagage->setBagageId(null);
            }
        }

        return $this;
    }
}
