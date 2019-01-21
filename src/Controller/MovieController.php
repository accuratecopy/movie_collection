<?php

namespace App\Controller;

use App\Service\MovieLister;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @Route("/movie/{movieId}", name="movie_show")
     * @param MovieLister $movieLister
     * @ParamConverter("movieId", options={"movieId" = "id"})
     * @return Response
     */
    public function show(MovieLister $movieLister, int $movieId) :Response
    {
        $movieDetails = $movieLister->listOneMovieById($movieId);
        return $this->render('movie/show.html.twig', [
            'movie_details' => $movieDetails,
        ]);
    }
}
