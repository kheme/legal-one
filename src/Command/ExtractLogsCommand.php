<?php

namespace App\Command;

use App\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class ExtractLogsCommand extends Command
{
    protected static $defaultName = 'log:extract';

    public function __construct(private EntityManagerInterface $entity_manager, private ContainerBagInterface $container)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Parses and extracts logs from file into database')
            ->addArgument(
                'log-path',
                InputArgument::OPTIONAL,
                'Path to file containing logs',
                $_ENV['LOGS_PATH'] ?? 'logs.log'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $entity_manager = $this->entity_manager;

        if (! file_exists($log_path = $input->getArgument('log-path'))) {
            $io->error('Log file does not exist!');
            $io->info('Aborting...');
        }

        $io->info('Reading log file...');

        $file = file($log_path);

        $io->info('Inserting records...');

        $progress_bar = new ProgressBar($output, $record_count = count($file));
        $progress_bar->start();

        foreach (file($log_path) as $key => $record) {
            $record = str_replace('- - ', '', $record);

            [ $service, $timestamp, $timezone, $method, $url, $http, $status ] = array_map(fn ($item) => trim($item), explode(' ', $record));

            $entry = new Log();
            $entry->setService($service);
            $entry->setMethod(str_replace('"', '', $method));
            $entry->setUrl($url);
            $entry->setHttp(str_replace('"', '', $http));
            $entry->setStatus($status);
            $entry->setTimezone(str_replace(']', '', $timezone));
            $entry->setCreatedAt(new \DateTime(str_replace('[', '', $timestamp) . ' ' . $entry->getTimezone()));

            $entity_manager->persist($entry);

            $progress_bar->advance();

            if ($key % min(10000, $record_count - 1) == 0) {
                $entity_manager->flush();
            }
        }

        $progress_bar->finish();

        $io->info('All done!');

        return 0;
    }
}