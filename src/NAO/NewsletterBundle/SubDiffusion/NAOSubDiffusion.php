<?php
// src/NAO/NewsletterBundle/SubDiffusion/NAOSubDiffusion.php
// Diffusion de la newsletter aux abonnées

namespace NAO\NewsletterBundle\SubDiffusion;

use Doctrine\ORM\EntityManagerInterface;

class NAOSubDiffusion
{
    // Récupération de Doctrine dans le service
    private $em;
    public function __construct(EntityManagerInterface $em,\Swift_Mailer $mailer,\Twig_Environment $twig)
    {
        $this->em = $em;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function subdiffusion($sourceEmail)
    {
        $subs = $this->em->getRepository('NAONewsletterBundle:Subscriber')->findAll();
        $newsletter = $this->em->getRepository('NAONewsletterBundle:Newsletter')->findOneBy([]);
        $rslt = 'nok';

        $message = \Swift_Message::newInstance();

        if (!empty($subs))
        {
            foreach ($subs as $sub)
            {   
                if (!empty($sub))
                {
                       $message->setSubject('Newsletter NAO')
                            ->setFrom($sourceEmail)
                            ->setTo($sub->getEmail())
                            ->setBody(
                                $this->twig->render(
                                    // app/Resources/views/Emails/registration.html.twig
                                    'NAONewsletterBundle:Admin:mail.html.twig', [
                                    'newsletter'=>$newsletter,
                                    ]
                                ),
                                'text/html'
                            );
                        
                            $this->mailer->send($message);
                                   $rslt = 'ok';
                }
            }
        }
    return $rslt;
    }
}