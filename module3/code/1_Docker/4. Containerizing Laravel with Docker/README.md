# Simple Laravel with Docker

This example demonstrates a **simplified Docker setup for Laravel** that's perfect for learning and development. It focuses on core concepts without unnecessary complexity.

## What We Built

A **3-container stack** that's simple, reliable, and educational:

```
🌐 NGINX (Port 8080) 
    ↓
🐘 PHP-FPM (Laravel)
    ↓  
🗄️ MySQL (Database, Cache, Sessions, Queues)
```

## Directory Structure

```
my-project/                  ← Your main project directory
├── docker/
│   ├── nginx/
│   │   ├── Dockerfile
│   │   └── nginx.conf
│   ├── php/
│   │   ├── Dockerfile
│   │   └── php.ini
│   └── mysql/
│       ├── Dockerfile       ← Simplified MySQL 8.0
│       └── init.sql         ← Minimal initialization
├── laravel-dir/             ← Laravel project (name you specify)
│   ├── app/
│   ├── config/
│   ├── .env                 ← File sessions, MySQL config
│   ├── artisan
│   └── ... (Laravel files)
├── composer.json            ← Simple Docker scripts
├── docker-compose.yml       ← 3-service setup (auto-updated)
└── .env.docker             ← Docker environment template
```

## Key Simplifications for Learning

### ✅ What We Kept (Essential)
- **NGINX** - Web server
- **PHP-FPM** - Laravel application  
- **MySQL** - Database for everything
- **File sessions** - Simple, visible storage
- **Basic Docker networking**

## How to Use the Setup Script

### Method 1: Copy Template and Run Script
```bash
# Copy the template directory
cp -r '/path/to/4. Containerizing Laravel with Docker' my-project
cd my-project

# Run setup script (creates Laravel in specified directory)
./setup.sh hello

# This creates in current directory:
my-project/
├── hello/               ← Laravel application
├── docker/              ← Docker configuration  
├── docker-compose.yml   ← Container orchestration
└── composer.json        ← Docker management scripts
```

### Method 2: Run Script with Any Laravel Directory Name
```bash
cd my-project
./setup.sh webapp     # Creates Laravel in 'webapp' directory
./setup.sh api        # Creates Laravel in 'api' directory  
./setup.sh backend    # Creates Laravel in 'backend' directory
```

### Step 2: Access Your Application
```bash
composer run dev

# Visit: http://localhost:8080
```

**Important**: The script creates Laravel in whatever directory name you specify in the current directory.

## Available Commands (Simplified)

### Basic Operations
```bash
composer run start    # Start containers (background)
composer run setup    # Setup Laravel (keys, migrations)
composer run dev      # Complete setup (start + setup)
composer run stop     # Stop all containers
```

### Development Tools
```bash
composer run shell         # Access PHP container
composer run artisan       # Run Laravel commands
composer run mysql-check   # Test database connection
```

### Direct Docker (Alternative)
```bash
docker-compose up -d       # Start containers
docker-compose down        # Stop containers
docker-compose logs -f     # View logs
```

## Configuration Details

### File-Based Sessions (Simple!)
```bash
# In .env
SESSION_DRIVER=file  # Sessions stored in storage/framework/sessions/
```

**Why file sessions for learning?**
- ✅ No database table needed
- ✅ Can see actual session files
- ✅ Faster setup
- ✅ Traditional web development approach

### Database Configuration
```bash
# In .env  
DB_CONNECTION=mysql
DB_HOST=mysql                 # Docker service name
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=laravel_password
```

### Everything Uses MySQL
```bash
CACHE_STORE=database     # Cache in MySQL
QUEUE_CONNECTION=database # Background jobs in MySQL  
SESSION_DRIVER=file      # Sessions in files (simple!)
```

## Teaching Benefits

### Why This Approach is Perfect for Students

1. **Fewer Moving Parts**
   - 3 containers instead of 4+
   - Less complexity = less confusion

2. **Database-Centric Learning**
   - Students learn SQL and database concepts
   - One place to store everything

3. **Standard LAMP Stack**
   - NGINX + PHP + MySQL (classic web development)
   - Skills transfer to other projects

4. **Easy Debugging**
   - Simple logs: `docker-compose logs`
   - Clear error messages
   - File sessions you can actually see

5. **Familiar Laravel Workflow**
   - Standard Laravel commands work
   - Normal development process
   - Focus on Laravel, not infrastructure

## Common Issues & Solutions

### Container Won't Start
```bash
# Check logs
docker-compose logs mysql
docker-compose logs php

# Rebuild if needed
docker-compose build --no-cache
```

### Can't Connect to Database
```bash
# Test connection
composer run mysql-check

# Check password consistency
grep DB_PASSWORD hello/.env
grep MYSQL_PASSWORD docker-compose.yml
```

### Port 8080 Already in Use
```bash
# Check what's using the port
lsof -i :8080

# Change port in docker-compose.yml
ports:
  - "8081:80"  # Use 8081 instead
```

## When to Add Complexity

Start simple with this setup, then add features as needed:

### Add Redis when you need:
- High-performance caching
- Multiple application servers  
- Real-time features (chat, notifications)

### Add Queue Workers when you need:
- Background job processing
- Email sending
- Image processing

### Add Production Features when you need:
- Health checks
- Load balancing
- Monitoring
- SSL certificates

## Learning Progression

1. **Start Here** - Simple 3-container setup
2. **Master Laravel** - Focus on application development
3. **Add Redis** - When you need performance
4. **Add Queues** - When you need background processing
5. **Add Production** - When you deploy to servers

This approach teaches Docker fundamentals without overwhelming students with unnecessary complexity. Perfect for learning both Laravel and Docker concepts! 🚀
