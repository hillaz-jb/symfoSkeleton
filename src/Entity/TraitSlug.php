<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait TraitSlug
{
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $slug;

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }


}