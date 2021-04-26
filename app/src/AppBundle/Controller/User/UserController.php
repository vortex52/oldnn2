<?php

namespace AppBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use AppBundle\Entity\Points;
use AppBundle\Entity\Image;
use AppBundle\Form\PointForm;

class UserController extends Controller
{

	public function indexAction(Request $request)
    {
		return $this->render('@App/User/index.html.twig');
    }

    public function ShowUserPointsAction(Request $request, UserInterface $user)
    {
    	$userId = $user->getId();
    	$points = $this->container->get('points.repository')->getUserPoints($userId);

    	return $this->render(
            '@App/User/get_user_point.html.twig',
            array('points' => $points)
        );

		// dump($points);
		// die();
    }

    public function AddUserPointsAction(Request $request, UserInterface $user)
    {
        $userId = $user->getId();
        $point = new Points();

        $form = $this->createForm(PointForm::class, $point);       

        return $this->render('@App/User/point_new.html.twig', array(        
            'form' => $form->createView(),
        ));      
    }


}
