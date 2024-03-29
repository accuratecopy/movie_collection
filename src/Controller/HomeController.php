<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Service\MovieLister;
use App\Service\PeopleLister;
use App\Service\TVShowLister;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/home")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @param MovieLister $movieLister
     * @param TVShowLister $tvShowLister
     * @return Response
     */
    public function index(Request $request, MovieLister $movieLister, TVShowLister $tvShowLister, PeopleLister $peopleLister) :Response
    {
        $form = $this->createForm(
            SearchType::class
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $searchData = $data['search'];
            $searchDataResult = implode('+', explode(' ', $searchData));

            $searchMediaType = $data['media_type'];

            switch ($searchMediaType) {
                case 'movie':
                    $movieResults = ($movieLister->listMovieByTitle($searchDataResult))['results'];

                    return $this->render('movie/searchResults.html.twig', [
                        'movieResultsNumber' => count($movieResults),
                        'movieResults' => $movieResults,
                        'searchData' => $searchData
                    ]);

                case 'tv_show':
                    $tvShowResults = ($tvShowLister->listTVShowByTitle($searchDataResult))['results'];

                    return $this->render('tv_show/searchResults.html.twig', [
                        'tvShowResultsNumber' => count($tvShowResults),
                        'tvShowResults' => $tvShowResults,
                        'searchData' => $searchData
                    ]);

                case 'people':
                    $peopleResults = ($peopleLister->listPeopleByName($searchDataResult))['results'];

                    return $this->render('people/searchResults.html.twig', [
                        'peopleResultsNumber' => count($peopleResults),
                        'peopleResults' => $peopleResults,
                        'searchData' => $searchData
                    ]);
            }
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
