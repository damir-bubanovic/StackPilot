# StackPilot

StackPilot is a full-stack demo application built with Laravel and Vue 3.  
It demonstrates clean API design, authentication, authorization policies, and a responsive SPA frontend.

---

## Tech Stack

Backend:
- Laravel (API mode)
- Sanctum authentication
- Eloquent ORM
- Policies for authorization
- API Resources
- Throttling
- Pagination

Frontend:
- Vue 3
- Vue Router
- Pinia (state management)
- Axios
- Tailwind CSS (v4)
- Vite

Database:
- MySQL (via Laravel Sail / Docker)

---

## Features

Authentication:
- Register
- Login
- Logout
- Token-based auth (Sanctum)
- Rate-limited auth routes

Projects:
- Create project
- List projects
- Delete project
- Pagination support

Tasks (per project):
- Add task
- Toggle complete/incomplete
- Delete task
- Isolated state per project

Security:
- Authorization policies
- Throttled login/register
- API Resources for consistent responses

UX:
- Loading states
- Error states
- Empty states
- Confirm delete actions

---

## Local Development (Laravel Sail)

1. Clone the repository:

```
git clone https://github.com/damir-bubanovic/StackPilot.git
cd StackPilot
```

2. Copy environment file:

```
cp .env.example .env
```

3. Start Sail:

```
./vendor/bin/sail up -d
```

4. Install backend dependencies:

```
./vendor/bin/sail composer install
```

5. Generate app key:

```
./vendor/bin/sail artisan key:generate
```

6. Run migrations + seed demo user:

```
./vendor/bin/sail artisan migrate:fresh --seed
```

7. Install frontend dependencies:

```
./vendor/bin/sail npm install
```

8. Run Vite dev server:

```
./vendor/bin/sail npm run dev
```

Open:

```
http://localhost
```

---

## Demo Credentials

Email:
```
demo@stackpilot.test
```

Password:
```
password
```

---

## API Base URL

```
/api/v1
```

Example endpoints:

- POST /api/v1/auth/login
- GET /api/v1/projects
- POST /api/v1/projects/{project}/tasks

---

## Project Structure Overview

- app/Http/Controllers/Api/V1
- app/Http/Resources
- app/Policies
- resources/js (Vue SPA)
- routes/api.php

---

## Git Workflow

- main → stable
- feature/<chapter-name> → chapter-based development

Each chapter represents a structured development milestone.

---

## Purpose

This project demonstrates:

- Full-stack Laravel + Vue development
- REST API architecture
- Secure authorization patterns
- Clean state management
- Real-world CRUD implementation
- Docker-based local development

---

Built as a professional demo project to showcase backend + frontend capabilities.
