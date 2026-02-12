# Contributing to StackPilot

Thank you for considering contributing to StackPilot.

This project follows a chapter-based development workflow and emphasizes clean code, testing, and documentation.

---

## Requirements

You will need:

- Docker + Docker Compose
- PHP 8.2+
- Composer
- Node.js 20+
- Git

Laravel Sail is used for local development.

---

## Local Setup

Clone the repository:

```bash
git clone https://github.com/damir-bubanovic/StackPilot.git
cd StackPilot
```

Copy environment file:

```bash
cp .env.example .env
```

Start Sail:

```bash
./vendor/bin/sail up -d
```

Install backend dependencies:

```bash
./vendor/bin/sail composer install
```

Generate application key:

```bash
./vendor/bin/sail artisan key:generate
```

Run migrations:

```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

Install frontend dependencies:

```bash
./vendor/bin/sail npm install
```

Run frontend dev server:

```bash
./vendor/bin/sail npm run dev
```

---

## Branch Strategy

- `main` → stable
- `feature/<chapter>-<name>` → development

Examples:

```
feature/chapter10-docs
feature/chapter11-deployment
```

---

## Code Style

Laravel Pint is enforced.

Run before committing:

```bash
./vendor/bin/sail pint
```

---

## Testing

All contributions must include tests.

Run:

```bash
./vendor/bin/sail artisan test
```

CI will reject pull requests with failing tests.

---

## Pull Request Checklist

Before opening a PR:

- [ ] Tests added or updated
- [ ] Pint passes
- [ ] API documentation updated if needed
- [ ] README updated if needed
- [ ] Feature works locally
- [ ] No debug code committed

---

## Guidelines

- Follow existing architecture patterns
- Use API Resources for responses
- Protect routes with policies
- Avoid business logic in controllers
- Keep commits small and focused
- One feature per PR

---

## Questions

Open an issue if something is unclear.

Thank you for contributing.
