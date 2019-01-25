<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Service\MovieLister;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/popular", name="home")
     * @param Request $request
     * @param MovieLister $movieLister
     * @return Response
     */
    public function index(Request $request, MovieLister $movieLister) :Response
    {
        $form = $this->createForm(
            SearchType::class
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $searchData = $data['search'];
            $searchDataResult = implode('+', explode(' ', $searchData));

            $movieResults = ($movieLister->listMovieByTitle($searchDataResult))['results'];

            return $this->render('movie/searchResults.html.twig', [
                'movieResults' => $movieResults,
            ]);
        }

        $popularMovies = $movieLister->listPopularMovies();

        return $this->render('home/index.html.twig', [
            'popularMovies' => $popularMovies,
            'form' => $form->createView(),
        ]);
    }
}
