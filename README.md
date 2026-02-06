# Rebecca AIML Chatbot (PHP)

Interface web + moteur AIML en PHP, basé sur un travail de portage à partir du projet initial RebeccaAIML.

**Version :** `v0.0.1`  
**Démo en ligne :** `https://chatbot.timecaps.fr`

![Interface](assets/interface.png)

## Objectif

Fournir un chatbot AIML simple à tester via une page `index.html`, avec gestion du multi‑langue, cache serveur, sécurité basique et statistiques AIML.

## Ce qui a été porté depuis le projet initial (clair et précis)

Le projet d’origine **RebeccaAIML** est un moteur **C++**.  
Dans ce dépôt, **le portage n’est pas un fork C++** : il s’agit d’une **ré‑implémentation en PHP** située dans le dossier `chatbot/`.

En clair :

1. **Le cœur C++ d’origine n’est pas utilisé** dans l’exécution du chatbot ici.
2. **Le moteur actif est en PHP** (`chatbot/aiml_engine.php`) afin de tourner facilement sur un hébergement mutualisé.
3. **Les corpus AIML sont séparés par langue** (`chatbot/aiml_fr`, `chatbot/aiml_en`) et pilotés par `chatbot/config.php`.
4. **Une API HTTP** a été ajoutée (`chatbot/chat.php`) pour la communication avec l’UI.
5. **L’interface web** est dans `index.html` (test rapide, reset, stats).

> Remarque : les fichiers de configuration AIML dans `chatbot/conf` proviennent de **Program D** (cf. `chatbot/conf/README.txt`).  
> Le corpus français est basé sur `aimlfr` (AIML FR).

## Fonctionnalités

- Interface web responsive (Bootstrap + UI custom).
- Sélecteur de langue FR / EN.
- Reset de conversation (client + session serveur).
- Cache du moteur AIML pour limiter les temps de chargement.
- Limitation de débit + protection CSRF.
- Statistiques AIML (nombre de fichiers + catégories par langue).

## Structure du projet

- `index.html` : UI de test du chatbot.
- `chatbot/chat.php` : endpoint principal (POST).
- `chatbot/aiml_engine.php` : moteur AIML en PHP.
- `chatbot/config.php` : configuration générale.
- `chatbot/aiml_en/` : corpus AIML anglais.
- `chatbot/aiml_fr/` : corpus AIML français.
- `chatbot/conf/` : configuration bot (Program D).
- `chatbot/stats.php` : endpoint stats AIML.

## Utilisation locale (exemple)

1. Placer le projet dans un dossier accessible par PHP.
2. Démarrer un serveur local :
   - Exemple : `php -S localhost:3000 -t .`
3. Ouvrir `http://localhost:3000/index.html`

## API HTTP

### 1) Récupérer un token CSRF

`GET /chatbot/chat.php?action=token`

Réponse :
```json
{ "token": "..." }
```

### 2) Envoyer un message

`POST /chatbot/chat.php`

Paramètres :
- `message` : texte utilisateur
- `lang` : `fr` ou `en`
- `csrf` : token CSRF
- `reset` : `1` pour reset session (optionnel)

Réponse :
```json
{ "reply": "..." }
```

### 3) Statistiques AIML

`GET /chatbot/stats.php`

Réponse :
```json
{
  "total": { "files": 0, "categories": 0 },
  "langs": {
    "fr": { "files": 0, "categories": 0 },
    "en": { "files": 0, "categories": 0 }
  }
}
```

## Configuration

Le fichier `chatbot/config.php` permet de configurer :

- Langue par défaut
- Dossiers AIML par langue
- Réponse de fallback
- Cache (TTL, version)
- Logging
- Rate limiting

## Crédits / Sources

- Projet original : RebeccaAIML (C++) — `RebeccaAIML-src-9871`
- AIML FR : `https://github.com/aifr/aimlfr`
- AIML config : Program D (`chatbot/conf/README.txt`)
- AIML spec : ALICE / AIML 1.0.1

## Licence

Ce projet est distribué sous licence **LGPL-2.1**. Voir le fichier `LICENSE`.
