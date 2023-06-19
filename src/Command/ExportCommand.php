<?php

namespace App\Command;

use App\Exporter\Exporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:export',
    description: 'Add a short description for your command',
)]
class ExportCommand extends Command
{
    /**
     * @var Exporter
     */
    private $exporter;

    public function __construct(Exporter $exporter) {
        $this->exporter = $exporter;
        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->exporter->export();

        return Command::SUCCESS;
    }
}
