<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Topic;
use App\Form\CommentType;
use App\Form\TopicType;
use App\Repository\SectionRepository;
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
     * @Route("/new", name="app_new_topic", methods={"GET","POST"})
     */
    public function new(SectionRepository $sectionRepository, Request $request): Response
    {
        // redirect to app_home if user haven't logged in
        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_home');
        }
        $topic = new Topic();
        $topic->setAuthor($this->getUser());
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($topic);
            $entityManager->flush();

            return $this->redirectToRoute('topic_show', ['id' => $topic->getId()]);
        }

        return $this->render('topic/new.html.twig', [
            'topic' => $topic,
            'form' => $form->createView(),
            'sections' => $sectionRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="topic_show", methods={"GET", "POST"})
     */
    public function show(SectionRepository $sectionRepository, Topic $topic, Request $request): Response
    {
        if ($this->getUser()) {
            $comment = new Comment();
            $comment->setAuthor($this->getUser());
            $comment->setTopic($topic);
            $form = $this->createForm(CommentType::class, $comment);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($comment);
                $entityManager->flush();

                return $this->redirectToRoute('topic_show', ['id' => $topic->getId()]);
            }

            return $this->render('topic/show.html.twig', [
                'topic' => $topic,
                'form' => $form->createView(),
                'sections' => $sectionRepository->findAll()
            ]);
        }

        return $this->render('topic/show.html.twig', [
            'topic' => $topic,
            'sections' => $sectionRepository->findAll()
        ]);
    }
}
