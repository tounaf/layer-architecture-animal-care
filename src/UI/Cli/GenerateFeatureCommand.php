<?php

namespace UI\Cli;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:generate:feature',
    description: 'Génère le boilerplate pour un nouveau domaine avec options UI (Admin, Public, REST).',
)]
class GenerateFeatureCommand extends Command
{
    private string $skeletonDir;

    public function __construct()
    {
        parent::__construct();
        $this->skeletonDir = __DIR__ . '/templates/skeletons';
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Le nom du domaine (ex: Paiement)')
            ->addOption('admin', 'a', InputOption::VALUE_NONE, 'Générer un contrôleur Admin')
            ->addOption('public', 'p', InputOption::VALUE_NONE, 'Générer un contrôleur Public')
            ->addOption('rest', 'r', InputOption::VALUE_OPTIONAL, 'Générer un contrôleur REST (optionnel: admin, public, etc)')
            ->addOption('with-form', 'f', InputOption::VALUE_NONE, 'Générer un formulaire Symfony (si Admin ou Public)')
            ->addOption('with-template', 't', InputOption::VALUE_NONE, 'Générer des templates Twig (si Admin ou Public)')
            ->addOption('menu', 'm', InputOption::VALUE_NONE, 'Générer un MenuProvider pour la sidebar');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $name = ucfirst($input->getArgument('name'));
        $variableName = lcfirst($name);

        $commonVars = [
            '{{ name }}' => $name,
            '{{ name_lower }}' => strtolower($name),
            '{{ variableName }}' => $variableName,
        ];

        $files = [
            // Core DDD
            "src/Domain/$name/Entity/$name.php" => $this->render('domain/entity.tpl.php', $commonVars),
            "src/Domain/$name/Event/{$name}Cree.php" => $this->render('domain/event.tpl.php', $commonVars),
            "src/Domain/$name/Repository/{$name}RepositoryInterface.php" => $this->render('domain/repository_interface.tpl.php', $commonVars),
            "src/Application/$name/Command/Creer{$name}Command.php" => $this->render('application/command.tpl.php', $commonVars),
            "src/Application/$name/Handler/Creer{$name}Handler.php" => $this->render('application/handler.tpl.php', $commonVars),
            "src/Infrastructure/Persistence/Doctrine/Repository/Doctrine{$name}Repository.php" => $this->render('infrastructure/doctrine_repository.tpl.php', $commonVars),
        ];

        // UI Admin
        if ($input->getOption('admin')) {
            $adminVars = array_merge($commonVars, [
                '{{ context }}' => 'Admin',
                '{{ context_lower }}' => 'admin',
                '{{ route }}' => '/admin/' . strtolower($name),
                '{{ className }}' => "{$name}AdminController",
                '{{ layout }}' => 'admin/layout.html.twig',
            ]);
            $files["src/UI/Http/Admin/Controller/{$name}AdminController.php"] = $this->render('ui/controller.tpl.php', $adminVars);
            if ($input->getOption('with-form')) {
                $files["src/UI/Http/Admin/Form/{$name}Type.php"] = $this->render('ui/form.tpl.php', $adminVars);
            }
            if ($input->getOption('with-template')) {
                $files["templates/admin/" . strtolower($name) . "/index.html.twig"] = $this->render('ui/twig.tpl.html', $adminVars);
            }
            if ($input->getOption('menu')) {
                $files["src/UI/Http/Admin/Menu/{$name}MenuProvider.php"] = $this->render('ui/menu_provider.tpl.php', $adminVars);
            }
        }

        // UI Public
        if ($input->getOption('public')) {
            $publicVars = array_merge($commonVars, [
                '{{ context }}' => 'Public',
                '{{ context_lower }}' => 'public',
                '{{ route }}' => '/' . strtolower($name),
                '{{ className }}' => "{$name}Controller",
                '{{ layout }}' => 'base.html.twig',
            ]);
            $files["src/UI/Http/Public/Controller/{$name}Controller.php"] = $this->render('ui/controller.tpl.php', $publicVars);
            if ($input->getOption('with-form')) {
                $files["src/UI/Http/Public/Form/{$name}Type.php"] = $this->render('ui/form.tpl.php', $publicVars);
            }
            if ($input->getOption('with-template')) {
                $files["templates/public/" . strtolower($name) . "/index.html.twig"] = $this->render('ui/twig.tpl.html', $publicVars);
            }
            if ($input->getOption('menu')) {
                $files["src/UI/Http/Public/Menu/{$name}MenuProvider.php"] = $this->render('ui/menu_provider.tpl.php', $publicVars);
            }
        }

        // UI REST (avec ou sans contexte)
        if ($input->hasParameterOption(['--rest', '-r'])) {
            $restContext = $input->getOption('rest');
            
            if ($restContext) {
                $restContextName = ucfirst($restContext);
                $restContextLower = strtolower($restContext);
                $restVars = array_merge($commonVars, [
                    '{{ context }}' => $restContextName,
                    '{{ namespace }}' => "UI\\Http\\Rest\\$restContextName\\Controller",
                    '{{ route_prefix }}' => "/api/$restContextLower/" . strtolower($name),
                    '{{ route_name_prefix }}' => "rest_{$restContextLower}_{$commonVars['{{ name_lower }}']}_",
                    '{{ className }}' => "{$name}{$restContextName}RestController",
                ]);
                $files["src/UI/Http/Rest/$restContextName/Controller/{$name}{$restContextName}RestController.php"] = $this->render('ui/rest_controller.tpl.php', $restVars);
            } else {
                // REST par défaut (sans sous-dossier)
                $restVars = array_merge($commonVars, [
                    '{{ context }}' => '',
                    '{{ namespace }}' => "UI\\Http\\Rest\\Controller",
                    '{{ route_prefix }}' => "/api/" . strtolower($name),
                    '{{ route_name_prefix }}' => "rest_{$commonVars['{{ name_lower }}']}_",
                    '{{ className }}' => "{$name}RestController",
                ]);
                $files["src/UI/Http/Rest/Controller/{$name}RestController.php"] = $this->render('ui/rest_controller.tpl.php', $restVars);
            }
        }

        foreach ($files as $path => $content) {
            $dir = dirname($path);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            if (file_exists($path)) {
                $io->warning("Le fichier $path existe déjà.");
                continue;
            }

            file_put_contents($path, $content);
            $io->note("Fichier créé : $path");
        }

        $io->success("Le domaine $name a été généré avec succès.");

        return Command::SUCCESS;
    }

    private function render(string $template, array $vars): string
    {
        $content = file_get_contents($this->skeletonDir . '/' . $template);
        return strtr($content, $vars);
    }
}
