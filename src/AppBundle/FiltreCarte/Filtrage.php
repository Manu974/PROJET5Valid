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
        $choixFamille = ['famille'=>$data['famille']];
        $choixNomVern = ['nomVernaculaire'=>$data['nom_vernaculaire']];
        $choixNomScien = ['nomScientifique'=>$data['nom_scientifique']];
        $choixDepartement= ['department'=>$data['department']];

        // double filtre
        $choixFamilleNomVern = ['famille'=>$data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire']];
        $choixFamilleNomScien =['famille'=>$data['famille'],'nomScientifique'=>$data['nom_scientifique']];
        $choixFamilleDpt =['famille'=>$data['famille'],'department'=>$data['department']];
        $choixNomVernNomScien =['nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique']];

        $choixNomVernDpt =['nomVernaculaire'=>$data['nom_vernaculaire'],'department'=>$data['department']];
        $choixNomScienDpt =['nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department']];

        //triple filte
        $choixFamilleNomVernNomScien =['famille'=>$data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique']];

        $choixFamilleNomVernDpt=['famille'=>$data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'department'=>$data['department']];

        $choixFamilleNomScienDpt=['famille'=>$data['famille'],'nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department']];

        $choixNomVernNomScienDpt =['nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department']];

        //All Filtre
        $choixAll = ['famille'=>$data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department']];

        ////////////////traitement avec filtre unique///////////////
        //famille
        if(!empty($data['famille']) && empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && empty($data['department'])){
            $listObs = $repository->findBy($choixFamille);
        }

        //nom commun
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && empty($data['department'])){
            $listObs = $repository->findBy($choixNomVern);
        }

        //nom scientifiqueque
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department'])){
            $listObs = $repository->findBy($choixNomScien);
        }

        //depatement
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && !empty($data['department'])){
            $listObs = $repository->findBy($choixDepartement);
        }

        ////////////////traitement avec filtre double///////////////
        //famille nom vern
        if(!empty($data['famille']) && !empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && empty($data['department'])){
            $listObs = $repository->findBy($choixFamilleNomVern);
        }

        //famille nomscien
        if(!empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department'])){
            $listObs = $repository->findBy($choixFamilleNomScien);
        }

        //famille departement
        if(!empty($data['famille']) && empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && !empty($data['department'])){
            $listObs = $repository->findBy($choixFamilleDpt);
        }

        //nomvern nomscien
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department'])){
            $listObs = $repository->findBy($choixNomVernNomScien);
        }

        //nomvern departement
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && !empty($data['department'])){
            $listObs = $repository->findBy($choixNomVernDpt);
        }

        // nomscien departement
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department'])){
            $listObs = $repository->findBy($choixNomScienDpt);
        }


        /////////////////////////traitement avec filtre triple/////////////
        // famille nomvern nomscien
        if(!empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department'])){
            $listObs = $repository->findBy($choixFamilleNomVernNomScien);
        }
        // famille nomvern departement
        if(!empty($data['famille']) && !empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && !empty($data['department'])){
            $listObs = $repository->findBy($choixFamilleNomVernDpt);
        }
        // famille nomscien departement
        if(!empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department'])){
            $listObs = $repository->findBy($choixFamilleNomScienDpt);
        }
        // nomvern nomscien departement
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department'])){
            $listObs = $repository->findBy($choixNomVernNomScienDpt);
        }

        ///////////////traitement de tout les filtre////////////////////////////
        // All
        if(!empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department'])){
            $listObs = $repository->findBy($choixAll);
        }

        foreach ($listObs as $key => $observation) {
            if($observation->getIsValid() == false){
                unset($listObs[$key]);
            }
        }

        return $listObs;
    }


    public function filtreObsEspacePro($data)
    {
        $filtreEspacePro = ['famille' => $data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'isValid'=>$data['is_valid'], 'author'=>$data['author'], 'department'=>$data['department']];

        $repository = $this->em->getRepository('AppBundle:Observation');

        $listObsEspacePro = $repository->findBy($filtreEspacePro);

        return $listObsEspacePro;
    }
}
