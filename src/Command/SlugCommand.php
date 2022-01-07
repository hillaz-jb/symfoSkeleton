<?php
namespace App\Command;
use App\Entity\Game;
use App\Repository\GameRepository;


use App\Service\TextService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SlugCommand extends Command
{

    private TextService $textService;
    private GameRepository $gameRepository;
    private EntityManagerInterface $entityManager;


    public function __construct(
        TextService $textService,
        GameRepository $gameRepository,
        EntityManagerInterface $entityManager
    )
    {
        parent::__construct();
        $this->textService = $textService;
        $this->gameRepository = $gameRepository;
        $this->entityManager = $entityManager;
    }

    public function configure()
    {
        $this->setName('app:SlugThis');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Command starting...');
        $games = $this->gameRepository->findAll();
        $progressBar = new ProgressBar($output, count($games));
        $progressBar->start();
        foreach ($games as $game){
            $gameSlugified = $game->setSlug($this->textService->slugify($game->getName()));
            $this->entityManager->persist($gameSlugified);
            $this->entityManager->flush();
            $progressBar->advance();
        }

        $progressBar->finish();
        $output->writeln('Command finished !');
        return 0;
    }


    /**
     * @return TextService
     */
    public function getTextService(): TextService
    {
        return $this->textService;
    }

    /**
     * @param TextService $textService
     */
    public function setTextService(TextService $textService): void
    {
        $this->textService = $textService;
    }

    /**
     * @return GameRepository
     */
    public function getGameRepository(): GameRepository
    {
        return $this->gameRepository;
    }

    /**
     * @param GameRepository $gameRepository
     */
    public function setGameRepository(GameRepository $gameRepository): void
    {
        $this->gameRepository = $gameRepository;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }
}