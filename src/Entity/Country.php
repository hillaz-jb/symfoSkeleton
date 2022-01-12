<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[UniqueEntity(
    fields: ['name'],
    message: 'common.constraints.unique',
)]
#[UniqueEntity(
    fields: ['code'],
    message: 'common.constraints.unique',
)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nationality;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $urlFlag;

    #[ORM\ManyToMany(targetEntity: Game::class, mappedBy: 'countries')]
    private Collection $games;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Publisher::class)]
    private Collection $publishers;

    #[ORM\Column(type: 'string', length: 6)]
    #[Assert\Length(
        min: '2',
        max: '6',
        minMessage: 'country.constraints.code.min_length',
        maxMessage: 'country.constraints.code.max_length'
    )]
    private string $code;

    #[Pure] public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->publishers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getUrlFlag(): ?string
    {
        return $this->urlFlag;
    }

    public function setUrlFlag(?string $urlFlag): self
    {
        $this->urlFlag = $urlFlag;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->addCountry($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            $game->removeCountry($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPublishers(): Collection
    {
        return $this->publishers;
    }

    public function addPublisher(Publisher $publisher): self
    {
        if (!$this->publishers->contains($publisher)) {
            $this->publishers[] = $publisher;
            $publisher->setCountry($this);
        }

        return $this;
    }

    public function removePublisher(Publisher $publisher): self
    {
        if ($this->publishers->removeElement($publisher)) {
            // set the owning side to null (unless already changed)
            if ($publisher->getCountry() === $this) {
                $publisher->setCountry(null);
            }
        }

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
