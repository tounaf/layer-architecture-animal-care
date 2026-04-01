# Analyse de l'Architecture Structurale : 
### Projet Symfony (DDD & Hexagonal)

--- 
## 1. Vision Globale de l'Architecture
Le projet adopte une structure 
**Clean Architecture / Hexagonale** combinée aux principes du **Domain-Driven Design (DDD)**. 
### Les 4 Couches Principales 

1. **Domain (Cœur Métier) :** Pur, sans dépendances (ni Symfony, ni Doctrine). Contient les Entités (Aggregate Roots), Événements de Domaine et Interfaces de Repository. 
2. **Application (Cas d'usage) :** Orchestration via des Handlers et des Commandes/Queries. Utilise les interfaces du Domaine. 
3. **Infrastructure (Technique) :** Implémentations concrètes (Doctrine, Messenger, EventBus). Les adaptateurs font le pont entre le monde extérieur et le Domaine. 
4. **UI (Points d'entrée) :** Découpage granulaire par contexte (Http/Admin, Http/Public, Http/Rest, Cli). 

**Points de force :** 
- **Indépendance technologique :** Facilite les tests unitaires et les montées de version Symfony/Doctrine. 
- **Règle de dépendance stricte :** Dépendances pointant vers l'intérieur (le Domaine ne connaît rien de l'extérieur). 

--- 
## 2. Stratégie de Gestion des Événements
C'est un point central de l'architecture pour assurer le découplage des fonctionnalités. 

### Domain Events vs Symfony Events 

- **Domain Events :** Objets PHP simples (POPO) implémentant une interface `DomainEvent` interne. 
- **Adaptation :** Utilisation d'un `SymfonyEventDispatcher` (Infrastructure) qui implémente une interface `EventDispatcherInterface` (Application/PSR-14). 
- **Wrapper :** Les événements Domain sont enveloppés dans un `SymfonyDomainEvent` pour être consommés par les listeners Symfony classiques. 
### Synchrone vs Asynchrone 

| Système | Outil | Cas d'usage | Impact Performance |
| :--- | :--- | :--- | :--- |
| **Synchrone** | EventDispatcher | Logs, Cache, Stats simples | Bloquant (même processus) | | **Asynchrone** | Messenger | Emails, SMS, API Externes | Non bloquant (Queue/Workers) | 

**Points de vigilance :** 

- Les listeners synchrones peuvent faire échouer la requête principale s'ils ne sont pas sécurisés (try/catch). 
- La duplication de l'événement (Synchrone + Asynchrone) nécessite une gestion rigoureuse dans les Handlers. 

--- 

## 3. Workflow de Développement (Boilerplate) 
L'utilisation d'un générateur de feature (`app:generate:feature`) est une excellente pratique pour réduire la friction de l'architecture hexagonale. 

### Capacités du Générateur 
- Génération complète : Entité, Repository, Command, Handler + UI (Admin, Public, Rest). 

- Support optionnel des formulaires Symfony et templates Twig. 

### Étapes manuelles résiduelles (Discussion atelier) 
- **Service Tagging :** Enregistrement des Handlers. 
- **Interface Binding :** Liaison Interfaces -> Implémentations. 
- **Security :** Configuration des accès. *Piste d'amélioration : Automatiser via l'autoconfiguration Symfony (Service Tags) et l'autowiring pour limiter les modifications dans `services.yaml`.* 

--- 
## 4. Reflexions

1. **Persistence Pure :** Comment gérer efficacement le mapping Doctrine (YAML/XML) sans polluer les entités avec des annotations ? 

2. **Gestion des Événements :** Est-il préférable d'utiliser le type-hint direct sur les Domain Events dans les listeners Symfony (si supporté nativement via config) plutôt que de passer par un Wrapper ? 

3. **Performances :** Pour les stats complexes, ne devrait-on pas privilégier systématiquement l'asynchrone (Messenger) même si l'action semble "interne" ? 

4. **Générateur :** Peut-on automatiser le binding des Repositories lors de la génération pour réduire les erreurs manuelles ? 

5. **Tests :** Quelle stratégie pour les tests d'intégration des couches Infrastructure vs tests unitaires du Domaine ? 

--- 

*Analyse générée le 01/04/2026 pour l'atelier d'architecture.* 