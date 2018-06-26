<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class AppCreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';

    private $em;

    public function __construct(\Doctrine\ORM\EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
            ->addArgument('password', InputArgument::REQUIRED, 'Password')
            ->addArgument('email', InputArgument::REQUIRED, 'email')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $email = $input->getArgument('email');

        if ($username && $password && $email) {
            $io->note(sprintf('Username: %s', $username));
            $io->note(sprintf('Password: %s', $password));
            $io->note(sprintf('Email: %s', $email));

            $user = new User();
            $user->setUsername($username)
                ->setPassword($password)
                ->setEmail($email)
                ->setApiKey(hash('sha256', $username.$password.$email.time()));

            $this->em->persist($user);
            $this->em->flush();
        }

        /*
        if ($input->getOption('option1')) {
            // ...
        }*/

        $io->success('User \''.$username.'\' created successfully!');
    }
}
