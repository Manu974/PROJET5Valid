<?php

namespace FT\OrnitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Observation
 *
 * @ORM\Table(name="observation", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_C576DBE03DA5256D", columns={"image_id"})}, indexes={@ORM\Index(name="IDX_C576DBE0A76ED395", columns={"user_id"}), @ORM\Index(name="IDX_C576DBE0E813F9", columns={"bird_id"})})
 * @ORM\Entity(repositoryClass="FT\OrnitBundle\Repository\ObservationRepository")
 */
class Observation
{
    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=false)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=false)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="observation", type="text", nullable=false)
     */
    private $observation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_valid", type="boolean", nullable=false)
     */
    private $isValid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * 
     *
     * @ORM\ManyToOne(targetEntity="FT\OrnitBundle\Entity\Bird")
     * @ORM\JoinColumn(name="bird_id", referencedColumnName="id", nullable=false)
     */
    private $bird;

    /**
     * 
     *
     * @ORM\ManyToOne(targetEntity="FT\OrnitBundle\Entity\ObservationImage")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=true)
     */
    private $image;

    /**
     * 
     *
     * @ORM\ManyToOne(targetEntity="FT\OrnitBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;



    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Observation
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Observation
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set observation
     *
     * @param string $observation
     *
     * @return Observation
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return string
     */
    public function getObservation()
    {
        return $this->observation;
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
     * @return boolean
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set bird
     *
     * @param \FT\OrnitBundle\Entity\Bird $bird
     *
     * @return Observation
     */
    public function setBird(\FT\OrnitBundle\Entity\Bird $bird = null)
    {
        $this->bird = $bird;

        return $this;
    }

    /**
     * Get bird
     *
     * @return \FT\OrnitBundle\Entity\Bird
     */
    public function getBird()
    {
        return $this->bird;
    }

    /**
     * Set image
     *
     * @param \FT\OrnitBundle\Entity\ObservationImage $image
     *
     * @return Observation
     */
    public function setImage(\FT\OrnitBundle\Entity\ObservationImage $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \FT\OrnitBundle\Entity\ObservationImage
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set user
     *
     * @param \FT\OrnitBundle\Entity\User $user
     *
     * @return Observation
     */
    public function setUser(\FT\OrnitBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \FT\OrnitBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
