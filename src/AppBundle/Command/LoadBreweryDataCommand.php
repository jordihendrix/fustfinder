<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class LoadBreweryDataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:load:brewerydata')
                ->setDescription('Imports brewery and beer data.')
                ->setHelp('This command allows you to load brewery and beer data from an external source in order to (re)populate the database.')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $oberon = $this->getContainer()->get('oberon_brewery_data');
        
        $output->writeln([
            'Brewery Data Import',
            '===================',
        ]);

        // Delete existing data
        $confirmDelete = new ConfirmationQuestion('Importing new data will remove all existing data. Continue [n]?', false);
        if (!$helper->ask($input, $output, $confirmDelete)) {
            $output->writeln('Import aborted.');
            return;
        }
        $beerQuery = $em->createQuery('delete from AppBundle:Beer b');
        $beerQuery->execute();
        $breweryQuery = $em->createQuery('delete from AppBundle:Brewery b');
        $breweryQuery->execute();
        
        // Load brewery data
        $breweryUrlQuestion = new Question('Where should the brewery data be imported from [http://downloads.oberon.nl/opdracht/brouwerijen.php]?', 'http://downloads.oberon.nl/opdracht/brouwerijen.php');
        $breweryUrl = $helper->ask($input, $output, $breweryUrlQuestion);
        $oberon->loadBreweries($breweryUrl);
        
        // Load beer data
        $beerUrlQuestion = new Question('Where should the beer data be imported from [http://downloads.oberon.nl/opdracht/bieren.php]?', 'http://downloads.oberon.nl/opdracht/bieren.php');
        $beerUrl = $helper->ask($input, $output, $beerUrlQuestion);
        $oberon->loadBeers($beerUrl);
        
        $output->writeln('Import completed.');
    }
}