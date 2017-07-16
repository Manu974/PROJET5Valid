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
            if($observation->getIsValid() == false || $observation->getStatusAuthor()== true){
                unset($listObs[$key]);
            }
        }

        return $listObs;
    }


    public function filtreObsEspacePro($data)
    {
        $repository = $this->em->getRepository('AppBundle:Observation');
        // filtre unique
        $choixProFamille = ['famille'=>$data['famille']];
        $choixProNomVern = ['nomVernaculaire'=>$data['nom_vernaculaire']];
        $choixProNomScien = ['nomScientifique'=>$data['nom_scientifique']];
        $choixProDepartement= ['department'=>$data['department']];
        $choixProValide= ['isValid'=>$data['is_valid']];
        $choixProAuteur= ['author'=>$data['author']];

        ///////////////////////////// double filtres////////////////////////////////
        $choixProFamilleNomVern = ['famille'=>$data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire']];
        $choixProFamilleNomScien =['famille'=>$data['famille'],'nomScientifique'=>$data['nom_scientifique']];
        $choixProFamilleDpt =['famille'=>$data['famille'],'department'=>$data['department']];
        $choixProFamilleVal =['famille'=>$data['famille'],'isValid'=>$data['is_valid']];
        $choixProFamilleAut =['famille'=>$data['famille'],'author'=>$data['author']];

        $choixProNomVernNomScien =['nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique']];
        $choixProNomVernDpt =['nomVernaculaire'=>$data['nom_vernaculaire'],'department'=>$data['department']];
        $choixProNomVernVal =['nomVernaculaire'=>$data['nom_vernaculaire'],'isValid'=>$data['is_valid']];
        $choixProNomVernAut =['nomVernaculaire'=>$data['nom_vernaculaire'],'author'=>$data['author']];

        $choixProNomScienDpt =['nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department']];
        $choixProNomScienVal =['nomScientifique'=>$data['nom_scientifique'],'isValid'=>$data['is_valid']];
        $choixProNomScienAut =['nomScientifique'=>$data['nom_scientifique'],'author'=>$data['author']];

        $choixProDptVal =['department'=>$data['department'],'isValid'=>$data['is_valid']];
        $choixProDptAut =['department'=>$data['department'],'author'=>$data['author']];

        $choixProValAut =['isValid'=>$data['is_valid'],'author'=>$data['author']];

        ////////////////////////////////////triple filtes/////////////////////////
        $choixProFamilleNomVernNomScien =['famille'=>$data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique']];

        $choixProFamilleNomVernDpt=['famille'=>$data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'department'=>$data['department']];

        $choixProFamilleNomVernVal=['famille'=>$data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'isValid'=>$data['is_valid']];

        $choixProFamilleNomVernAut=['famille'=>$data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'author'=>$data['author']];

        $choixProFamilleNomScienDpt=['famille'=>$data['famille'],'nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department']];

        $choixProFamilleNomScienVal=['famille'=>$data['famille'],'nomScientifique'=>$data['nom_scientifique'],'isValid'=>$data['is_valid']];

        $choixProFamilleNomScienAut=['famille'=>$data['famille'],'nomScientifique'=>$data['nom_scientifique'],'author'=>$data['author']];


        $choixProNomVernNomScienDpt =['nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department']];

        $choixProNomVernNomScienVal =['nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'isValid'=>$data['is_valid']];

        $choixProNomVernNomScienAut =['nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'author'=>$data['author']];

        $choixProNomVernDptVal =['nomVernaculaire'=>$data['nom_vernaculaire'],'department'=>$data['department'],'isValid'=>$data['is_valid']];

        $choixProNomVernDptAut =['nomVernaculaire'=>$data['nom_vernaculaire'],'department'=>$data['department'],'author'=>$data['author']];

        $choixProNomVernValAut =['nomVernaculaire'=>$data['nom_vernaculaire'],'isValid'=>$data['is_valid'],'author'=>$data['author']];



        $choixProNomScienDptVal =['nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department'],'isValid'=>$data['is_valid']];

        $choixProNomScienDptAut =['nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department'],'author'=>$data['author']];

        $choixProNomScienValAut =['nomScientifique'=>$data['nom_scientifique'],'isValid'=>$data['is_valid'],'author'=>$data['author']];

        $choixProDptValAut =['department'=>$data['department'],'isValid'=>$data['is_valid'],'author'=>$data['author']];

        /////////////////////// 4 filtres/////////////////////////////////////////////////////
        $choixProFamilleNomVernNomScienDpt = ['famille'=>$data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department']];

        $choixProFamilleNomVernNomScienVal = ['famille'=>$data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'isValid'=>$data['is_valid']];

        $choixProFamilleNomVernNomScienAut = ['famille'=>$data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'author'=>$data['author']];


        $choixProFamilleNomScienDptVal = ['famille'=>$data['famille'],'nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department'],'isValid'=>$data['is_valid']];

        $choixProFamilleNomScienDptAut = ['famille'=>$data['famille'],'nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department'],'author'=>$data['author']];

        $choixProFamilleNomScienDptAut = ['famille'=>$data['famille'],'nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department'],'author'=>$data['author']];

        $choixProFamilleDptValAut = ['famille'=>$data['famille'],'department'=>$data['department'],'isValid'=>$data['is_valid'],'author'=>$data['author']];


       $choixProNomVernNomScienDptVal = ['nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department'],'isValid'=>$data['is_valid']];
       
       $choixProNomVernNomScienValAut = ['nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'isValid'=>$data['is_valid'],'author'=>$data['author']];

       $choixProNomVernDptValAut = ['nomVernaculaire'=>$data['nom_vernaculaire'],'department'=>$data['department'],'isValid'=>$data['is_valid'],'author'=>$data['author']];

       $choixProNomScienDptValAut = ['nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department'],'isValid'=>$data['is_valid'],'author'=>$data['author']];

       /////////////////////// 5 filtres/////////////////////////////////////////////////////
        $choixProFamilleNomVernNomScienDptVal = ['famille'=>$data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department'],'isValid'=>$data['is_valid']];

         $choixProFamilleNomVernNomScienDptAut = ['famille'=>$data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department'],'author'=>$data['author']];

         $choixProFamilleNomVernNomScienValAut = ['famille'=>$data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'isValid'=>$data['is_valid'],'author'=>$data['author']];

          $choixProFamilleNomVernDptValAut = ['famille'=>$data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'department'=>$data['department'],'isValid'=>$data['is_valid'],'author'=>$data['author']];

          $choixProFamilleNomScienDptValAut = ['famille'=>$data['famille'],'nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department'],'isValid'=>$data['is_valid'],'author'=>$data['author']];

          $choixProNomVernNomScienDptValAut = ['nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'department'=>$data['department'],'isValid'=>$data['is_valid'],'author'=>$data['author']];

          /////////////filtre all///////////

          $choixProAll = ['famille' => $data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'isValid'=>$data['is_valid'], 'author'=>$data['author'], 'department'=>$data['department']];

        /////////////traitement filtre unique//////////////////////////////
          //famille
          if(!empty($data['famille']) && empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && empty($data['department']) && empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamille);
        }

        //nom commun
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && empty($data['department']) && empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomVern);
        }

        //nom scientifiqueque
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department']) && empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomScien);
        }

        //depatement
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && !empty($data['department']) && empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProDepartement);
        }

        //valide
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && empty($data['department']) && !empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProValide);
        }

        //auteur
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && empty($data['department']) && empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProAuteur);
        }

        /////////////traitement double filtes//////////////////////////////
          //famille nom commun
          if(!empty($data['famille']) && !empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && empty($data['department']) && empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomVern);
        }

        //famille nom scientifique
        if(!empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department']) && empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomScien);
        }

        //famille departement
        if(!empty($data['famille']) && empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && !empty($data['department']) && empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleDpt);
        }

        //famille valide
        if(!empty($data['famille']) && empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && empty($data['department']) && !empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleVal);
        }

        //famille auteur
        if(!empty($data['famille']) && empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && empty($data['department']) && empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleAut);
        }

        //vern scien
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department']) && empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomVernNomScien);
        }

        //vern departement
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && !empty($data['department']) && empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomVernDpt);
        }

        //vern valide
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && empty($data['department']) && !empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomVernVal);
        }

        //vern auteur
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && empty($data['department']) && empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomVernAut);
        }

        //scien departement
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department']) && empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomScienDpt);
        }

        //scien valide
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department']) && !empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomScienVal);
        }

        //scien auteur
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department']) && empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomScienAut);
        }

        //departemetn valide
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && !empty($data['department']) && !empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProDptVal);
        }

        //departement auteur
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && !empty($data['department']) && empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProDptAut);
        }

        //valide auteur
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && empty($data['department']) && !empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProValAut);
            
        }

        /////////////traitement triple filtres//////////////////////////////
          //famille vern scien
          if(!empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department']) && empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomVernNomScien);
        }

        //famille vern dpt
        if(!empty($data['famille']) && !empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && !empty($data['department']) && empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomVernDpt);
        }

        //famille vern valide
        if(!empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department']) && !empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomVernVal);
        }

        //famille vern auteur
        if(!empty($data['famille']) && !empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && empty($data['department']) && empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomVernAut);
        }

        //famille scien dpt
        if(!empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department']) && empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomScienDpt);
        }

        //famille scien val
        if(!empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department']) && !empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomScienVal);
        }

        //famille scien aut
        if(!empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department']) && empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomScienAut);
        }

        //vern scien dpt
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department']) && empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomVernNomScienDpt);
        }

        //ver scien val
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department']) && !empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomVernNomScienVal);
        }

        //vern scien aut
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department']) && empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomVernNomScienAut);
        }

        //vern dpt val
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && !empty($data['department']) && !empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomVernDptVal);
        }

        //vern dpt aut
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && !empty($data['department']) && empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomVernDptAut);
        }

        //vern val aut
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && empty($data['department']) && !empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomVernValAut);
        }

        //scien dpt val
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department']) && !empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomScienDptVal);
        }

        //scien dpt aut
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department']) && empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomScienDptAut);
        }

        //scien val aut
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department']) && !empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomScienValAut);
        }

        //dpt val aut
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && !empty($data['department']) && !empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProDptValAut);
        }

        /////////////traitement 4 filtre//////////////////////////////
          //famille vern scien dpt
          if(!empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department']) && empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomVernNomScienDpt);
        }

        //famille vern scien val
        if(!empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department']) && !empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomVernNomScienVal);
        }

        //famille vern scien aut
        if(!empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department']) && empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomVernNomScienAut);
        }

        //famille scien dpt val
        if(!empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department']) && !empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomScienDptVal);
        }

        //famill scien dpt aut
        if(!empty($data['famille']) && empty($data['nom_vernaculaire']) && !mpty($data['nom_scientifique']) && !empty($data['department']) && empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomScienDptAut);
        }

        //famille dpt val aut
        if(!empty($data['famille']) && empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && !empty($data['department']) && !empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleDptValAut);
        }

        //vern sicen dpt val
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department']) && !empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomVernNomScienDptVal);
        }

        //vern scien val aut
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department']) && !empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomVernNomScienValAut);
        }

        //vern dpt val aut
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && !empty($data['department']) && !empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomVernDptValAut);
        }

        //scien dpt val aut
        if(empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department']) && !empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomScienDptValAut);
        }


        /////////////traitement 5 filtres//////////////////////////////
          //famille vern scien dpt val
          if(!empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department']) && !empty($data['is_valid']) && empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomVernNomScienDptVal);
        }

        //famille vern scien dpt aut
        if(!empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department']) && empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomVernNomScienDptAut);
        }

        //famille vern scien  val aut
        if(!empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && empty($data['department']) && !empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomVernNomScienValAut);
        }

        //famille vern dpt val aut
        if(!empty($data['famille']) && !empty($data['nom_vernaculaire']) && empty($data['nom_scientifique']) && !empty($data['department']) && !empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomVernDptValAut);
        }

        //famille scien dpt val aut
        if(!empty($data['famille']) && empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department']) && !empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProFamilleNomScienDptValAut);
        }

        //vern scien dpt val aut
        if(empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department']) && !empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProNomVernNomScienDptValAut);
        }

         ///////////////traitement de tout les filtre////////////////////////////
        // All
       if(!empty($data['famille']) && !empty($data['nom_vernaculaire']) && !empty($data['nom_scientifique']) && !empty($data['department']) && !empty($data['is_valid']) && !empty($data['author'])){
            $listObsEspacePro = $repository->findBy($choixProAll);
        }


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
