<p align="center">
  <img src="public/images/screenshot.png" alt="StackPilot screenshot" width="800">
</p>

# StackPilot

**StackPilot** is a full-stack Laravel + Vue 3 project management demo application focused on clean UI, secure REST APIs, and modern SPA architecture.

It showcases authentication, authorization policies, project/task workflows, and a polished dashboard-style interface.

---

## Features

- User authentication (register, login, logout)
- Token-based auth with Laravel Sanctum
- Project creation and management
- Task management per project (add, toggle, delete)
- Authorization policies (user-owned resources)
- Clean, modern dark UI (Tailwind CSS)
- Vue 3 SPA with Pinia state management
- RESTful API architecture
- Pagination and loading states
- Docker-based local development (Laravel Sail)

---

## Tech Stack

- **Backend:** Laravel (API-first), Sanctum, Eloquent ORM  
- **Frontend:** Vue 3, Vue Router, Pinia, Tailwind CSS, Vite  
- **Database:** MySQL  
- **Dev Environment:** Docker (Laravel Sail)  
- **Tools:** DBeaver, Composer, npm  

---

## Prerequisites

- Docker & Docker Compose  
- Git  
- Node.js (v18+)  
- npm  

---

## Installation

```bash
# Clone repository
git clone https://github.com/damir-bubanovic/StackPilot.git
cd StackPilot

# Copy environment file
cp .env.example .env

# Start containers
./vendor/bin/sail up -d

# Install backend dependencies
./vendor/bin/sail composer install

# Generate application key
./vendor/bin/sail artisan key:generate

# Run migrations + seed demo user
./vendor/bin/sail artisan migrate:fresh --seed

# Install frontend dependencies
./vendor/bin/sail npm install

# Start Vite dev server
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

- POST `/api/v1/auth/login`
- GET `/api/v1/projects`
- POST `/api/v1/projects/{project}/tasks`

---

## Folder Structure

```
app/
  Http/
    Controllers/
    Resources/
  Policies/
resources/
  js/
public/
  images/
database/
routes/
tests/
```

---

## Development Notes

- Frontend handled via **Vite**
- Styling with **Tailwind CSS**
- Database inspection via **DBeaver**
- Containers managed with **Laravel Sail**
- Feature tests + policies included
- CI ready (Pint + PHPUnit)

---

## Production Build (Local Simulation)

```bash
./vendor/bin/sail artisan optimize
./vendor/bin/sail npm run build
```

Update `.env`:

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

---

## Creator

**Damir Bubanović**

- https://damirbubanovic.com  
- https://github.com/damir-bubanovic  
- https://www.youtube.com/@damirbubanovic6608  
- https://stackoverflow.com/users/11778242/damir-bubanovic  
- mailto:damir.bubanovic@yahoo.com  

---

## Acknowledgments

- Built with **Laravel**, **Vue 3**, **Tailwind CSS**, and **Vite**
- Local development powered by **Docker & Laravel Sail**
