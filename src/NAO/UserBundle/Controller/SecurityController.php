<?php


namespace NAO\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class SecurityController extends BaseController
{

    public function loginAction(Request $request)
    {

        /** @var $session Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            
            $error = $request->attributes->get($authErrorKey);
            $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

            $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;


            return $this->showLogin([
                'last_username' => $lastUsername,
                'error' => $error,
                'csrf_token' => $csrfToken,
            ]);
        } 

        elseif (null !== $session && $session->has($authErrorKey)) {
             
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);


            $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

            $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

            return $this->showLogin([
                'last_username' => $lastUsername,
                'error' => $error,
                'csrf_token' => $csrfToken,
            ]);
        } 

        else {
            $error = null;

        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.

        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
        ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
        : null;

        if($request->isXmlHttpRequest()){
            return $this->renderLogin([
                'last_username' => $lastUsername,
                'error' => $error,
                'csrf_token' => $csrfToken,
            ]);
        }

        else {
            return $this->showLogin([
                'last_username' => $lastUsername,
                'error' => $error,
                'csrf_token' => $csrfToken,
            ]);
        }

    }


    /**
    *
    * @param array $data
    *
    * @return Response
    */
    protected function showLogin(array $data)
    {
        return $this->render('@FOSUser/Security/pop.html.twig', $data);
    }

}