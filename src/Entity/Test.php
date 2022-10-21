<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $testName = null;

    #[ORM\Column]
    private ?int $nbtest = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTestName(): ?string
    {
        return $this->testName;
    }

    public function setTestName(string $testName): self
    {
        $this->testName = $testName;

        return $this;
    }

    public function getNbtest(): ?int
    {
        return $this->nbtest;
    }

    public function setNbtest(int $nbtest): self
    {
        $this->nbtest = $nbtest;

        return $this;
    }
}
