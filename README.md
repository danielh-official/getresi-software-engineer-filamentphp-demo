# Laravel 12 Template

A Laravel 12 template set with my preferences.

For a similar and more popular idea, see: https://github.com/nunomaduro/laravel-starter-kit

## Getting Started On Local

1. Clone to your machine
2. Run `composer setup` (see: https://getcomposer.org/download/)
3. Running Server
    1. Run `./vendor/bin/sail up` or `./vendor/bin/sail up -d`
    - Make sure you have a Docker environment set up like Orbstack (see: https://orbstack.dev/download)
    - Sail scripts can be run using `composer sail` as well
    2. Alternatively, run `composer dev` to enable hot reload of views whenever a file is changed on 127.0.0.1:{port,default:8000}

## Information

Made with `laravel new ...`:

- Starter Kit: None
- Testing Framework: PestPHP
- Database: SQLite
- Installed Laravel Boost: Yes
    - Instal Herd MCP Alongside Boost MCP: Yes
    - Code Editors: Claude Code, Cursor, PhpStorm, VS Code
    - Code Editors w/ AI Guidelines: Claude Code, Cursor, GitHub Copilot

Added:

- Laravel/Sail (see: https://laravel.com/docs/12.x/sail)
    - Services Installed: MySQL, Redis, Mailpit
- Laravel Debugbar (see: https://laraveldebugbar.com/)
    - Off by default, set `DEBUGBAR_ENABLED=true` in .env to enable
- Laravel IDE Helper (see: https://github.com/barryvdh/laravel-ide-helper)
- Whisky (see: https://github.com/ProjektGopher/whisky)
    - Git Hooks for pre-commit and pre-push (see: [./whisky.json](./whisky.json))
- Essentials (see: https://github.com/nunomaduro/essentials)

## Composer Scripts

```bash
composer setup # Initial setup for repository

composer dev # Run local server w/ Vite hot reload

composer ide # Create/update laravel-ide-helper files

composer lint # Format backend and frontend files

composer test # Run Pest tests

composer sail # Run sail commands (e.g., composer sail up -d)
```

## Potential Problems

> I'm having issues with committing on Git.

Run `composer update` to trigger `whisky update`. That should refresh your Git hooks. If you've installed a fresh project, make sure to run `composer setup` before doing anything else.
