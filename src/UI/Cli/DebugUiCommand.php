<?php

namespace UI\Cli;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use UI\Http\Shared\Menu\MenuProviderInterface;
use UI\Http\Shared\Topbar\TopbarProviderInterface;

#[AsCommand(
    name: 'app:debug:ui',
    description: 'Affiche la liste des menus et topbar enregistrés avec leurs priorités et providers.',
)]
class DebugUiCommand extends Command
{
    public function __construct(
        #[TaggedIterator('app.menu_provider')] private iterable $menuProviders,
        #[TaggedIterator('app.topbar_provider')] private iterable $topbarProviders,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Debug de l\'Interface Utilisateur Dynamique');

        // --- SECTION SIDEBAR MENU ---
        $io->section('Sidebar Menu Items');
        $menuTable = new Table($output);
        $menuTable->setHeaders(['Label', 'Route', 'Icon', 'Children', 'Provider']);
        
        foreach ($this->menuProviders as $provider) {
            foreach ($provider->provide() as $item) {
                $menuTable->addRow([
                    $item->label,
                    $item->routeName ?? '-',
                    $item->icon ?? '-',
                    count($item->children),
                    get_class($provider)
                ]);
            }
        }
        $menuTable->render();

        $io->newLine();

        // --- SECTION TOPBAR ---
        $io->section('Topbar Items (par Slot & Priorité)');
        $topbarTable = new Table($output);
        $topbarTable->setHeaders(['Slot', 'Prio', 'Label', 'Route/Template', 'Icon', 'Provider']);

        $allTopbarItems = [];
        foreach ($this->topbarProviders as $provider) {
            foreach ($provider->provide() as $item) {
                $allTopbarItems[] = [
                    'item' => $item,
                    'provider' => get_class($provider)
                ];
            }
        }

        // Tri par Slot puis par Priorité
        usort($allTopbarItems, function($a, $b) {
            if ($a['item']->slot === $b['item']->slot) {
                return $a['item']->priority <=> $b['item']->priority;
            }
            return $a['item']->slot <=> $b['item']->slot;
        });

        foreach ($allTopbarItems as $entry) {
            $item = $entry['item'];
            $topbarTable->addRow([
                strtoupper($item->slot),
                $item->priority,
                $item->label,
                $item->hasTemplate() ? '[TPL] ' . $item->template : ($item->routeName ?? '-'),
                $item->icon ?? '-',
                $entry['provider']
            ]);
        }
        $topbarTable->render();

        return Command::SUCCESS;
    }
}
