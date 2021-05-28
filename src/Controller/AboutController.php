<?php

namespace App\Controller;

use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * @Route("/about", name="app_about", priority="1")
     */
    public function index(SectionRepository $sectionRepository): Response
    {
        return $this->render('about/index.html.twig', [
            'sections' => $sectionRepository->findAll()
        ]);
    }
}
