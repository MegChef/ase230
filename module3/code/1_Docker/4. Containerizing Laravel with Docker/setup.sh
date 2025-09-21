#!/bin/bash

# Simple Laravel + Docker Setup Script
set -e

echo "🚀 Simple Laravel + Docker Setup"
echo "================================="

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Get Laravel directory name (default to "hello" if no input)
if [ -z "$1" ]; then
    LARAVEL_DIR="hello"
    echo -e "${YELLOW}📝 No directory specified, using default: hello${NC}"
else
    LARAVEL_DIR=$1
fi

echo -e "${BLUE}🏗️  Creating Laravel project: $LARAVEL_DIR${NC}"

# Create Laravel project
composer create-project laravel/laravel "$LARAVEL_DIR"

echo -e "${BLUE}📁 Setting up Docker configuration...${NC}"

# Get script directory
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
echo -e "${BLUE}📁 Script directory: ${SCRIPT_DIR}${NC}"

# Check if Docker files need to be copied
if [ ! -d "./docker" ] || [ ! -f "./docker-compose.yml" ] || [ ! -f "./composer.json" ]; then
    echo -e "${BLUE}📋 Copying Docker files from script directory...${NC}"
    
    # Copy Docker files only if they don't exist or are different
    if [ ! -d "./docker" ]; then
        cp -r "$SCRIPT_DIR/docker" .
        echo -e "${GREEN}✅ Copied docker/ directory${NC}"
    fi
    
    if [ ! -f "./docker-compose.yml" ]; then
        cp "$SCRIPT_DIR/docker-compose.yml" .
        echo -e "${GREEN}✅ Copied docker-compose.yml${NC}"
    fi
    
    if [ ! -f "./composer.json" ]; then
        cp "$SCRIPT_DIR/composer.json" .
        echo -e "${GREEN}✅ Copied composer.json${NC}"
    fi
else
    echo -e "${YELLOW}📋 Docker files already exist, skipping copy...${NC}"
fi

# Update docker-compose.yml for the Laravel directory
echo -e "${RED}🔧 Updating docker-compose.yml for project: ${LARAVEL_DIR}...${NC}"
if [[ "$OSTYPE" == "darwin"* ]]; then
    # macOS
    sed -i '' "s|\./hello:|./${LARAVEL_DIR}:|g" docker-compose.yml
else
    # Linux
    sed -i "s|\./hello:|./${LARAVEL_DIR}:|g" docker-compose.yml
fi
echo -e "${GREEN}✅ Updated volume paths in docker-compose.yml${NC}"

# Copy .env.docker to Laravel .env
echo -e "${BLUE}⚙️  Setting up Laravel environment...${NC}"
if [ -f "$SCRIPT_DIR/.env.docker" ]; then
    cp "$SCRIPT_DIR/.env.docker" "$LARAVEL_DIR/.env"
    echo -e "${GREEN}✅ Copied Docker environment configuration to ${LARAVEL_DIR}/.env${NC}"
elif [ -f "./.env.docker" ]; then
    cp "./.env.docker" "$LARAVEL_DIR/.env"
    echo -e "${GREEN}✅ Copied Docker environment configuration to ${LARAVEL_DIR}/.env${NC}"
else
    echo -e "${RED}⚠️  Warning: .env.docker not found. You may need to configure the database settings manually.${NC}"
fi

# Start Docker containers
echo ""
echo -e "${BLUE}🐳 Starting Docker containers...${NC}"
docker-compose up -d

# Wait for containers to be ready
echo -e "${YELLOW}⏳ Waiting for containers to be ready...${NC}"
sleep 15

# Check if MySQL is ready
echo -e "${BLUE}🔍 Checking database connection...${NC}"
RETRY_COUNT=0
MAX_RETRIES=6

while [ $RETRY_COUNT -lt $MAX_RETRIES ]; do
    if docker exec laravel-php php -r "
        try { 
            new PDO('mysql:host=mysql;dbname=laravel', 'laravel', 'laravel_password'); 
            echo 'Connected to MySQL successfully';
            exit(0);
        } catch(Exception \$e) { 
            echo 'Database not ready yet...';
            exit(1);
        }" 2>/dev/null; then
        echo -e "${GREEN}✅ Database connection successful${NC}"
        break
    else
        RETRY_COUNT=$((RETRY_COUNT + 1))
        echo -e "${YELLOW}⏳ Database not ready yet, retrying... ($RETRY_COUNT/$MAX_RETRIES)${NC}"
        sleep 10
    fi
done

if [ $RETRY_COUNT -eq $MAX_RETRIES ]; then
    echo -e "${RED}❌ Database connection failed after $MAX_RETRIES attempts${NC}"
    echo -e "${YELLOW}💡 You can manually run: docker exec laravel-php php artisan key:generate${NC}"
    exit 1
fi

# Generate Laravel application key
echo -e "${BLUE}🔑 Generating Laravel application key...${NC}"
if docker exec laravel-php php artisan key:generate --no-interaction; then
    echo -e "${GREEN}✅ Laravel application key generated successfully${NC}"
else
    echo -e "${RED}❌ Failed to generate Laravel application key${NC}"
    echo -e "${YELLOW}💡 You can manually run: docker exec laravel-php php artisan key:generate${NC}"
fi

# Run database migrations
echo -e "${BLUE}🗄️  Running database migrations...${NC}"
if docker exec laravel-php php artisan migrate --no-interaction; then
    echo -e "${GREEN}✅ Database migrations completed successfully${NC}"
else
    echo -e "${RED}❌ Database migrations failed${NC}"
    echo -e "${YELLOW}💡 You can manually run: docker exec laravel-php php artisan migrate${NC}"
fi

echo ""
echo -e "${GREEN}🎉 Setup completed successfully!${NC}"
echo ""
echo -e "${YELLOW}📁 Project structure:${NC}"
echo "  ├── $LARAVEL_DIR/           ← Laravel application"
echo "  ├── docker/              ← Docker configuration"
echo "  ├── docker-compose.yml   ← Container setup (configured for $LARAVEL_DIR)"
echo "  └── composer.json        ← Management commands"
echo ""
echo -e "${GREEN}🌐 Your Laravel application is ready!${NC}"
echo -e "${GREEN}   Visit: http://localhost:8080${NC}"
echo ""
echo -e "${YELLOW}📋 Useful commands:${NC}"
echo "  composer run stop        # Stop Docker containers"
echo "  composer run shell       # Access PHP container"
echo "  composer run artisan     # Run Laravel artisan commands"
echo "  docker-compose logs -f   # View container logs"
echo ""
echo -e "${YELLOW}🔄 To restart everything:${NC}"
echo "  docker-compose down && docker-compose up -d"
echo ""
echo -e "${YELLOW}💡 To make another Laravel project:${NC}"
echo "  ./setup.sh              # Creates Laravel in 'hello' directory"
echo "  ./setup.sh webapp       # Creates Laravel in 'webapp' directory"
echo "  ./setup.sh api          # Creates Laravel in 'api' directory"