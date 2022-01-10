<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $nationality;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $flag;

    #[ORM\ManyToMany(targetEntity: Game::class, mappedBy: 'countries')]
    private $games;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Publisher::class)]
    private $publishers;

    public function __construct()
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

    public function getFlag(): ?string
    {
        return $this->flag;
    }

    public function setFlag(?string $flag): self
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * @return Collection|Game[]
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
     * @return Collection|Publisher[]
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
}
