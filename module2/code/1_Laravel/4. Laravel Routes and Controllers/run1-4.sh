#!/bin/bash

# Simple Laravel Student API Setup Script
SOURCE_DIR="student-api1-4"
TARGET_DIR="student-api"

set -e

echo "Creating Laravel project..."
composer create-project laravel/laravel $TARGET_DIR
cd $TARGET_DIR

echo "Generating Student controller..."
php artisan make:controller StudentController --api

echo "Copying Controllers..."
CONTROLLER_DIR=app/Http/Controllers
mkdir -p $CONTROLLER_DIR/Api
SRC_PATH=$CONTROLLER_DIR/Api/StudentController.php
cp "../$SOURCE_DIR/$SRC_PATH" $SRC_PATH
SRC_PATH=$CONTROLLER_DIR/StudentController.php
cp "../$SOURCE_DIR/$SRC_PATH" $SRC_PATH

# Copy API configuration files
echo "Copying bootstrap/app.php with API routes enabled..."
SRC_PATH=bootstrap/app.php
cp "../$SOURCE_DIR/$SRC_PATH" $SRC_PATH

echo "Copying routes/api.php with test routes..."
SRC_PATH=routes/api.php
cp "../$SOURCE_DIR/$SRC_PATH" $SRC_PATH
SRC_PATH=routes/web.php
cp "../$SOURCE_DIR/$SRC_PATH" $SRC_PATH

#echo "Running database migrations..."
#php artisan migrate

echo "Verifying API routes..."
php artisan route:list --path=api

echo ""
echo "✅ Setup complete!"
echo ""
echo "To start server:"
echo "  cd $TARGET_DIR"
echo "  php artisan serve"
echo "  WSL2: php artisan serve --host=0.0.0.0"
echo ""
echo "To test API endpoints:"
echo "  curl http://localhost:8000/api/test"
echo "  curl http://localhost:8000/api/hello"
echo "  curl http://localhost:8000/api/hello/YourName"
echo ""
echo "To see all API routes:"
echo "  php artisan route:list --path=api"
