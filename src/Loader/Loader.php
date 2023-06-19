<?php

namespace App\Loader;

use App\Entity\Project;
use App\Entity\Run;
use App\Entity\TestCase;
use App\Entity\TestSuite;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class Loader
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }
    public function load(array $data, string $projectName, \DateTimeImmutable $date)
    {
        $projectEntity = $this->loadProject($projectName);
        $runEntity = $this->loadRun($projectEntity, $date);

        foreach($data as $testSuiteName => $testSuiteData) {
            $testSuiteEntity = $this->loadTestSuite($runEntity, $testSuiteName, $testSuiteData);
            foreach ($testSuiteData['cases'] as $testCaseName => $testCaseData) {
                $testCaseEntity = $this->loadTestCase($testSuiteEntity, $testCaseName, $testCaseData);
            }
        }
        $this->em->flush();
    }

    private function loadProject(string $projectName)
    {
        $entity = $this->em->getRepository(Project::class)->findOneByName($projectName);
        if(!$entity) {
            $entity = new Project();
            $entity->setName($projectName);
            $this->em->persist($entity);
        }
        return $entity;
    }

    private function loadRun(Project $projectEntity, \DateTimeImmutable $date)
    {
        $entity = $this->em->getRepository(Run::class)->findOneBy(['project' => $projectEntity, 'datetime' => $date]);
        if(!$entity) {
            $entity = new Run();
            $entity->setProject($projectEntity);
            $entity->setDatetime($date);
            $this->em->persist($entity);
        }
        return $entity;
    }

    private function loadTestSuite(Run $runEntity, string $testSuiteName, array $testSuiteData)
    {
        $testSuiteEntity = $this->em->getRepository(TestSuite::class)->findOneBy(['run' => $runEntity, 'name' => $testSuiteName]);
        if(!$testSuiteEntity) {
            $testSuiteEntity = new TestSuite();
            $testSuiteEntity->setRun($runEntity);
            $testSuiteEntity->setName($testSuiteName);
            $testSuiteEntity->setTime($testSuiteData['time'] ?? 0);
            $testSuiteEntity->setFailed((bool)($testSuiteData['failures'] ?? 0));
            $this->em->persist($testSuiteEntity);
        }
        return $testSuiteEntity;
    }

    private function loadTestCase(TestSuite $testSuiteEntity, string $testCaseName, array $testCaseData)
    {
        $testCaseEntity = $this->em->getRepository(TestCase::class)->findOneBy(['testSuite' => $testSuiteEntity, 'name' => $testCaseName]);
        if(!$testCaseEntity) {
            $testCaseEntity = new TestCase();
            $testCaseEntity->setTestSuite($testSuiteEntity);
            $testCaseEntity->setName($testCaseName);
            $testCaseEntity->setTime(($testCaseData['time'] ?? 0) + rand(0, 10)/100);
            $this->em->persist($testCaseEntity);
        }
        return $testCaseEntity;
    }
}