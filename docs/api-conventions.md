# StackPilot — API Conventions

## Base
- Base path: /api/v1
- Auth: Laravel Sanctum (SPA)

---

## Response Shape

### Success

Example response:
{
  "data": {}
}

---

### Error

Example response:
{
  "message": "Validation failed",
  "errors": {
    "field": ["Error message"]
  }
}

---

## Pagination

Example response:
{
  "data": {
    "items": [],
    "meta": {},
    "links": {}
  }
}

---

## Status Codes

- 200 OK
- 201 Created
- 204 No Content
- 401 Unauthorized
- 403 Forbidden
- 404 Not Found
- 422 Validation Error
- 500 Server Error

---

## Versioning

- All endpoints live under /api/v1
- Breaking changes require /api/v2
