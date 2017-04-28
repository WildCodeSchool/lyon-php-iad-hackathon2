<?php

namespace AppBundle\Controller;

use AppBundle\Entity\message;
use AppBundle\Entity\User;

use AppBundle\Form\MessageForm;
use AppBundle\Form\UserForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/add", name="add")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserForm::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $session = $request->getSession();
            $session->set('user', $user);
            return $this->redirectToRoute('add');

        }
            return $this->render('default/add.html.twig', array(
                'form' => $form->createView(),

                ));
        }

    /**
     * @Route("/message", name="message")
     * @param Request $request
     * @return Response
     */
    public function chatAction(Request $request)
    {
        $message = new Message();
        $form = $this->createForm(MessageForm::class, $message);

        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')
            ->find($request->getSession()->get("user")->getId());

        if ($form->isSubmitted()){
            $message->setUser($user);
            $em->persist($message);
            $em->flush();
            return $this->redirectToRoute('message');

        }
        $listMessages = $this->getDoctrine()->getRepository(message::class)->findAll();
        return $this->render(':default:message.html.twig', array(
            'listMessages' => $listMessages,
            'form' => $form->createView(),
            'userId' => $user->getId(),
            ));
    }

    /**
     * @Route("/delete/{id}" , name="delete")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function deleteAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $message = $em->getRepository('AppBundle:message')->find($id);
      $em->remove($message);
      $em->flush();
      return $this->redirectToRoute('message');

    }


}
