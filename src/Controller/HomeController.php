<?php

namespace App\Controller;

use App\Service\MovieLister;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/index", name="home")
     * @param MovieLister $movieLister
     * @return Response
     */
    public function index(MovieLister $movieLister) :Response
    {
        $popularMovies = $movieLister->listPopularMovies();
        return $this->render('home/index.html.twig', [
            'popularMovies' => $popularMovies,
        ]);
    }
}
