# Générateur de Feature (Domaine & UI)

Afin de maintenir une architecture en couche propre tout en facilitant le développement, un générateur de boilerplate est disponible.

## Commande de base

Pour générer uniquement le cœur du domaine (Entité, Repository, Command, Handler) :

```bash
symfony console app:generate:feature NomDuDomaine
```

## Options d'Interface (UI)

Vous pouvez ajouter des couches d'interface utilisateur via des options :

### 1. Espace Administration (`--admin`)
Génère un contrôleur dans `src/UI/Http/Admin/Controller/`.
*   `--with-form` (-f) : Ajoute un formulaire Symfony.
*   `--with-template` (-t) : Ajoute un template Twig dans `templates/admin/`.

```bash
symfony console app:generate:feature Produit --admin -f -t
```

### 2. Espace Public (`--public`)
Génère un contrôleur dans `src/UI/Http/Public/Controller/`.
*   `--with-form` (-f) : Ajoute un formulaire Symfony.
*   `--with-template` (-t) : Ajoute un template Twig dans `templates/public/`.
*   `--menu` (-m) : Ajoute un provider de menu pour la sidebar.

```bash
symfony console app:generate:feature Produit --public -f -t -m
```

### 3. API REST Contextuelle (`--rest=[context]`)
Génère un contrôleur JSON dans un sous-dossier de `src/UI/Http/Rest/`.

*   **Sans contexte** (`--rest`) : Génère dans `Rest/Controller/`. Route : `/api/nom`.
*   **Avec contexte** (`--rest=admin`) : Génère dans `Rest/Admin/Controller/`. Route : `/api/admin/nom`.
*   **Avec contexte public** (`--rest=public`) : Génère dans `Rest/Public/Controller/`. Route : `/api/public/nom`.

```bash
# Exemple pour une API d'administration
symfony console app:generate:feature Produit --rest=admin
```

### 4. Menu Dynamique (`--menu`)
L'option `--menu` génère un `MenuProvider` dans la feature UI concernée. Ce provider enregistre automatiquement les liens de la feature dans la sidebar de l'administration.

```bash
symfony console app:generate:feature Facturation --admin --menu
```
*Voir [docs/MENU.md](docs/MENU.md) pour plus de détails.*

## Structure complète possible

```text
src/
├── Domain/Nom/Entity, Event, Repository/
├── Application/Nom/Command, Handler/
├── Infrastructure/Persistence/Doctrine/Repository/
└── UI/
    └── Http/
        ├── Admin/Controller, Form/
        ├── Public/Controller, Form/
        └── Rest/
            ├── Admin/Controller/       <-- Si --rest=admin
            ├── Public/Controller/      <-- Si --rest=public
            └── Controller/             <-- Si --rest simple
templates/
├── admin/nom/index.html.twig
└── public/nom/index.html.twig
```

## Étapes suivantes après génération

1.  **Service Tagging** : Enregistrez le Handler dans `config/services.yaml` s'il n'est pas autoconfiguré.
2.  **Interface Binding** : Liez l'Interface du Repository à son implémentation Doctrine dans `config/services.yaml`.
3.  **Security** : Configurez les accès (ROLE_ADMIN) pour le dossier `Admin` dans `security.yaml`.
