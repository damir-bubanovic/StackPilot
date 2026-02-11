# StackPilot — Requirements (Demo Project)

## Goal
StackPilot is a demonstration full-stack project to showcase:
- Laravel backend API development
- Authentication + authorization
- MySQL schema design + migrations
- RESTful API patterns
- Vue.js UI + reusable components
- Clean Git workflow, documentation, and testing basics

## Users & Roles
### Guest
- Can view landing page
- Can register and log in

### Authenticated User
- Can manage their own Projects
- Can manage Tasks inside their Projects

### Admin (optional, later)
- Can view all users, projects, and tasks (read-only for demo)

## Core Features (MVP)
### Authentication
- Register, login, logout
- Current user endpoint (`/api/me`)

### Projects (CRUD)
- Create, list, view, update, delete
- Only owner can access

### Tasks (CRUD)
- Create, list, update, delete
- Belongs to a project
- Only owner can access through project ownership

## Non-Functional
- Input validation on all write endpoints
- Consistent JSON response format
- Pagination for list endpoints
- Basic tests for auth + one CRUD flow

## Out of Scope (for MVP)
- Payments, notifications, file uploads
- Complex admin panel
- Multi-tenant organizations
