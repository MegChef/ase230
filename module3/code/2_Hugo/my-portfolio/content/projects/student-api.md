---
title: "Student Management API"
date: 2024-01-15
draft: false
description: "RESTful API built with Laravel for managing student data"
tags: ["Laravel", "PHP", "MySQL", "REST API", "Docker"]
---

# Student Management API

A comprehensive REST API for managing student information, built with Laravel framework.

## Features
- ✅ Complete CRUD operations for students
- ✅ Data validation and error handling  
- ✅ MySQL database with Eloquent ORM
- ✅ RESTful API design principles
- ✅ Docker containerization
- ✅ Comprehensive API documentation

## Technology Stack
- **Backend**: Laravel 10, PHP 8.2
- **Database**: MySQL 8.0
- **Containerization**: Docker, Docker Compose
- **Testing**: Postman, PHPUnit

## API Endpoints

### Students Management
| Method | Endpoint             | Description               |
|--------|----------------------|---------------------------|
| GET    | `/api/students`      | Retrieve all students     |
| GET    | `/api/students/{id}` | Retrieve specific student |
| POST   | `/api/students`      | Create new student        |
| PUT    | `/api/students/{id}` | Update student            |
| DELETE | `/api/students/{id}` | Delete student            |

## Example Usage

### Create a Student
```bash
curl -X POST http://localhost:8000/api/students \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Alice Johnson",
    "email": "alice@university.edu",
    "major": "Computer Science",
    "year": 2
  }'
```

### Response

```json
{
  "success": true,
  "message": "Student created successfully",
  "data": {
    "id": 1,
    "name": "Alice Johnson",
    "email": "alice@university.edu",
    "major": "Computer Science",
    "year": 2,
    "created_at": "2024-01-15T10:30:00.000Z",
    "updated_at": "2024-01-15T10:30:00.000Z"
  }
}
```

## Quick Start with Docker

```bash
# Clone the repository
git clone https://github.com/yourusername/student-api.git
cd student-api

# Start with Docker
docker-compose up -d

# The API is now available at http://localhost:8000
```

## Links

- **GitHub Repository**: [github.com/yourusername/student-api](https://github.com/yourusername/student-api)
- **Live Demo**: [api.yourdomain.com](https://api.yourdomain.com)
- **Documentation**: [docs.yourdomain.com](https://docs.yourdomain.com)
