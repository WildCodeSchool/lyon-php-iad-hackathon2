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
        $message = new Message();

        //$em = $this->getDoctrine()->getManager();

        $form = $this->createForm(MessageForm::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);

            $em->flush();

            return $this->redirectToRoute('message');
        }

        return $this->render('AppBundle:message:index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}