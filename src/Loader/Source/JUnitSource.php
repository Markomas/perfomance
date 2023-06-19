<?php

namespace App\Loader\Source;

class JUnitSource implements SourceInterface
{
    public function load(string $file): array
    {
        $out = [];
        $xml = simplexml_load_file($file);
        foreach ($xml->testsuite as $testSuite) {
            $out[(string)$testSuite['name']]['time'] = isset($testSuite['time']) ? (float)$testSuite['time'] : 0;
            foreach ($testSuite->testcase as $testcase) {
                $out[(string)$testSuite['name']]['cases'][(string)$testcase['name']]['time']
                    = isset($testcase['time']) ? (float)$testcase['time'] : 0;
            }
        }
        return $out;
    }
}