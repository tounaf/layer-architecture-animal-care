# Module Utilisateurs (User Management)

Ce module gère les utilisateurs, l'authentification, et le contrôle d'accès basé sur les rôles (RBAC) via des Groupes, Profils et Droits.

## Architecture

Le module suit les principes de la Clean Architecture et du DDD.

### Domain (`src/Domain/User`)
- **Entities** : `User`, `Group`, `Profile`, `Right`.
- **Value Objects** : `UserId`, `GroupId`, `ProfileId`, `RightId`.
- **Logic** : Les entités gèrent leurs propres associations et états.

### Application (`src/Application/User`)
- **Commands** : Définissent les intentions (ex: `RegisterUserCommand`, `UpdateGroupCommand`).
- **Handlers** : Exécutent la logique en utilisant les dépôts et services (ex: `UpdateUserHandler`).

### Infrastructure (`src/Infrastructure/User` et `Persistence`)
- **Persistence** : Mappings Doctrine XML dans `config/doctrine/` et types DBAL personnalisés.
- **Security** : Intégration avec Symfony Security via `SecurityUser` (adaptateur) et `UserProvider`.

### UI (`src/UI/Http/Admin`)
- **Controllers** : Gèrent les requêtes web pour le CRUD.
- **Forms** : Formulaires Symfony typés pour chaque entité.
- **Templates** : Vues Twig pour l'administration.

## Fonctionnalités

### Utilisateurs
- Création, Modification, Suppression.
- Assignation à des Groupes.
- Assignation à des Profils.
- Assignation directe de Droits (Droits spécifiques à l'utilisateur).

### Groupes
- Regroupent plusieurs utilisateurs.
- Peuvent contenir plusieurs Profils.
- Peuvent posséder leurs propres Droits.

### Profils
- Ensembles de Droits réutilisables.
- Peuvent être assignés à des Utilisateurs ou à des Groupes.

### Droits
- Définis par un nom et un code unique (ex: `ROLE_ADMIN`, `USER_EDIT`).
- L'unité de base du contrôle d'accès.

## Contrôle d'Accès
L'accès est vérifié via les codes de Droits. Un utilisateur possède l'union de tous les droits :
1. Ses droits directs.
2. Les droits de ses profils directs.
3. Les droits de ses groupes.
4. Les droits des profils de ses groupes.

## Création d'utilisateur en ligne de commande

```bash
php bin/console app:user:create LOGIN NOM PRENOM EMAIL MOT_DE_PASSE
```

Exemple admin (droit `admin` créé par les fixtures) :

```bash
php bin/console app:user:create admin2 Admin System admin2@example.com MonMotDePasse --right-code=admin
```

Options utiles :
- `--inactive` : utilisateur désactivé
- `--group-id=...` (répétable)
- `--profile-id=...` (répétable)
- `--right-id=...` (répétable)
- `--right-code=admin` (répétable)

## API REST — création d'utilisateur

- **URL** : `POST /api/users`
- **Content-Type** : `application/json`

Payload minimal :

```json
{
  "login": "nouvel_admin",
  "lastname": "Rakoto",
  "firstname": "Jean",
  "mail": "jean.rakoto@example.com",
  "password": "MotDePasseSecurise123",
  "is_active": true,
  "right_codes": ["admin"]
}
```

Champs optionnels : `group_ids`, `profile_ids`, `right_ids`.

Un script d'exemple est disponible : `exemple-api-user.php`.
