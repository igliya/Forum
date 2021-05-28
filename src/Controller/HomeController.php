<?php

namespace App\Controller;

use App\Repository\SectionRepository;
use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(SectionRepository $sectionRepository, TopicRepository $topicRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'topics' => $topicRepository->findAll(),
            'sections' => $sectionRepository->findAll()
        ]);
    }

    /**
     * @Route("/{sectionCode}", name="app_sections")
     */
    public function sections(
        TopicRepository $topicRepository,
        SectionRepository $sectionRepository,
        string $sectionCode
    ): Response {
        $sections = $sectionRepository->findAll();
        $section = null;
        // find section by code from slug
        foreach ($sections as $item) {
            if ($sectionCode === $item->getCode()) {
                $section = $item;
                break;
            }
        }
        if ($section === null) {
            throw new NotFoundHttpException();
        }
        return $this->render('section/show.html.twig', [
            'section' => $section,
            'sections' => $sections,
            'topics' => $topicRepository->findBySection($section)
        ]);
    }
}
