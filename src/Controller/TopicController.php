<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Form\TopicType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/topic")
 */
class TopicController extends AbstractController
{
    /**
     * @Route("/new", name="topic_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $topic = new Topic();
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($topic);
            $entityManager->flush();

            return $this->redirectToRoute('topic_index');
        }

        return $this->render('topic/new.html.twig', [
            'topic' => $topic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="topic_show", methods={"GET"})
     */
    public function show(Topic $topic): Response
    {
        return $this->render('topic/show.html.twig', [
            'topic' => $topic,
        ]);
    }
}
