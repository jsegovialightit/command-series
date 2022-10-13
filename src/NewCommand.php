<?php namespace Acme;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GuzzleHttp\ClientInterface;

class NewCommand extends Command {

    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;

        parent::__construct();
    }

    public function configure()
    {
        $this->setName('new')
            ->setDescription('Create a new Laravel application.')
            ->addArgument('name', InputArgument::REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        // DONE - assert that the folder dosen't already exist
        $directory = getcwd() . '/' . $input->getArgument('name');
        $this->assertApplicationDoesNotExist($directory, $output);

        // download nightly version of Laravel
        $this->download($this->makeFileName())
             ->extract();

        // extract zip file


        // alert the user that they are ready to go


        return 0; //I had to add this return due to an error in console to execute ./laracasts sayHelloTo hello
    }
    //./laracasts sayHelloTo hello --greeting "Hi"
    
    private function assertApplicationDoesNotExist($directory, OutputInterface $output)
    {
        if (is_dir($directory))
        {
            $output->writeln('<error>Application already exists!<error>');

            exit(1);
        }

    }

    private function makeFileName()
    {
        return getcwd() . '/laravel_' . md5(time().uniqid()) . '.zip';
    }


    private function download($zipFile)
    {
        // crontab: http://cabinet.laravel.com/latest.zip
        $response = $this->client->get('http://cabinet.laravel.com/latest.zip')->getBody();

        file_put_contents($zipFile, $response);

        return $this;
    }


}