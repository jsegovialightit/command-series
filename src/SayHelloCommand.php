<?php namespace Acme;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class SayHelloCommand extends Command {

    public function configure()
    {
        $this->setName('sayHelloTo')
            ->setDescription('Offer a greeting to the given person. This command needs one argument.')
            ->addArgument('name', InputArgument::REQUIRED, 'Your name.') //::OPTIONAL
            ->addOption('greeting', null, InputOption::VALUE_OPTIONAL, 'Override the default greeting', 'Hello');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        //$message = 'Hello World: ' . $input->getArgument('name');
        
        $message = sprintf('%s, %s', $input->getOption('greeting'), $input->getArgument('name'));

        $output->writeln("<info>{$message}<info>");
        return 0; //I had to add this return due to an error in console to execute ./laracasts sayHelloTo hello
    }
    //./laracasts sayHelloTo hello --greeting "Hi"
    
}