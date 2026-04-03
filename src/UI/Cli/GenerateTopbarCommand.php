<?php

namespace UI\Cli;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:generate:topbar',
    description: 'Génère un TopbarProvider pour une feature.',
)]
class GenerateTopbarCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('feature', InputArgument::REQUIRED, 'Le nom de la feature (ex: Facturation)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $feature = ucfirst($input->getArgument('feature'));
        
        $path = "src/UI/Http/Admin/Topbar/{$feature}TopbarProvider.php";
        $dir = dirname($path);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (file_exists($path)) {
            $io->error("Le fichier $path existe déjà.");
            return Command::FAILURE;
        }

        $content = <<<PHP
<?php

namespace UI\Http\Admin\Topbar;

use UI\Http\Shared\Topbar\TopbarItem;
use UI\Http\Shared\Topbar\TopbarProviderInterface;

final class {$feature}TopbarProvider implements TopbarProviderInterface
{
    public function provide(): array
    {
        return [
            new TopbarItem(
                label: '{$feature}',
                icon: 'ti ti-star',
                routeName: 'admin_dashboard', // TODO: Adapter la route
                slot: TopbarItem::SLOT_RIGHT,
                priority: 50
            ),
        ];
    }
}
PHP;

        file_put_contents($path, $content);

        $io->success("TopbarProvider créé avec succès : $path");

        return Command::SUCCESS;
    }
}
