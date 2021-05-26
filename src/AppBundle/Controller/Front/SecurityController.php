<?php

namespace AppBundle\Controller\Front;

use AppBundle\Form\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginForm::class, [
            //'_username' => $lastUsername,
        ]);

        return $this->render('@App/Front/Security/login.html.twig', [
            'form'  => $form->createView(),
            'error' => $error,
        ]);
    }

    public function logoutAction()
    {

    }

    public function loginCheckAction()
    {

    }
}
