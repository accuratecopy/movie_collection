<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Service\MovieLister;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/movies", name="movie_collection")
     */
    public function index(MovieLister $movieLister, MovieRepository $movieRepository)
    {
        $movies = $movieRepository->findAll();
        foreach($movies as $movie) {
            $movieJsons[] = $movieLister->listMovie($movie->getMovieId());
        }

        return $this->render('movie/index.html.twig', [
            'movieJsons' => $movieJsons,
        ]);
    }

    /**
     * @Route("/movie/{movieId}", name="movie_show")
     * @param MovieLister $movieLister
     * @param int $movieId
     * @return Response
     * @ParamConverter("movieId", options={"movieId" = "id"})
     */
    public function show(MovieLister $movieLister, int $movieId) :Response
    {
        $movieDetails = $movieLister->listOneMovieById($movieId);
        return $this->render('movie/show.html.twig', [
            'movieDetails' => $movieDetails,
        ]);
    }

    /**
     * @Route("/movie/add/{movieId}", name="movie_add")
     * @param int $movieId
     * @param EntityManager $em
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @ParamConverter("movieId", options={"movieId" = "id"})
     */
    public function addMovie(int $movieId, EntityManagerInterface $em) : Response
    {
        $movie = new Movie();
        $movie->setMovieId($movieId);

        $movie->addUserId($this->getUser());

        $em->persist($movie);
        $em->flush();

        return $this->redirectToRoute('movie_collection');
    }

    public function deleteMovie(int $movieId, MovieRepository $movieRepository, EntityManagerInterface $em) : Response
    {
    }
}
