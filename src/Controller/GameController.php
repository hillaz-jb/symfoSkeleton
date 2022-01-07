<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\CommentRepository;
use App\Repository\GameRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/games')]

class GameController extends AbstractController
{
    private GameRepository $gameRepository;
    private CommentRepository $commentRepository;

    public function __construct(GameRepository $gameRepository, CommentRepository $commentRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->commentRepository = $commentRepository;
    }

    #[Route('/', name: 'game_index')]
    public function index(): Response
    {
        return $this->render('game/index.html.twig', [
            'games' => $this->gameRepository->findAll(),
        ]);
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/{slug}', name: 'game_show')]
    public function show($slug): Response
    {
        $game = $this->gameRepository->findOneDetailedGame($slug);
        return $this->render('game/show.html.twig', [
            'game' => $game,
            'lastComments' => $this->commentRepository->findOneGameLimitedComments($game->getId(),'createdAt', 'DESC',5),
            'bestComments' => $this->commentRepository->findOneGameLimitedComments($game->getId(),'upVotes', 'DESC',5),
        ]);
    }
}
