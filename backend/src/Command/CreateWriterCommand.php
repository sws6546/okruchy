<?php

namespace App\Command;

use App\Entity\Writer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-writer',
    description: 'Tworzy nowego użytkownika Writer (username, email, hasło)',
)]
class CreateWriterCommand extends Command
{
    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $username = $io->ask('Username');
        $email = $io->ask('Email');
        $password = $io->askHidden('Hasło');

        if (!$username || !$email || !$password) {
            $io->error('Username, email i hasło są wymagane.');

            return Command::FAILURE;
        }

        $existing = $this->em->getRepository(Writer::class)->findOneBy(['email' => $email]);
        if ($existing !== null) {
            $io->error("Użytkownik z emailem \"$email\" już istnieje.");

            return Command::FAILURE;
        }

        $writer = new Writer();
        $writer->setUsername($username);
        $writer->setEmail($email);
        $writer->setPassword(password_hash($password, PASSWORD_DEFAULT));

        $this->em->persist($writer);
        $this->em->flush();

        $io->success("Utworzono użytkownika \"$username\" ($email).");

        return Command::SUCCESS;
    }
}
