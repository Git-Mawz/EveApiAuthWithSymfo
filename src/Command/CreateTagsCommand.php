<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateTagsCommand extends Command
{
    protected static $defaultName = 'app:create-tags';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');


        $tags = [
            'PvE',
            'PvP',
            'Triglavian',
            'Industrie',
            'Minage',
            'Exploration',
            'Interaction Planétaire',
            'Corporation',
            'Alliance',
            'Incursion',
            'Mission',
            'Transport',
            'Ratting',
            'Compétences',
            'Commerce',
            'Empire',
            'Low-Sec',
            'Null-Sec',
            'High-Sec',
            'Wormhole',
            'Fitting',
            'Lore',
            'Ship'
        ];


        foreach ($tags as $tag) {
            $newTag = new \App\Entity\Tag();
            $newTag->setName($tag);
            $this->em->persist($newTag);
        }

        $this->em->flush();

        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

        $io->success('Les Tags on bien été ajouté !');

        return 0;
    }
}
