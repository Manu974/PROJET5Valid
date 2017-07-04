<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Observation
 *
 * @ORM\Table(name="observation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObservationRepository")
 */
class Observation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var geometry
     *
     * @ORM\Column(name="location", type="geometry")
     * 
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @var bool
     *
     * @ORM\Column(name="isValid", type="boolean")
     */
    private $isValid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
    * @ORM\OneToOne(targetEntity="AppBundle\Entity\Bird", cascade={"persist"})
    */
    private $bird;

    /**
    * @ORM\OneToOne(targetEntity="AppBundle\Entity\ObservationImage", cascade={"persist"})
    */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="text")
     */
    private $author;

    /**
     * @var int
     *
     * @ORM\Column(name="department", type="integer")
     */
    private $department;

    /**
     * @var string
     *
     * @ORM\Column(name="nomVernaculaire", type="text")
     */
    private $nomVernaculaire;

    /**
     * @var string
     *
     * @ORM\Column(name="nomScientifique", type="text")
     */
    private $nomScientifique;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreOiseaux", type="text")
     */
    private $nombreOiseaux;

    /**
     * @var string
     *
     * @ORM\Column(name="maturite", type="text")
     */
    private $maturite;

    /**
     *
     *
     * @ORM\Column(name="nidification", type="boolean")
     */
    private $nidification;




    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set location
     *
     * @param point $location
     *
     * @return Observation
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return Observation
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Observation
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set isValid
     *
     * @param boolean $isValid
     *
     * @return Observation
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;

        return $this;
    }

    /**
     * Get isValid
     *
     * @return bool
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Observation
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set bird
     *
     * @param \AppBundle\Entity\Bird $bird
     *
     * @return Observation
     */
    public function setBird(\AppBundle\Entity\Bird $bird = null)
    {
        $this->bird = $bird;

        return $this;
    }

    /**
     * Get bird
     *
     * @return \AppBundle\Entity\Bird
     */
    public function getBird()
    {
        return $this->bird;
    }

    /**
     * Set image
     *
     * @param \AppBundle\Entity\ObservationImage $image
     *
     * @return Observation
     */
    public function setImage(\AppBundle\Entity\ObservationImage $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppBundle\Entity\ObservationImage
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Observation
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set department
     *
     * @param integer $department
     *
     * @return Observation
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return integer
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set nomVernaculaire
     *
     * @param string $nomVernaculaire
     *
     * @return Observation
     */
    public function setNomVernaculaire($nomVernaculaire)
    {
        $this->nomVernaculaire = $nomVernaculaire;

        return $this;
    }

    /**
     * Get nomVernaculaire
     *
     * @return string
     */
    public function getNomVernaculaire()
    {
        return $this->nomVernaculaire;
    }

    /**
     * Set nomScientifique
     *
     * @param string $nomScientifique
     *
     * @return Observation
     */
    public function setNomScientifique($nomScientifique)
    {
        $this->nomScientifique = $nomScientifique;

        return $this;
    }

    /**
     * Get nomScientifique
     *
     * @return string
     */
    public function getNomScientifique()
    {
        return $this->nomScientifique;
    }

    /**
     * Set nombreOiseaux
     *
     * @param string $nombreOiseaux
     *
     * @return Observation
     */
    public function setNombreOiseaux($nombreOiseaux)
    {
        $this->nombreOiseaux = $nombreOiseaux;

        return $this;
    }

    /**
     * Get nombreOiseaux
     *
     * @return string
     */
    public function getNombreOiseaux()
    {
        return $this->nombreOiseaux;
    }

    /**
     * Set maturite
     *
     * @param string $maturite
     *
     * @return Observation
     */
    public function setMaturite($maturite)
    {
        $this->maturite = $maturite;

        return $this;
    }

    /**
     * Get maturite
     *
     * @return string
     */
    public function getMaturite()
    {
        return $this->maturite;
    }

    /**
     * Set nidification
     *
     * @param boolean $nidification
     *
     * @return Observation
     */
    public function setNidification($nidification)
    {
        $this->nidification = $nidification;

        return $this;
    }

    /**
     * Get nidification
     *
     * @return boolean
     */
    public function getNidification()
    {
        return $this->nidification;
    }
}
