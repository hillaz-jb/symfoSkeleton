<?php

namespace App\Controller;

use App\Entity\Country;
use App\Form\CountryFormType;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{

    private EntityManagerInterface $em;
    private CountryRepository $countryRepository;
    /**
     * @param EntityManagerInterface $em
     * @param CountryRepository $countryRepository
     */
    public function __construct(EntityManagerInterface $em, CountryRepository $countryRepository)
    {
        $this->em = $em;
        $this->countryRepository = $countryRepository;
    }

    #[Route('/countries', name: 'countries_index')]
    public function index(): Response
    {
        return $this->render('country/index.html.twig', [
            'controller_name' => 'CountryController',
        ]);
    }

    #[Route('/countries/new', name: 'country_new')]
    public function createCountry(Request $request): Response {
        $form = $this->createForm(CountryFormType::class, new Country());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $form->isValid()) {
            $this->em->persist($form->getData());
            $this->em->flush();
            return $this->redirectToRoute('countries_index');
        }
        return $this->render('country/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
