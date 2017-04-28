<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Entity\User;
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

        $form = $this->createForm(MessageForm::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)
                        ->find($request->getSession()->get('user')->getId());

            $message->setUser($user);
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('message');
        }
        $messages = $this->getDoctrine()->getRepository(Message::class)->findBy(array(), array('datetime' => 'desc'), 20, 0);
        return $this->render('AppBundle:message:index.html.twig', [
            'messages' => $messages,
            'form' => $form->createView()
        ]);
    }
}