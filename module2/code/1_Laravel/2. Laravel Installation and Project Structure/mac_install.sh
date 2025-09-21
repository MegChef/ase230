#!/bin/bash
# Laravel Development Environment Setup for macOS

echo "=== Laravel Development Environment Setup for macOS ==="

# Check current versions
echo "Checking current installations..."
which php
php -v
which composer
which mysql

echo "=== Installing Homebrew (if not installed) ==="
# Install Homebrew if not present
if ! command -v brew &> /dev/null; then
    echo "Installing Homebrew..."
    /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
else
    echo "Homebrew already installed"
fi

# Update Homebrew
echo "Updating Homebrew..."
brew update

echo "=== Installing PHP ==="
# Install PHP (will install latest stable version, usually 8.2+ or 8.3+)
brew install php

# Install additional PHP extensions if needed
# Note: Most extensions come with Homebrew PHP by default
echo "PHP extensions are included with Homebrew PHP installation"

echo "=== Installing Composer ==="
# Install Composer
brew install composer

echo "=== Installing MySQL ==="
# Install MySQL
brew install mysql

echo "=== Starting MySQL Service ==="
# Start MySQL service
brew services start mysql

echo "=== Checking installations ==="
# Check versions
echo "PHP Version:"
php --version        # Should be 8.2+

echo "Composer Version:"
composer --version   # Should be installed

echo "MySQL Version:"
mysql --version      # Should be installed

echo "=== Checking MySQL Connection ==="
# Check if MySQL is running on port 3306
echo "Checking MySQL port 3306:"
lsof -nP -iTCP:3306 -sTCP:LISTEN

echo "=== MySQL Configuration ==="
echo "Setting up MySQL root password..."
echo "Run the following commands manually:"
echo "mysql -u root"
echo "Then in MySQL prompt:"
echo "ALTER USER 'root'@'localhost' IDENTIFIED BY '123456';"
echo "FLUSH PRIVILEGES;"
echo "EXIT;"

echo "=== Installing Additional Tools ==="
# Install dos2unix for file conversion
brew install dos2unix

echo "=== Installation Complete ==="
echo "Summary:"
echo "✅ PHP: $(php --version | head -1)"
echo "✅ Composer: $(composer --version)"
echo "✅ MySQL: $(mysql --version)"
echo ""
echo "Next steps:"
echo "1. Configure MySQL root password"
echo "2. Test Laravel installation with: laravel new test-project"
echo "3. Start development server with: php artisan serve"