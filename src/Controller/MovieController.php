<?php

namespace App\Controller;

use App\Service\MovieLister;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/movie", name="movie_index")
     */
    public function index()
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }

    /**
     * @Route("/movie/{id}", name="movie_show")
     * @param MovieLister $movieLister
     * @return Response
     */
    public function show(MovieLister $movieLister) :Response
    {
        $movieDetails = $movieLister->listOneMovieById()
        return $this->render('movie/show.html.twig');
    }
}
