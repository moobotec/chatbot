# Rebecca AIML Chatbot (PHP)

Chatbot **AIML** avec **interface web** et **moteur en PHP**, issu d’un travail de **ré-implémentation** inspiré du projet original **RebeccaAIML (C++)**.

**Version :** `v0.0.1`  
🚀 **Démo en ligne :** [chatbot.timecaps.fr](https://chatbot.timecaps.fr)

<p align="center">
  <img src="assets/interface.png" alt="Interface du chatbot" width="600">
</p>

---

## 🎯 Objectif du projet

Fournir un **chatbot AIML simple à tester et à déployer**, accessible via une interface web légère, avec :

- un moteur **100 % PHP** (compatible hébergement mutualisé),
- la gestion du **multilingue (FR / EN)**,
- des mécanismes de **cache**, **sécurité basique** et **statistiques AIML**,
- une API HTTP claire pour la communication UI ↔ moteur.

Le projet privilégie la **lisibilité**, la **maintenabilité** et la **facilité d’expérimentation** autour d’AIML.

---

## 🧠 Origine et portage

Le projet d’origine **RebeccaAIML** est un moteur écrit en **C++**.

👉 Ce dépôt **n’est pas un fork C++**.

Il s’agit d’une **ré-implémentation complète en PHP**, située dans le dossier `chatbot/`, conçue pour fonctionner dans un environnement web standard.

### Points clés

1. Le **cœur C++ original n’est pas utilisé** à l’exécution.
2. Le moteur actif est un **moteur AIML PHP** : `chatbot/aiml_engine.php`.
3. Les **corpus AIML sont séparés par langue** :
   - `chatbot/aiml_fr/`
   - `chatbot/aiml_en/`
4. La configuration globale est centralisée dans `chatbot/config.php`.
5. Une **API HTTP** dédiée assure la communication avec l’interface : `chatbot/chat.php`.
6. L’**interface web de test** est fournie via `index.html`.

> ℹ️ Les fichiers de configuration AIML dans `chatbot/conf/` proviennent de **Program D**.  
> Le corpus français est basé sur **aimlfr**.

---

## ✨ Fonctionnalités

- Interface web responsive (Bootstrap + UI custom).
- Sélecteur de langue **Français / Anglais**.
- Reset de conversation (client + session serveur).
- Cache serveur du moteur AIML.
- Sécurité basique :
  - token CSRF,
  - limitation de débit.
- Statistiques AIML :
  - nombre de fichiers,
  - nombre de catégories,
  - répartition par langue.

---

## 📁 Structure du projet

```
.
├── index.html
├── assets/
├── chatbot/
│   ├── chat.php
│   ├── aiml_engine.php
│   ├── config.php
│   ├── aiml_fr/
│   ├── aiml_en/
│   ├── conf/
│   └── stats.php
└── LICENSE
```

---

## ▶️ Utilisation locale

```bash
php -S localhost:3000 -t .
```

Puis ouvrir :  
`http://localhost:3000/index.html`

---

## 🔌 API HTTP

### Récupération du token CSRF

`GET /chatbot/chat.php?action=token`

```json
{ "token": "..." }
```

### Envoi d’un message

`POST /chatbot/chat.php`

Paramètres :
- `message` : texte utilisateur
- `lang` : `fr` ou `en`
- `csrf` : token CSRF
- `reset` : `1` (optionnel)

```json
{ "reply": "..." }
```

### Statistiques AIML

`GET /chatbot/stats.php`

```json
{
  "total": { "files": 0, "categories": 0 },
  "langs": {
    "fr": { "files": 0, "categories": 0 },
    "en": { "files": 0, "categories": 0 }
  }
}
```

---

## ⚙️ Configuration

Le fichier `chatbot/config.php` permet de configurer :
- langue par défaut,
- dossiers AIML par langue,
- message de fallback,
- cache,
- logging,
- rate limiting.

---

## 📚 Crédits

- Projet original : **RebeccaAIML** (C++)
- AIML FR : https://github.com/aifr/aimlfr
- Configuration AIML : **Program D**
- Spécification : **ALICE / AIML 1.0.1**

---

## 📄 Licence

Ce projet est distribué sous licence **LGPL-2.1**.  
Voir le fichier `LICENSE`.
