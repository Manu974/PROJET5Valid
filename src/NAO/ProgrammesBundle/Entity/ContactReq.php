<?php

namespace NAO\ProgrammesBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ContactReq
{
    /**
     * @Assert\Length(min=2, minMessage="Le nom doit contenir au moins {{ limit }} caractères.")
     */
    protected $nom;
    /**
     * @Assert\Length(min=2, minMessage="Le prénom doit contenir au moins {{ limit }} caractères.")
     */
    protected $prenom;
    /**
     * @Assert\Email(message = "l'adresse email '{{ value }}' n'est pas valide.",checkMX = true)
     */
    protected $email;

    protected $sujet;

    protected $message;

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSujet()
    {
        return $this->sujet;
    }

    public function setSujet($sujet)
    {
        $this->sujet = $sujet;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }
}

