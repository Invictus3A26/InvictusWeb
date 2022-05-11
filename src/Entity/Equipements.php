<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Equipements
 *
 * @ORM\Table(name="equipements", indexes={@ORM\Index(name="fk", columns={"id_departement"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Equipements
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("departement")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="type equipement doir étre remplie")
     * 
     * @ORM\Column(name="typeEquipement", type="string", length=30, nullable=false)
     * @Groups("departement")
     */
    private $typeequipement;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="nom equipement doir étre remplie")
     * 
     * @Assert\Type("string",message="la valeur {{ value }} doit etre string {{ type }}.")
     *
     * @ORM\Column(name="nomEquipement", type="string", length=30, nullable=false)
     * @Groups("departement")
     */
    private $nomequipement;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="detail equipement doir étre remplie")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "nom equipement doit depassée {{ limit }} characters",
     *      maxMessage = "nom equipement ne deppase pas {{ limit }} characters"
     * )
     * 
     * @ORM\Column(name="detailEquipement", type="string", length=30, nullable=false)
     * @Groups("departement")
     */
    private $detailequipement;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="zone equipement doir étre remplie")
     * 
     * @ORM\Column(name="zoneEquipement", type="string", length=30, nullable=false)
     * @Groups("departement")
     */
    private $zoneequipement;

    /**
     * @var string
     * 
     * @Assert\NotBlank(message="etat equipement doir étre remplie")
     *
     * @ORM\Column(name="etatEquipement", type="string", length=30, nullable=false)
     * @Groups("departement")
     */
    private $etatequipement;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName")
     * @Assert\File( maxSize="10M", mimeTypes={"image/jpeg", "image/png"} )
     * 
     * 
     * @var File|null
     * @Groups("departement")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     * @Groups("departement")
     */
    private $imageName;


    /**
     * @var \Departement
     *
     * @Assert\NotBlank(message="nom departement doir étre remplie")
     * 
     * @ORM\ManyToOne(targetEntity="Departement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_departement", referencedColumnName="id")
     * })
     * @Groups("departement")
     */
    private $idDepartement;



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
     * Get the value of typeequipement
     *
     * @return  string
     */ 
    public function getTypeequipement()
    {
        return $this->typeequipement;
    }

    /**
     * Set the value of typeequipement
     *
     * @param  string  $typeequipement
     *
     * @return  self
     */ 
    public function setTypeequipement(string $typeequipement)
    {
        $this->typeequipement = $typeequipement;

        return $this;
    }

    /**
     * Get the value of nomequipement
     *
     * @return  string
     */ 
    public function getNomequipement()
    {
        return $this->nomequipement;
    }

    /**
     * Set the value of nomequipement
     *
     * @param  string  $nomequipement
     *
     * @return  self
     */ 
    public function setNomequipement(string $nomequipement)
    {
        $this->nomequipement = $nomequipement;

        return $this;
    }

    /**
     * Get the value of detailequipement
     *
     * @return  string
     */ 
    public function getDetailequipement()
    {
        return $this->detailequipement;
    }

    /**
     * Set the value of detailequipement
     *
     * @param  string  $detailequipement
     *
     * @return  self
     */ 
    public function setDetailequipement(string $detailequipement)
    {
        $this->detailequipement = $detailequipement;

        return $this;
    }

    /**
     * Get the value of zoneequipement
     *
     * @return  string
     */ 
    public function getZoneequipement()
    {
        return $this->zoneequipement;
    }

    /**
     * Set the value of zoneequipement
     *
     * @param  string  $zoneequipement
     *
     * @return  self
     */ 
    public function setZoneequipement(string $zoneequipement)
    {
        $this->zoneequipement = $zoneequipement;

        return $this;
    }

    /**
     * Get the value of etatequipement
     *
     * @return  string
     */ 
    public function getEtatequipement()
    {
        return $this->etatequipement;
    }

    /**
     * Set the value of etatequipement
     *
     * @param  string  $etatequipement
     *
     * @return  self
     */ 
    public function setEtatequipement(string $etatequipement)
    {
        $this->etatequipement = $etatequipement;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }
    
    

    /**
     * Get the value of idDepartement
     *
     * @return  \Departement
     */ 
    public function getIdDepartement()
    {
        return $this->idDepartement;
    }

    /**
     * Set the value of idDepartement
     *
     * @param  \Departement  $idDepartement
     *
     * @return  self
     */ 
    public function setIdDepartement(Departement $idDepartement)
    {
        $this->idDepartement = $idDepartement;

        return $this;
    }
}
