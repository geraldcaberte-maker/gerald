# Copilot Instructions for AI Coding Agents

## Project Overview
- This is a Laravel-based PHP web application, following standard Laravel conventions for structure and workflow.
- Major directories:
  - `app/`: Application logic, including `Http/Controllers` (request handling), `Models` (Eloquent ORM models), and `Providers` (service providers).
  - `routes/`: Route definitions (`web.php` for web, `console.php` for CLI commands).
  - `resources/views/`: Blade templates for server-rendered HTML.
  - `database/`: Migrations, seeders, and factories for database schema and test data.
  - `public/`: Web root, entry point is `index.php`.
  - `config/`: Application configuration files.
  - `tests/`: PHPUnit tests, organized into `Feature` and `Unit`.

## Key Workflows
- **Development server:**
  - Use `php artisan serve` to start a local server.
- **Database migrations:**
  - Run `php artisan migrate` to apply migrations.
- **Seeding/factories:**
  - Use `php artisan db:seed` and `php artisan tinker` for test data.
- **Testing:**
  - Run `vendor\bin\phpunit` or `php artisan test` for automated tests.
- **Asset building:**
  - Use `npm run dev` for development, `npm run build` for production assets (see `vite.config.js`).

## Project-Specific Patterns
- Follows standard Laravel MVC and service provider patterns; avoid custom frameworks or non-Laravel conventions unless found in `app/`.
- Eloquent models are in `app/Models/` (e.g., `User.php`).
- Controllers are in `app/Http/Controllers/`.
- Blade templates are in `resources/views/`.
- Configuration is environment-driven via `.env` and `config/` files.

## Integration Points
- Uses Composer for PHP dependencies (`composer.json`).
- Uses NPM for frontend assets (`package.json`).
- Entry point for HTTP requests is `public/index.php`.
- Service providers in `app/Providers/` register application services.

## Examples
- To add a new route: edit `routes/web.php`.
- To add a new model: create in `app/Models/` and run migration in `database/migrations/`.
- To add a controller: create in `app/Http/Controllers/` and register route.

## References
- See [README.md](../../README.md) for general Laravel info.
- See `php artisan list` for all available CLI commands.

---

*Update this file if project-specific conventions or workflows change.*
