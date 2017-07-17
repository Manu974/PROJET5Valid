<?php
// src/NAO/FaqBundle/Entity/Faq.php

namespace NAO\FaqBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="NAO\FaqBundle\Repository\FaqRepository")
 * @ORM\Table(name="faq")
 * @ORM\HasLifecycleCallbacks()
 */
class Faq
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Le titre est obligatoire")
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message = "L'auteur est obligatoire")
     */
    protected $author;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message = "L'article doit être renseigné")
     */
    protected $faq;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

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
     * Set title
     *
     * @param string $title
     *
     * @return Faq
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Faq
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
     * Set faq
     *
     * @param string $faq
     *
     * @return Faq
     */
    public function setFaq($faq)
    {
        $this->faq = $faq;
        return $this;
    }

    /**
     * Get faq
     *
     * @return string
     */
    public function getFaq($length = null)
    {
        if (false === is_null($length) && $length > 0)
            return substr($this->faq, 0, $length);
        else
            return $this->faq;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Faq
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Faq
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $this->setUpdated(new \DateTime());
    }

    public function __toString()
    {
        return $this->getTitle();
    }

}
