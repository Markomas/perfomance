<?php

namespace App\Entity;

use App\Repository\RunRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RunRepository::class)]
class Run
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datetime = null;

    #[ORM\ManyToOne(inversedBy: 'runs')]
    private ?Project $project = null;

    #[ORM\OneToMany(mappedBy: 'run', targetEntity: TestSuite::class)]
    private Collection $testSuites;

    public function __construct()
    {
        $this->testSuites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): static
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return Collection<int, TestSuite>
     */
    public function getTestSuites(): Collection
    {
        return $this->testSuites;
    }

    public function addTestSuite(TestSuite $testSuite): static
    {
        if (!$this->testSuites->contains($testSuite)) {
            $this->testSuites->add($testSuite);
            $testSuite->setRun($this);
        }

        return $this;
    }

    public function removeTestSuite(TestSuite $testSuite): static
    {
        if ($this->testSuites->removeElement($testSuite)) {
            // set the owning side to null (unless already changed)
            if ($testSuite->getRun() === $this) {
                $testSuite->setRun(null);
            }
        }

        return $this;
    }
}
