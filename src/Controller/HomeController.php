<?php

namespace App\Controller;

use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(SectionRepository $sectionRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'sections' => $sectionRepository->findAll()
        ]);
    }

    /**
     * @Route("/{sectionCode}", name="app_sections")
     */
    public function sections(SectionRepository $sectionRepository, string $sectionCode): Response
    {
        $section = $sectionRepository->findByCode($sectionCode);
        if ($section === null) {
            throw new NotFoundHttpException();
        }
        return $this->render('section/show.html.twig', [
            'section' => $section,
            'sections' => $sectionRepository->findAll()
        ]);
    }
}
