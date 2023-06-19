<?php

namespace App\Entity;

use App\Repository\TestCaseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestCaseRepository::class)]
class TestCase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $time = null;

    #[ORM\ManyToOne(inversedBy: 'testCases')]
    private ?TestSuite $testSuite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTime(): ?float
    {
        return $this->time;
    }

    public function setTime(float $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getTestSuite(): ?TestSuite
    {
        return $this->testSuite;
    }

    public function setTestSuite(?TestSuite $testSuite): static
    {
        $this->testSuite = $testSuite;

        return $this;
    }
}
