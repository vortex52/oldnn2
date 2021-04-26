<?php

namespace AppBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Points;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends Controller
{
    
    
    public function indexAction(Request $request)
    {
		$first_photo_id = 1;
		$first_point = $this->getDoctrine()->getRepository(Points::class)->find($first_photo_id);

		$photo_obj = $first_point->getImage()->toArray();
       
        $photos = [];
        foreach ($photo_obj as $photo) {
            $photos[] = [
                'id' => $photo->getId(),
                'src' => '/uploads/photo/'.$photo->getSrc()
            ];
        }

        $photo_src = $photos[0]['src'];

        $year_range = $this->container->get('points.repository')->getYearRange();        

        return $this->render('@App/Front/HomePage/index.html.twig',[
            'first_point' => $first_point, 
            'photo_src' => $photo_src, 
            'year_range' => $year_range
        ]);
    }

    public function TestEmailAction()
    {
        // Create the Transport
        $transport = new \Swift_SendmailTransport('/usr/sbin/sendmail -t');

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message('test'))
            ->setFrom(['john@doe.com'])
            ->setTo(['vortex52@yandex.ru'])
            ->setBody(
                $this->render(
                    '@App/Email/admin_notif.html.twig', [
                        'path' => 'path',
                        'user_name' => 'user_name'
                ]),
                'text/html'
            );            

        return $mailer->send($message);
        
    }
    
}
