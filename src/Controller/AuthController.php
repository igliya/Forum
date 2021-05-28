<?php

namespace App\Controller;

use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", priority="1")
     * @param AuthenticationUtils $authenticationUtils
     * @param SectionRepository $sectionRepository
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils, SectionRepository $sectionRepository): Response
    {
        // redirect to app_home if user have logged in
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        // render login form
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 'error' => $error, 'sections' => $sectionRepository->findAll()
        ]);
    }

    /**
     * @Route("/logout", name="app_logout", priority="2")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
