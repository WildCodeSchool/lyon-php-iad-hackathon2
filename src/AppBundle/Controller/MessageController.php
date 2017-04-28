<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Form\MessageForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class MessageController extends Controller
{

    /**
     * @Route("/message", name="message")
     * @param Request $request
     * @return Response
     *
     */
    public function addAction(Request $request)
    {

       $session = $request->getSession();
       $name = $session->get('name');

        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository('AppBundle:Message')->findAll();

        $message = new Message();


        $form = $this->createForm(MessageForm::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $message->setUser()->getId();
            $em->persist($message);

            $em->flush();

            return $this->redirectToRoute('message');
        }

        return $this->render('AppBundle:message:index.html.twig', [
            'messages' => $messages,
            'name' => $name,
            'form' => $form->createView(),
        ]);
    }
}