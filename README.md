<p align="center">
  <img src="public/images/screenshot.png" alt="StackPilot screenshot" width="800">
</p>

# StackPilot

**StackPilot** is a full-stack Laravel + Vue 3 project management application focused on clean UI, secure REST APIs, and modern SPA architecture.

It demonstrates real-world patterns including authentication, authorization, state management, and a structured project/task workflow with a polished dashboard interface.

---

## 🚀 Features

### Authentication & Security
- User registration, login, logout
- Token-based authentication with Laravel Sanctum
- Authorization policies (user-owned resources)
- Protected API routes

### Projects
- Create and delete projects
- Project descriptions
- User-scoped project access

### Tasks
- Create tasks per project with:
  - title
  - description
  - status (`todo`, `doing`, `done`)
  - due date
- Toggle task status (cycle: todo → doing → done)
- Delete tasks
- Tasks grouped per project

### UI / UX
- Clean dark dashboard UI (Tailwind CSS)
- Collapsible task details panel
- Status badges (Todo / Doing / Done)
- Due date display
- Loading and empty states
- Inline creation forms (no page reloads)

### Architecture
- Vue 3 SPA with Pinia state management
- RESTful Laravel API with Resources
- Optimistic UI updates
- Modular store structure

### Development
- Docker-based local environment (Laravel Sail)
- Seeded demo data
- Pagination-ready API structure

---

## 🛠 Tech Stack

- **Backend:** Laravel, Sanctum, Eloquent ORM  
- **Frontend:** Vue 3, Vue Router, Pinia, Tailwind CSS, Vite  
- **Database:** MySQL  
- **Dev Environment:** Docker (Laravel Sail)  
- **Tools:** Composer, npm, DBeaver  

---

## 📦 Installation

```bash
git clone https://github.com/damir-bubanovic/StackPilot.git
cd StackPilot

cp .env.example .env

./vendor/bin/sail up -d
./vendor/bin/sail composer install
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate:fresh --seed

./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

Open in browser:
http://localhost

---

## 🔐 Demo Credentials

Email: demo@stackpilot.test  
Password: password  

---

## 🔗 API Base URL

/api/v1

### Example Endpoints

- POST /api/v1/auth/login
- GET /api/v1/projects
- POST /api/v1/projects
- POST /api/v1/projects/{project}/tasks
- PATCH /api/v1/tasks/{task}

---

## 📁 Folder Structure

app/
  Http/
    Controllers/
    Resources/
  Models/
  Policies/

resources/
  js/
    views/
    stores/

database/
  migrations/
  factories/
  seeders/

routes/
tests/
public/
  images/

---

## 🧪 Development Notes

- Frontend powered by Vite
- State management via Pinia
- Styling with Tailwind CSS
- Containers managed with Laravel Sail
- Database inspection via DBeaver
- API responses structured with Laravel Resources

---

## ⚙️ Production Build

```bash
./vendor/bin/sail artisan optimize
./vendor/bin/sail npm run build
```

.env:
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

---

## 📌 Current Status

- Authentication complete  
- Projects + Tasks fully functional  
- Status system implemented  
- Due dates supported  
- UI/UX baseline complete  
- Ready for deployment  

---

## 👤 Creator

Damir Bubanović  
https://github.com/damir-bubanovic  

---

## 🙌 Acknowledgments

Built with Laravel, Vue 3, Tailwind CSS, and Vite.
