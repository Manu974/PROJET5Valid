<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bird
 *
 * @ORM\Table(name="bird")
 * @ORM\Entity
 */
class Bird
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom_ref", type="string", length=255, nullable=true)
     */
    private $nomRef;

    /**
     * @var string
     *
     * @ORM\Column(name="synonymes_chresonymes", type="string", length=1386, nullable=true)
     */
    private $synonymesChresonymes;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_vernaculaire", type="string", length=255, nullable=true)
     */
    private $nomVernaculaire;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="regne", type="string", length=255, nullable=true)
     */
    private $regne;

    /**
     * @var string
     *
     * @ORM\Column(name="classe", type="string", length=255, nullable=true)
     */
    private $classe;

    /**
     * @var string
     *
     * @ORM\Column(name="ordre", type="string", length=255, nullable=true)
     */
    private $ordre;

    /**
     * @var string
     *
     * @ORM\Column(name="famille", type="string", length=255, nullable=true)
     */
    private $famille;

    /**
     * @var integer
     *
     * @ORM\Column(name="cd_ref", type="integer", nullable=true)
     */
    private $cdRef;

    /**
     * @var integer
     *
     * @ORM\Column(name="cd_nom", type="integer", nullable=true)
     */
    private $cdNom;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set nomRef
     *
     * @param string $nomRef
     *
     * @return Bird
     */
    public function setNomRef($nomRef)
    {
        $this->nomRef = $nomRef;

        return $this;
    }

    /**
     * Get nomRef
     *
     * @return string
     */
    public function getNomRef()
    {
        return $this->nomRef;
    }

    /**
     * Set synonymesChresonymes
     *
     * @param string $synonymesChresonymes
     *
     * @return Bird
     */
    public function setSynonymesChresonymes($synonymesChresonymes)
    {
        $this->synonymesChresonymes = $synonymesChresonymes;

        return $this;
    }

    /**
     * Get synonymesChresonymes
     *
     * @return string
     */
    public function getSynonymesChresonymes()
    {
        return $this->synonymesChresonymes;
    }

    /**
     * Set nomVernaculaire
     *
     * @param string $nomVernaculaire
     *
     * @return Bird
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
     * Set status
     *
     * @param string $status
     *
     * @return Bird
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set regne
     *
     * @param string $regne
     *
     * @return Bird
     */
    public function setRegne($regne)
    {
        $this->regne = $regne;

        return $this;
    }

    /**
     * Get regne
     *
     * @return string
     */
    public function getRegne()
    {
        return $this->regne;
    }

    /**
     * Set classe
     *
     * @param string $classe
     *
     * @return Bird
     */
    public function setClasse($classe)
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * Get classe
     *
     * @return string
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * Set ordre
     *
     * @param string $ordre
     *
     * @return Bird
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return string
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set famille
     *
     * @param string $famille
     *
     * @return Bird
     */
    public function setFamille($famille)
    {
        $this->famille = $famille;

        return $this;
    }

    /**
     * Get famille
     *
     * @return string
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * Set cdRef
     *
     * @param integer $cdRef
     *
     * @return Bird
     */
    public function setCdRef($cdRef)
    {
        $this->cdRef = $cdRef;

        return $this;
    }

    /**
     * Get cdRef
     *
     * @return integer
     */
    public function getCdRef()
    {
        return $this->cdRef;
    }

    /**
     * Set cdNom
     *
     * @param integer $cdNom
     *
     * @return Bird
     */
    public function setCdNom($cdNom)
    {
        $this->cdNom = $cdNom;

        return $this;
    }

    /**
     * Get cdNom
     *
     * @return integer
     */
    public function getCdNom()
    {
        return $this->cdNom;
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
}
