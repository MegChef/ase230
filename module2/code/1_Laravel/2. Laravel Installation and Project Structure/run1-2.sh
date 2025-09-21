#!/bin/bash

# Simple Laravel Student API Setup Script
TARGET_DIR="student-api"

set -e

echo "Creating Laravel project..."
composer create-project laravel/laravel $TARGET_DIR
cd $TARGET_DIR

echo ""
echo "✅ Setup complete!"
echo ""
echo "To start server:"
echo "  cd $TARGET_DIR"
echo "  php artisan serve"
echo "  WSL2: php artisan serve --host=0.0.0.0"
