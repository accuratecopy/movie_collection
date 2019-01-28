<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Service\MovieLister;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/movie")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("/", name="movie")
     * @param MovieLister $movieLister
     * @return Response
     */
    public function index(MovieLister $movieLister) :Response
    {
        $popularMovies = $movieLister->listPopularMovies();

        return $this->render('movie/index.html.twig', [
            'popularMovies' => $popularMovies,
        ]);
    }

    /**
     * @Route("/collection", name="movie_collection")
     * @param MovieLister $movieLister
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function indexCollection(MovieLister $movieLister, MovieRepository $movieRepository) :Response
    {
        $movies = $movieRepository->findAll();
        foreach($movies as $movie) {
            $movieJsons[] = $movieLister->listMovie($movie->getMovieId());
        }

        return $this->render('movie/collection.html.twig', [
            'movieJsons' => $movieJsons,
        ]);
    }

    /**
     * @Route("/{movieId}", name="movie_show")
     * @param MovieLister $movieLister
     * @param int $movieId
     * @return Response
     * @ParamConverter("movieId", options={"movieId" = "id"})
     */
    public function show(MovieLister $movieLister, int $movieId) :Response
    {
        $movieDetails = $movieLister->listOneMovieById($movieId);
        $movieCasts = $movieLister->listMovieCastById($movieId)['cast'];

        return $this->render('movie/show.html.twig', [
            'movieDetails' => $movieDetails,
            'movieCasts' => $movieCasts,
        ]);
    }

    /**
     * @Route("/add/{movieId}", name="movie_add")
     * @param int $movieId
     * @param EntityManagerInterface $em
     * @return Response
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

    /**
     * @Route("/remove/{movieId}", name="movie_remove")
     * @param int $movieId
     * @param MovieRepository $movieRepository
     * @param EntityManagerInterface $em
     * @return Response
     * @ParamConverter("movieId", options={"movieId" = "id"})
     */
    public function removeMovie(int $movieId, MovieRepository $movieRepository, EntityManagerInterface $em) : Response
    {
        $movie = $movieRepository->findOneBy(['movieId' => $movieId]);

        $em->remove($movie);
        $em->flush();

        return $this->redirectToRoute('movie_collection');
    }
}
