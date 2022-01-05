<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'home_index')]
    public function index(GameRepository $gameRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'gamesAlpha' => $gameRepository->findLimitedGames('name', 'ASC'),
            'gamesLast' => $gameRepository->findLimitedGames('publishedAt', 'DESC',5),
        ]);
    }
}
