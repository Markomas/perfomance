<?php

namespace App\Exporter;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;

class Exporter
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }
    public function export()
    {
        $out = [];
        /** @var Project $project */
        $projects = $this->em->getRepository(Project::class)->findAll();
        foreach ($projects as $project) {
            foreach ($project->getRuns() as $run) {
                foreach ($run->getTestSuites() as $suite) {
                    foreach ($suite->getTestCases() as $test) {
                        $out[] = [
                            'project' => $project->getName(),
                            'timestamp' => $run->getDatetime()->getTimestamp(),
                            'testsuite' => $suite->getName(),
                            'testcase' => $test->getName(),
                            'time' => $test->getTime(),
                        ];
                    }
                }
            }
        }

        file_put_contents('out.json', json_encode($out, JSON_PRETTY_PRINT));
    }
}