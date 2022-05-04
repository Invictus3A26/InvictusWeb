<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avcom
 *
 * @ORM\Table(name="avcom")
 * @ORM\Entity
 */
class Avcom
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
     * @ORM\Column(name="CodeCom", type="string", length=50, nullable=false)
     */
    private $codecom;

    /**
     * @var string
     *
     * @ORM\Column(name="NomC", type="string", length=50, nullable=false)
     */
    private $nomc;

    /**
     * @var int
     *
     * @ORM\Column(name="numbAvC", type="integer", nullable=false)
     */
    private $numbavc;


}
