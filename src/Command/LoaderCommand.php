<?php

namespace App\Command;

use App\Loader\Loader;
use App\Loader\Source\JUnitSource;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LoaderCommand extends Command
{
    /**
     * @var JUnitSource
     */
    private $source;
    /**
     * @var Loader
     */
    private $loader;

    public function __construct(JUnitSource $source, Loader $loader, string $name = null)
    {
        parent::__construct($name);
        $this->source = $source;
        $this->loader = $loader;
    }

    protected static $defaultName = 'app:loader';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $file = 'test.xml';
        $data = $this->source->load($file);

        $this->loader->load($data, 'something', new \DateTimeImmutable('2022-01-08'));

        return Command::SUCCESS;
    }
}
