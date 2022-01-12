<?php

namespace App\Controller;

use App\Entity\Publisher;
use App\Form\PublisherFormType;
use App\Repository\PublisherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//TODO REGROUPER POUR SIMPLIFIER REQUETES NEW ET EDIT
//TODO SHOW

class PublisherController extends AbstractController
{
    private EntityManagerInterface $em;
    private PublisherRepository $publisherRepository;

    /**
     * @param EntityManagerInterface $em
     * @param PublisherRepository $publisherRepository
     */
    public function __construct(EntityManagerInterface $em, PublisherRepository $publisherRepository)
    {
        $this->em = $em;
        $this->publisherRepository = $publisherRepository;
    }

    #[Route('/publishers', name: 'publisher_index')]
    public function index(): Response
    {
        return $this->render('publisher/index.html.twig', [
            'publishers' => $this->publisherRepository->findAll(),
        ]);
    }

    #[Route('/publishers/new', name: 'publisher_new')]
    public function createCountry(Request $request): Response {
        $form = $this->createForm(PublisherFormType::class, new Publisher());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $form->isValid()) {
            $this->em->persist($form->getData());
            $this->em->flush();
            return $this->redirectToRoute('publisher_index');
        }
        return $this->render('publisher/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/publishers/edit/{id}', name: 'publisher_edit')]
    public function editCountry(Request $request, Publisher $publisher): Response {
        $form = $this->createForm(PublisherFormType::class, $publisher);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($form->getData());
            $this->em->flush();
            return $this->redirectToRoute('publisher_index');
        }
        return $this->render('publisher/edit.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
