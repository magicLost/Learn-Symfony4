<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class HomeStatsCommand extends Command
{
    protected static $defaultName = 'home:stats';

    protected function configure()
    {
        $this
            ->setDescription('This command do nothing, case it is very lazy')
            ->addArgument('slug', InputArgument::OPTIONAL, 'Slug? What the fuck?')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'The output format', 'text')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $slug = $input->getArgument('slug');

        $data = [
            'slug' => $slug,
            'hearts' => rand(10, 100),
        ];

        switch($input->getOption(('format'))){
            case 'text':

                $rows = [];
                foreach($data as $key=>$val){
                    $rows[] = [$key, $val];
                }
                $io->table(['Key', 'Value'], $rows);

                break;
            case 'json':

                $io->write(json_encode($data));

                break;
            default:
                throw new \Exception('What kind of crazy format is that!?');
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}

