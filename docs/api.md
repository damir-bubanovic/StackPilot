# StackPilot API Documentation

Base URL:

```
/api/v1
```

All API requests should include:

```
Accept: application/json
```

Protected endpoints also require:

```
Authorization: Bearer {token}
```

---

## Authentication

### Register

POST `/auth/register`

Request:

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123"
}
```

Response 201:

```json
{
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com"
    },
    "token": "..."
  }
}
```

---

### Login

POST `/auth/login`

Request:

```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

Response 200:

```json
{
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com"
    },
    "token": "..."
  }
}
```

---

### Current User

GET `/me`

Auth required.

Response:

```json
{
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  }
}
```

---

### Logout

POST `/auth/logout`

Auth required.

Response 204.

---

## Projects

### List Projects

GET `/projects`

Auth required.

Response:

```json
{
  "data": [],
  "links": {},
  "meta": {}
}
```

---

### Create Project

POST `/projects`

```json
{
  "name": "My Project",
  "description": "Optional description"
}
```

Response 201.

---

### Delete Project

DELETE `/projects/{id}`

Auth required.

Response 204.

---

## Tasks

### List Tasks

GET `/projects/{project}/tasks`

Auth required.

---

### Create Task

POST `/projects/{project}/tasks`

```json
{
  "title": "New Task",
  "description": "Optional"
}
```

Response 201.

---

### Toggle Task Status

PATCH `/tasks/{task}`

Automatically toggles:

```
todo → done
done → todo
```

Response 200.

---

### Delete Task

DELETE `/tasks/{task}`

Response 204.

---

## Status Codes

| Code | Meaning |
|------|---------|
| 200 | OK |
| 201 | Created |
| 204 | No Content |
| 401 | Unauthorized |
| 403 | Forbidden |
| 422 | Validation error |

---

## Validation Errors

```json
{
  "message": "The title field is required.",
  "errors": {
    "title": [
      "The title field is required."
    ]
  }
}
```

---

## Notes

- All responses wrapped in `data`
- Policies enforce ownership
- Project listing is paginated
- Sanctum tokens are per-device
- CI enforces tests + Pint
