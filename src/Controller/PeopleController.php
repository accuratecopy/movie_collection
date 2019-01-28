<?php

namespace App\Controller;

use App\Entity\People;
use App\Repository\PeopleRepository;
use App\Service\PeopleLister;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/people")
 */
class PeopleController extends AbstractController
{
    /**
     * @Route("/", name="people")
     * @param PeopleLister $peopleLister
     * @return Response
     */
    public function index(PeopleLister $peopleLister) :Response
    {
        $popularPeople = $peopleLister->listPopularPeople();

        return $this->render('people/index.html.twig', [
            'popularPeople' => $popularPeople,
        ]);
    }

    /**
     * @Route("/collection", name="people_collection")
     * @param PeopleLister $peopleLister
     * @param PeopleRepository $peopleRepository
     * @return Response
     */
    public function indexCollection(PeopleLister $peopleLister, PeopleRepository $peopleRepository) :Response
    {
        $people = $peopleRepository->findAll();
        foreach($people as $person) {
            $peopleJsons[] = $peopleLister->listPeople($person->getPeopleId());
        }

        return $this->render('people/collection.html.twig', [
            'peopleJsons' => $peopleJsons,
        ]);
    }

    /**
     * @Route("/{peopleId}", name="people_show")
     * @param PeopleLister $peopleLister
     * @param int $peopleId
     * @return Response
     * @ParamConverter("peopleId", options={"peopleId" = "id"})
     */
    public function show(peopleLister $peopleLister, int $peopleId) :Response
    {
        $peopleDetails = $peopleLister->listOnePeopleById($peopleId);

        return $this->render('people/show.html.twig', [
            'peopleDetails' => $peopleDetails,
        ]);
    }

    /**
     * @Route("/add/{peopleId}", name="people_add")
     * @param int $peopleId
     * @param EntityManagerInterface $em
     * @return Response
     * @ParamConverter("peopleId", options={"peopleId" = "id"})
     */
    public function addPeople(int $peopleId, EntityManagerInterface $em) : Response
    {
        $people = new People();
        $people->setPeopleId($peopleId);

        $people->addUserId($this->getUser());

        $em->persist($people);
        $em->flush();

        return $this->redirectToRoute('people_collection');
    }

    /**
     * @Route("/remove/{peopleId}", name="people_remove")
     * @param int $peopleId
     * @param PeopleRepository $peopleRepository
     * @param EntityManagerInterface $em
     * @return Response
     * @ParamConverter("peopleId", options={"peopleId" = "id"})
     */
    public function removePeople(int $peopleId, PeopleRepository $peopleRepository, EntityManagerInterface $em) : Response
    {
        $people = $peopleRepository->findOneBy(['peopleId' => $peopleId]);

        $em->remove($people);
        $em->flush();

        return $this->redirectToRoute('people_collection');
    }
}
