<?php

namespace AppBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Session\Session;

use AppBundle\Entity\User;
use AppBundle\Entity\Respass;
use AppBundle\Entity\Changepass;
use AppBundle\Form\RegForm;
use AppBundle\Form\ResPassForm;
use AppBundle\Form\ChangePassForm;

use AppBundle\Service\Notifier;

class RegistrationController extends Controller
{
    private $sessionAbc;
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $session = new Session();
        $this->sessionAbc = $session;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function registerAction(Request $request)
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
            
            $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $this->addFlash('success', 'Вы зарегистрированны');
            return $this->redirectToRoute('home');
        }

        $captcha = $this->container->get('app.custom')->getCaptchaValue();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            $this->addFlash('success', 'Вы уже авторизированны');
            return $this->redirectToRoute('home');
        }

        return $this->render(
            '@App/Front/Security/reg.html.twig',[
                'form' => $form->createView(), 
                'captcha' => $captcha
        ]);
    }

    public function resetPassViewFormAction(Request $request, Notifier $notifier)
    {
        $user = new Respass();
        $form = $this->createForm(ResPassForm::class, $user);  

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form_data = $form->getData();
            $userAbc = $form_data->getAbc();
            $userEmail = $form_data->getEmail();
            
            if ($userAbc != $this->sessionAbc->get('abc')) {
                $this->addFlash('danger', 'Не правильная сумма');
                return $this->redirectToRoute('reset_pass');
            }

            $temporaryPass = $this->container->get('app.custom')->generateStr(6);

            $email_check = $this->container->get('points.repository')->getUserByEmail($userEmail);

            if (empty($email_check)) {
                $this->addFlash('danger', 'такого email не существует');
                return $this->redirectToRoute('reset_pass');
            }            

            $em = $this->getDoctrine()->getManager();
            $userCh = $em->getRepository('AppBundle:User')->findOneByEmail($userEmail);
            $password = $this->passwordEncoder->encodePassword($userCh, $temporaryPass);
            $userCh->setPassword($password);
            $em->flush();

            $user_name = $userCh->getUsername();
        
            $notifier->sendTempPassMail($temporaryPass, $userEmail, $user_name);

            $this->addFlash('success', 'на ваш email отправлено письмо с временным паролем');
            return $this->redirectToRoute('reset_pass');
            
        }

        $captcha = $this->container->get('app.custom')->getCaptchaValue();

        return $this->render(
            '@App/Front/Security/res_pass.html.twig', [
                'form' => $form->createView(), 
                'captcha' => $captcha
        ]);
    }

    public function changePassUserAction(Request $request, UserInterface $user)
    {
        $changePass = new Changepass();
        $form = $this->createForm(ChangePassForm::class,  $changePass);
        $userId = $user->getId();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form_data = $form->getData();
            $old_pass = $form_data->getOldPassword();
            $new_pass = $form_data->getPlainPassword();

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')->findOneById($userId);
           
            if (!$this->passwordEncoder->isPasswordValid($user, $old_pass)) {
                $this->addFlash('danger', 'ваш старый пароль не верен');
                return $this->redirectToRoute('change_pass');
            }           

            $password = $this->passwordEncoder->encodePassword($user, $new_pass);            
            $user->setPassword($password);
            $em->flush();

            $this->addFlash('success', 'ваш пароль изменен');
            return $this->redirectToRoute('logout');           
        }

        return $this->render(
            '@App/Front/Security/change_pass.html.twig', [
                'form' => $form->createView()
        ]);        
    }    
   
}