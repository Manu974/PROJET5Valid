<?php
// src/NAO/NewsletterBundle/SubDiffusion/NAOSubDiffusion.php
// Diffusion de la newsletter aux abonnées

namespace NAO\NewsletterBundle\SubDiffusion;

use Doctrine\ORM\EntityManagerInterface;

class NAOSubDiffusion
{
    // Récupération de Doctrine dans le service
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function subdiffusion()
    {
        $subs = $this->em->getRepository('NAONewsletterBundle:Subscriber')->findAll();
        $newsletter = $this->em->getRepository('NAONewsletterBundle:Newsletter')->findOneBy([]);
        $rslt = 'nok';

        if (!empty($subs))
        {
            foreach ($subs as $sub)
            {
                if (!empty($sub))
                {
                   //----Envoi de la newsletters par mail-----//
                   $rslt = 'ok';
                }
            }
        }
    return $rslt;
    }
}