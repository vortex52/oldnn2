<?php

namespace AppBundle\Controller\Front;

use AppBundle\Form\RegForm;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\HttpFoundation\Session\Session;

class RegistrationController extends Controller
{
    private $sessionAbc;

    public function __construct()
    {
        $session = new Session();
        $this->sessionAbc = $session;
    }

    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();        
        $form = $this->createForm(RegForm::class, $user);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $userAbc = $form->getData()->getAbc();            
            
            if ($userAbc != $this->sessionAbc->get('abc')) {
                $this->addFlash('success', 'Не правильная сумма');
                return $this->redirectToRoute('register');
            }
            
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $this->addFlash('success', 'Вы зарегистрированны');
            return $this->redirectToRoute('home');
        }

        $captcha = $this->getCaptchaValue();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            $this->addFlash('success', 'Вы уже авторизированны');        
            return $this->redirectToRoute('home');
        }

        return $this->render(
            '@App/Front/Security/reg.html.twig',
            array('form' => $form->createView(), 'captcha' => $captcha)
        );
    }

    public function getCaptchaValue()
    {
        //$session = new Session();
        $a = rand(1,20);
        $b = rand(1,20);

        $this->sessionAbc->set('abc', $a+$b);

        $res = $this->get('translator')->trans($a.' плюс '.$b.' равно ');    
        //$res = $a.' плюс '.$b.' равно ';

        return $res;
    }
}