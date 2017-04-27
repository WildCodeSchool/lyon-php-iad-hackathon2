<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller
{

    public function indexAction()
    {

    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/", name="homepage")
     *
     */
    public function addAction(Request $request)
    {
        $user = new User();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(UserForm::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);

            $em->flush();

            return $this->redirectToRoute('list_messages');
        }

        return $this->render('AppBundle:User:index.html.twig', [
            'form' => $form->createView(),
        ]);



    }



}