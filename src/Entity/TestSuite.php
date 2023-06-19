<?php

namespace App\Entity;

use App\Repository\TestSuiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestSuiteRepository::class)]
class TestSuite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $time = null;

    #[ORM\Column]
    private ?bool $failed = false;

    #[ORM\ManyToOne(inversedBy: 'testSuites')]
    private ?Run $run = null;

    #[ORM\OneToMany(mappedBy: 'testSuite', targetEntity: TestCase::class)]
    private Collection $testCases;

    public function __construct()
    {
        $this->testCases = new ArrayCollection();
    }

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

    public function isFailed(): ?bool
    {
        return $this->failed;
    }

    public function setFailed(bool $failed): static
    {
        $this->failed = $failed;

        return $this;
    }

    public function getRun(): ?Run
    {
        return $this->run;
    }

    public function setRun(?Run $run): static
    {
        $this->run = $run;

        return $this;
    }

    /**
     * @return Collection<int, TestCase>
     */
    public function getTestCases(): Collection
    {
        return $this->testCases;
    }

    public function addTestCase(TestCase $testCase): static
    {
        if (!$this->testCases->contains($testCase)) {
            $this->testCases->add($testCase);
            $testCase->setTestSuite($this);
        }

        return $this;
    }

    public function removeTestCase(TestCase $testCase): static
    {
        if ($this->testCases->removeElement($testCase)) {
            // set the owning side to null (unless already changed)
            if ($testCase->getTestSuite() === $this) {
                $testCase->setTestSuite(null);
            }
        }

        return $this;
    }
}
