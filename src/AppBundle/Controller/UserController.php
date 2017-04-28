<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Message;
use AppBundle\Entity\User;
use AppBundle\Form\UserForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller
{

    /**
     * @Route("/", name="home")
     * @param Request $request
     * @return Response
     *
     */
    public function addAction(Request $request)
    {
        $session = $request->getSession();
        $user = new User();

        // $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(UserForm::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $session->set('name', $user->getName());
            //$this->get('session')->set('name', $user->getName());
            //$request->getSession()->set('name', $this->setName())
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('message');
        }

        return $this->render('AppBundle:user:index.html.twig', [
            'form' => $form->createView()

        ]);

    }






}