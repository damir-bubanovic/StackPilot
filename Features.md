# StackPilot – Project Roadmap (Laravel + Vue)

StackPilot is a full-stack Laravel + Vue web app focused on clean UI, secure REST APIs, and scalable database design.  
This roadmap breaks development into clear chapters.

---

## ✅ Completed Chapters

### Chapter 1 — Environment & Base Setup
- Laravel created via laravel.build (MySQL, Redis, Mailpit)
- Sail running
- Initial migrations executed
- Vite installed and running
- GitHub repository initialized

---

### Chapter 2 — Requirements & System Design
- Define StackPilot product goals
- Define user roles (Guest, User, Admin)
- Decide SPA + API structure
- Define API standards
- Write:
  - docs/requirements.md
  - docs/api-conventions.md
  - docs/erd.md

---

### Chapter 3 — Database Modeling
- Identify core entities
- Build ERD
- Add migrations + seeders
- Index foreign keys
- Verify schema in DBeaver

Deliverables:
- Database migrations
- docs/database.md

---

### Chapter 4 — Authentication & Authorization
- Laravel Sanctum
- Register / Login / Logout
- Password reset
- Role middleware
- Policy system

Deliverables:
- Auth endpoints
- Basic auth tests

---

### Chapter 5 — Vue Frontend Foundation
- Vue + Vite
- Vue Router
- Pinia store
- Tailwind CSS
- Layouts + reusable UI components

Deliverables:
- Component library
- Auth UI wired to API

---

### Chapter 6 — Core Domain Module (MVP)
- Backend CRUD with validation
- REST endpoints
- Vue list/create/edit/detail pages
- Search + pagination

Deliverables:
- First complete feature (API + UI)

---

### Chapter 7 — API Quality & Security
- API Resources
- Rate limiting
- Query optimization
- Redis caching

---

### Chapter 8 — Feature Expansion
Possible modules:
- Notifications
- File uploads
- Payments (Stripe/PayPal)
- Admin tools

Each feature:
- API
- Vue UI
- Tests
- Docs

---

## 📌 To-Do Chapters

### Chapter 9 — Testing & CI
- Feature tests
- Policies tests
- GitHub Actions:
  - PHP tests
  - Pint
  - Frontend build

---

### Chapter 10 — Documentation
- README upgrade
- API docs
- Contributing guide

---

### Chapter 11 — Deployment
- VPS or Forge
- Production env
- HTTPS
- Backups
- Logs
- Scheduler

Deliverables:
- docs/deployment.md

---

## Git Workflow

- main (stable)
- feature/<chapter>-<name>

Each chapter = pull request.

---

End of roadmap.
