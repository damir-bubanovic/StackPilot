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
- Identify core entities:
  - Users
  - Projects
  - Tasks
- Build ERD
- Add migrations + seeders
- Index foreign keys
- Verify schema in DBeaver

Task model includes:
- title
- description
- status (`todo`, `doing`, `done`)
- due_date

Deliverables:
- Database migrations
- docs/database.md

---

### Chapter 4 — Authentication & Authorization
- Laravel Sanctum
- Register / Login / Logout
- Password reset
- Policy system (Project + Task ownership)

Deliverables:
- Auth endpoints
- Protected API routes

---

### Chapter 5 — Vue Frontend Foundation
- Vue + Vite SPA
- Vue Router
- Pinia store architecture
- Tailwind CSS UI system
- Layout + reusable components

Deliverables:
- Auth UI
- API integration via stores

---

### Chapter 6 — Core Domain Module (Projects & Tasks MVP)

#### Backend
- Project CRUD
- Task CRUD (nested under projects)
- Validation for all inputs
- API Resources for consistent responses

#### Task Features
- Title, description, status, due date
- Status workflow:
  - todo → doing → done → todo
- Per-project task scoping

#### Frontend Features
- Project dashboard (grid layout)
- Create project (name + description)
- Delete project
- Create task with:
  - title
  - description
  - status
  - due date
- Toggle task status
- Delete task
- Tasks grouped by project

#### UX Improvements
- Collapsible task details
- Status badges (Todo / Doing / Done)
- Due date display
- Loading states
- Empty states
- Inline creation forms

#### Data Handling
- Tasks loaded per project on page load
- State managed via Pinia stores
- Optimistic UI updates (prepend items)

Deliverables:
- Fully functional Projects + Tasks module
- Persistent data (DB verified)
- Clean SPA workflow

---

### Chapter 7 — API Quality & Security
- API Resources used for responses
- Authorization policies enforced
- Input validation on all endpoints
- Clean REST structure

Planned:
- Rate limiting
- Redis caching
- Query optimization

---

### Chapter 8 — Feature Expansion (Planned)
Possible modules:
- Notifications
- File uploads
- Payments (Stripe/PayPal)
- Admin dashboard

Each feature includes:
- API
- Vue UI
- Tests
- Documentation

---

### Chapter 9 — Testing & CI (Planned)
- Feature tests (Projects + Tasks)
- Policy tests
- GitHub Actions:
  - PHP tests
  - Pint (linting)
  - Frontend build

---

## 📌 To-Do Chapters

### Chapter 10 — Documentation
- README upgrade
- API documentation
- Contributing guide
- Architecture overview

---

### Chapter 11 — Deployment
- VPS or Laravel Forge
- Production environment config
- HTTPS (SSL)
- Database backups
- Logging & monitoring
- Queue workers (future)
- Scheduler

Deliverables:
- docs/deployment.md

---

## Git Workflow

- main (stable)
- feature/<chapter>-<name>

Each chapter = pull request.

---

## Current Status Summary

✔ Authentication complete  
✔ Projects + Tasks fully functional  
✔ Status + due dates implemented  
✔ UI/UX baseline complete  
✔ Ready for testing and deployment phase  

---

End of roadmap.