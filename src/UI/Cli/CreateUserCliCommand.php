<?php

namespace UI\Cli;

use Application\User\Command\RegisterUserCommand;
use Domain\User\Repository\RightRepositoryInterface;
use Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:user:create',
    description: 'Cree un utilisateur depuis la ligne de commande.',
)]
final class CreateUserCliCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $bus,
        private readonly UserRepositoryInterface $userRepository,
        private readonly RightRepositoryInterface $rightRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('login', InputArgument::REQUIRED, 'Login unique')
            ->addArgument('lastname', InputArgument::REQUIRED, 'Nom')
            ->addArgument('firstname', InputArgument::REQUIRED, 'Prenom')
            ->addArgument('mail', InputArgument::REQUIRED, 'Adresse email')
            ->addArgument('password', InputArgument::REQUIRED, 'Mot de passe en clair')
            ->addOption('inactive', null, InputOption::VALUE_NONE, 'Cree un utilisateur inactif')
            ->addOption('group-id', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'ID de groupe (option repetable)')
            ->addOption('profile-id', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'ID de profil (option repetable)')
            ->addOption('right-id', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'ID de droit (option repetable)')
            ->addOption('right-code', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Code de droit, ex: admin (option repetable)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $login = (string) $input->getArgument('login');
        $mail = (string) $input->getArgument('mail');

        if ($this->userRepository->findByLogin($login)) {
            $io->error(sprintf('Le login "%s" existe deja.', $login));
            return Command::FAILURE;
        }

        if ($this->userRepository->findByMail($mail)) {
            $io->error(sprintf('L\'email "%s" existe deja.', $mail));
            return Command::FAILURE;
        }

        $rightIds = array_values(array_filter((array) $input->getOption('right-id')));
        foreach ((array) $input->getOption('right-code') as $rightCode) {
            $right = $this->rightRepository->findByCode((string) $rightCode);
            if (!$right) {
                $io->error(sprintf('Droit introuvable pour le code "%s".', $rightCode));
                return Command::FAILURE;
            }
            $rightIds[] = (string) $right->getId();
        }
        $rightIds = array_values(array_unique($rightIds));

        $command = new RegisterUserCommand(
            login: $login,
            lastname: (string) $input->getArgument('lastname'),
            firstname: (string) $input->getArgument('firstname'),
            mail: $mail,
            password: (string) $input->getArgument('password'),
            isActive: !$input->getOption('inactive'),
            groupIds: array_values(array_filter((array) $input->getOption('group-id'))),
            profileIds: array_values(array_filter((array) $input->getOption('profile-id'))),
            rightIds: $rightIds
        );

        try {
            $this->bus->dispatch($command);
            $io->success(sprintf('Utilisateur "%s" cree avec succes.', $login));
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}
