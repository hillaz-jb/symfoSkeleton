<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AccountFormType;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/accounts', name: '')]

class AccountController extends AbstractController
{
    private EntityManagerInterface $em;
    private AccountRepository $accountRepository;

    /**
     * @param EntityManagerInterface $em
     * @param AccountRepository $accountRepository
     */
    public function __construct(EntityManagerInterface $em, AccountRepository $accountRepository)
    {
        $this->em = $em;
        $this->accountRepository = $accountRepository;
    }

    #[Route('/', name: 'account_index')]
    public function index(AccountRepository $accountRepository): Response
    {
        return $this->render('account/index.html.twig', [
            'accounts' => $this->accountRepository->findLimitedNbAccount(50),
        ]);
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/{id}', name: 'account_show')]
    public function show($id): Response
    {
        return $this->render('account/show.html.twig', [
            'account' => $this->accountRepository->findOneDetailedAccount($id),
        ]);
    }

    #[Route('/new', name: 'account_new')]
    public function createAccount(Request $request): Response {
        $form = $this->createForm(AccountFormType::class, new Account());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $form->isValid()) {
            $this->em->persist($form->getData());
            $this->em->flush();
            return $this->redirectToRoute('account_index');
        }
        return $this->render('account/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
