<?php

namespace App\Controller;

use App\Entity\TVShow;
use App\Repository\TVShowRepository;
use App\Service\TVShowLister;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tv_show")
 */
class TVShowController extends AbstractController
{
    /**
     * @Route("/", name="tv_show")
     * @param TVShowLister $tvShowLister
     * @return Response
     */
    public function index(TVShowLister $tvShowLister) : Response
    {
        $popularTVShows = $tvShowLister->listPopularTVShows();

        return $this->render('tv_show/index.html.twig', [
            'popularTVShows' => $popularTVShows,
        ]);
    }

    /**
     * @Route("/collection", name="tv_show_collection")
     * @param TVShowLister $tvShowLister
     * @param TVShowRepository $tvShowRepository
     * @return Response
     */
    public function indexCollection(TVShowLister $tvShowLister, TVShowRepository $tvShowRepository) :Response
    {
        $tvShows = $tvShowRepository->findAll();

        foreach($tvShows as $tvShow) {
            $tvShowJsons[] = $tvShowLister->listTVShow($tvShow->getTvShowId());
        }

        return $this->render('tv_show/collection.html.twig', [
            'tvShowJsons' => $tvShowJsons,
        ]);
    }

    /**
     * @Route("/{tvShowId}", name="tv_show_show")
     * @param TVShowLister $tvShowLister
     * @param int $tvShowId
     * @return Response
     * @ParamConverter("tvShowId", options={"tvShowId" = "id"})
     */
    public function show(TVShowLister $tvShowLister, int $tvShowId) :Response
    {
        $tvShowDetails = $tvShowLister->listOneTVShowById($tvShowId);
        return $this->render('tv_show/show.html.twig', [
            'tvShowDetails' => $tvShowDetails,
        ]);
    }

    /**
     * @Route("/add/{tvShowId}", name="tv_show_add")
     * @param int $tvShowId
     * @param EntityManagerInterface $em
     * @return Response
     * @ParamConverter("tvShowId", options={"tvShowId" = "id"})
     */
    public function addTVShow(int $tvShowId, EntityManagerInterface $em) : Response
    {
        $tvShow = new TVShow();
        $tvShow->setTvShowId($tvShowId);

        $tvShow->addUserId($this->getUser());

        $em->persist($tvShow);
        $em->flush();

        return $this->redirectToRoute('tv_show_collection');
    }

    /**
     * @Route("/remove/{tvShowId}", name="tv_show_remove")
     * @param int $tvShowId
     * @param TVShowRepository $tvShowRepository
     * @param EntityManagerInterface $em
     * @return Response
     * @ParamConverter("movieId", options={"movieId" = "id"})
     */
    public function removeMovie(int $tvShowId, TVShowRepository $tvShowRepository, EntityManagerInterface $em) : Response
    {
        $tvShow = $tvShowRepository->findOneBy(['tvShowId' => $tvShowId]);

        $em->remove($tvShow);
        $em->flush();

        return $this->redirectToRoute('tv_show_collection');
    }

}
