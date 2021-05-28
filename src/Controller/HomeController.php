<?php

namespace App\Controller;

use App\Repository\SectionRepository;
use App\Repository\TopicRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(
        SectionRepository $sectionRepository,
        TopicRepository $topicRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        // get topics query
        $topicsQuery = $topicRepository->createQueryBuilder('t')
            ->orderBy('t.createdDate', 'DESC')
            ->getQuery()
            ;
        // get page number
        $page_number = $request->query->getInt('page', 1);
        // set correct page number
        if ($page_number < 1) {
            $page_number = 1;
        }
        // paginate
        $pagination = $paginator->paginate(
            $topicsQuery,
            $page_number,
            10
        );

        return $this->render('home/index.html.twig', [
            'pagination' => $pagination,
            'sections' => $sectionRepository->findAll()
        ]);
    }

    /**
     * @Route("/{sectionCode}", name="app_sections")
     */
    public function sections(
        TopicRepository $topicRepository,
        PaginatorInterface $paginator,
        Request $request,
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
        // get topics query
        $topicsQuery = $topicRepository->createQueryBuilder('t')
            ->andWhere('t.section = :val')
            ->setParameter('val', $section)
            ->orderBy('t.createdDate', 'DESC')
            ->getQuery()
            ;
        // get page number
        $page_number = $request->query->getInt('page', 1);
        // set correct page number
        if ($page_number < 1) {
            $page_number = 1;
        }
        // paginate
        $pagination = $paginator->paginate(
            $topicsQuery,
            $page_number,
            10
        );

        return $this->render('section/show.html.twig', [
            'section' => $section,
            'sections' => $sections,
            'pagination' => $pagination
        ]);
    }
}
