<?php
// src/NAO/UserBundle/Controller/AdminController.php

namespace NAO\UserBundle\Controller;

use NAO\UserBundle\Form\MdpType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use NAO\UserBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use NAO\UserBundle\Form\ListUserNameType;
use NAO\UserBundle\Form\ListUserMailType;
use NAO\UserBundle\Entity\User;

class AdminController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     */
    // Compte
    public function UserAction(Request $request) {

        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        // Liste des utilisateurs
        $userName = new User();
        $userMail = new User();

        $formName   = $this->get('form.factory')->create(ListUserNameType::class, $userName);
        $formMail   = $this->get('form.factory')->create(ListUserMailType::class, $userMail);

        if ($request->isMethod('POST') && $formName->handleRequest($request)->isValid())
        {   
            $username = $formName["username"]->getData()->getUsername();
            $userFindByName = $userManager->findUserBy(array('username'=>$username));

            return $this->render('NAOUserBundle:User:user.html.twig', array(
                'formName' => $formName->createView(),
                'formMail' => $formMail->createView(),
                'users' => $users,
                'userFindByName'=> $userFindByName,
            ));
        }

        if ($request->isMethod('POST') && $formMail->handleRequest($request)->isValid())
        {
            $usermail = $formMail["email"]->getData()->getEmail();
            $userFindByEmail = $userManager->findUserBy(array('email'=>$usermail));
           
           return $this->render('NAOUserBundle:User:user.html.twig', array(
                'formName' => $formName->createView(),
                'formMail' => $formMail->createView(),
                'users' => $users,
                'userFindByEmail'=> $userFindByEmail,
            ));
    
        }

        return $this->render('NAOUserBundle:User:user.html.twig', array(
            'formName' => $formName->createView(),
            'formMail' => $formMail->createView(),
            'users' => $users
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    // Promotion utilisateur en naturaliste
    public function promoteUserAction($id){
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));

        if (!$user) {
            throw $this->createNotFoundException('Erreur - données utilisateur introuvable.');
        }

        $user->addRole('ROLE_NATURALISTE');

        
        // Maj BDD
        $userManager->updateUser($user);

        return $this->redirectToRoute('nao_user_compte');
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    // Dégrader naturaliste en utilisateur
    public function demoteUserAction($id){
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));

        if (!$user) {
            throw $this->createNotFoundException('Erreur - données utilisateur introuvable.');
        }

        $user->removeRole('ROLE_NATURALISTE');

        // Maj BDD
        $userManager->updateUser($user);

        return $this->redirectToRoute('nao_user_compte');
    }
    /**
     * @Security("has_role('ROLE_USER')")
     */
    // Suppression de son compte par utilisateur/naturaliste
    public function deleteUserAction($id, Request $request){

        $userManager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');
        $user = $userManager->findUserBy(array('id'=>$id));
        $encoder = $factory->getEncoder($user);
        $salt = $user->getSalt();

        if (!$user) {
            throw $this->createNotFoundException('Erreur - données utilisateur introuvable.');
        }

        $form = $this->get('form.factory')->create(MdpType::class);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $mdpArray = $_POST['mdp'];
            $mdp = $mdpArray['password'];

            if($encoder->isPasswordValid($user->getPassword(), $mdp, $salt)) {
                // suppression du compte
                $userManager->deleteUser($user);
                $request->getSession()->getFlashBag()->add('error', 'Votre compte a été supprimé');
                return $this->redirectToRoute('nao_user_compte');
            } else {
                // Message d'erreur - Mot de passe invalide
                $request->getSession()->getFlashBag()->add('error', 'Mot de passe invalide');
                return $this->redirectToRoute('nao_user_compte');
            }
        }

        return $this->render('NAOUserBundle:User:pswdCtrl.html.twig', array(
            'form'    => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    // Suppression d'un compte par Administrateur
    public function adminDeleteUserAction($id, Request $request){
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));

        if (!$user) {
            throw $this->createNotFoundException('Erreur - données utilisateur introuvable.');
        }

        // suppression du compte
        $userManager->deleteUser($user);

        return $this->redirectToRoute('nao_user_compte');
    }
    /**
     * @Security("has_role('ROLE_USER')")
     */
    // Modification E-mail
    public function updMailUserAction($id, Request $request){

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));

        if (!$user) {
            throw $this->createNotFoundException('Erreur - données utilisateur introuvable.');
        }

        $form = $this->get('form.factory')->create(UserType::class, $user);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            // MAJ BDD
            $em->persist($user);
            $em->flush();

            // Liste des utilisateurs
            $users = $userManager->findUsers();

            return $this->redirect($this->generateUrl('nao_user_compte', array('users' => $users)));
        }

        return $this->render('NAOUserBundle:User:updMail.html.twig', array(
            'form'    => $form->createView()
        ));
    }
}