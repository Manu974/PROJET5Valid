<?php

namespace AppBundle\FiltreCarte;
use Doctrine\ORM\EntityManagerInterface;

Class Filtrage
{

    // Récupération de Doctrine dans le service
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function filtreObsCarte($data)
    {       
        $repository = $this->em->getRepository('AppBundle:Observation');
        // filtre unique
        $Famille = $data['famille'];
        $NomVern = $data['nom_vernaculaire'];
        $NomScien = $data['nom_scientifique'];
        $Departement= $data['department'];

        $choixCarte= [];

        if($Famille != ""){
        
           $choixCarte['famille'] = $data['famille'];
        }

        if($NomVern != ""){
        
           $choixCarte['nomVernaculaire'] = $data['nom_vernaculaire'];
        }

        if($NomScien != ""){
            
           $choixCarte['nomScientifique'] = $data['nom_scientifique'];
        }

        if($Departement != ""){
   
           $choixCarte['department'] = $data['department'];
        }

        $listObs = $repository->findBy($choixCarte);

        foreach ($listObs as $key => $observation) {
            if($observation->getIsValid() == false || $observation->getStatusAuthor()== true){
                unset($listObs[$key]);
            }
        }

        return $listObs;
    }

    public function filtreObsEspaceProTwo($data)
    {
        //$choixAll = ['famille'=>$data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department']];

        $repository = $this->em->getRepository('AppBundle:Observation');
        $choixProAll2= [];

        $famille = $data['famille'];
        $nomVernaculaire = $data['nom_vernaculaire'];
        $nomScientifique = $data['nom_scientifique'];
        $isValid = $data['is_valid'];
        $auteur = $data['author'];
        $departement = $data['department'];

        $choixProAll2['isValid'] = $data['is_valid'];
    
        if($famille != ""){
        
           $choixProAll2['famille'] = $data['famille'];
        }

        if($nomVernaculaire != ""){
        
           $choixProAll2['nomVernaculaire'] = $data['nom_vernaculaire'];
        }

        if($nomScientifique != ""){
            
           $choixProAll2['nomScientifique'] = $data['nom_scientifique'];
        }

        if($auteur != ""){
     
           $choixProAll2['author'] = $data['author'];
        }

        if($departement != ""){
   
           $choixProAll2['department'] = $data['department'];
        }

        //$choixProAll2 = $isValid;


        $listObsEspacePro = $repository->findBy($choixProAll2);

        return $listObsEspacePro;
    }

    public function filtreObsCarteAll()
    {       
        $repository = $this->em->getRepository('AppBundle:Observation');
        $listObsAll = $repository->findAll();

        foreach ($listObsAll as $key => $observation) {
            if($observation->getIsValid() == false || $observation->getStatusAuthor()== true){
                unset($listObsAll[$key]);
            }
        }

        return $listObsAll;

    }
}
