# 🚀 User Management REST API

A complete, educational REST API implementation in PHP for managing users. This project demonstrates modern API development concepts including RESTful design, proper HTTP status codes, data validation, error handling, and more.

## 📁 Project Structure

```
api/
├── index.php          # Main API router and entry point
├── config/
│   └── database.php   # Database configuration (supports both file and MySQL)
├── models/
│   └── User.php       # User data model with CRUD operations
├── data/              # File storage directory (auto-created)
│   └── users.json     # JSON file for storing user data
└── .htaccess          # URL rewriting rules for clean URLs

test-client.html       # Interactive web-based API testing interface
README.md             # This documentation file
```

## 🎯 Learning Objectives

Students will learn:
- REST API design principles
- HTTP methods and status codes
- JSON request/response handling
- Data validation and error handling
- URL routing and clean URLs
- CRUD operations
- File-based vs database storage
- API testing techniques

## 🌟 Features

### Core API Features
- **RESTful Design**: Follows REST conventions
- **Full CRUD Operations**: Create, Read, Update, Delete users
- **Data Validation**: Comprehensive input validation
- **Error Handling**: Proper HTTP status codes and error messages
- **Search & Pagination**: Query users with search and pagination
- **CORS Support**: Cross-origin resource sharing enabled
- **Clean URLs**: User-friendly URL structure

### Educational Features
- **File-Based Storage**: No database setup required for beginners
- **MySQL Support**: Easy upgrade to real database
- **Comprehensive Comments**: Well-documented code
- **Test Interface**: Interactive web-based testing tool
- **Progressive Complexity**: Start simple, add advanced features

## 🚀 Quick Start

### 1. Setup
```bash
# Clone or download the project
# Place the 'api' folder in your web server directory

# For XAMPP/WAMP/MAMP users:
# Place in: htdocs/your-project-name/

# For built-in PHP server:
cd path/to/project
php -S localhost:8000 -t api
```

### 2. Test the API
Open your browser and navigate to:
- **API Root**: `http://localhost:8000/` (shows available endpoints)
- **Test Interface**: Open `test-client.html` in your browser

### 3. Make Your First API Call
```bash
# Get all users
curl -X GET http://localhost:8000/users

# Create a new user
curl -X POST http://localhost:8000/users \
  -H "Content-Type: application/json" \
  -d '{"name": "Alice Johnson", "email": "alice@example.com"}'
```

## 📋 API Endpoints

### Base URL
- Development: `http://localhost:8000/`
- With subdirectory: `http://localhost/your-project/api/`

### Endpoints

| Method | Endpoint | Description | Example |
|--------|----------|-------------|---------|
| GET | `/users` | Get all users | `GET /users?search=john&page=1&limit=10` |
| GET | `/users/{id}` | Get specific user | `GET /users/1` |
| POST | `/users` | Create new user | `POST /users` |
| PUT | `/users/{id}` | Update user | `PUT /users/1` |
| DELETE | `/users/{id}` | Delete user | `DELETE /users/1` |

### Query Parameters

#### GET /users
- `search` (string): Search in name and email
- `page` (integer): Page number (default: 1)
- `limit` (integer): Items per page (max: 100)

Example: `GET /users?search=john&page=2&limit=5`

## 📝 Request/Response Examples

### 1. Get All Users
```bash
GET /users
```

**Response:**
```json
{
  "success": true,
  "data": {
    "users": [
      {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "phone": "+1-555-0101",
        "created_at": "2025-01-01 10:00:00",
        "updated_at": "2025-01-01 10:00:00"
      }
    ],
    "total": 1,
    "page": 1,
    "limit": null
  },
  "timestamp": "2025-08-03T15:30:00+00:00"
}
```

### 2. Get Single User
```bash
GET /users/1
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+1-555-0101",
    "created_at": "2025-01-01 10:00:00",
    "updated_at": "2025-01-01 10:00:00"
  },
  "timestamp": "2025-08-03T15:30:00+00:00"
}
```

### 3. Create New User
```bash
POST /users
Content-Type: application/json

{
  "name": "Alice Johnson",
  "email": "alice@example.com",
  "phone": "+1-555-0104"
}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 4,
    "name": "Alice Johnson",
    "email": "alice@example.com",
    "phone": "+1-555-0104",
    "created_at": "2025-08-03 15:30:00",
    "updated_at": "2025-08-03 15:30:00"
  },
  "message": "User created successfully",
  "timestamp": "2025-08-03T15:30:00+00:00"
}
```

### 4. Update User
```bash
PUT /users/1
Content-Type: application/json

{
  "name": "John Smith",
  "phone": "+1-555-9999"
}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "John Smith",
    "email": "john@example.com",
    "phone": "+1-555-9999",
    "created_at": "2025-01-01 10:00:00",
    "updated_at": "2025-08-03 15:35:00"
  },
  "message": "User updated successfully",
  "timestamp": "2025-08-03T15:35:00+00:00"
}
```

### 5. Delete User
```bash
DELETE /users/1
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "John Smith",
    "email": "john@example.com",
    "phone": "+1-555-9999",
    "created_at": "2025-01-01 10:00:00",
    "updated_at": "2025-08-03 15:35:00"
  },
  "message": "User deleted successfully",
  "timestamp": "2025-08-03T15:35:00+00:00"
}
```

## ❌ Error Responses

### Validation Error
```json
{
  "success": false,
  "error": "Validation failed",
  "message": "Email is required, Email format is invalid",
  "timestamp": "2025-08-03T15:30:00+00:00"
}
```

### Not Found Error
```json
{
  "success": false,
  "error": "User not found",
  "timestamp": "2025-08-03T15:30:00+00:00"
}
```

### Server Error
```json
{
  "success": false,
  "error": "Internal Server Error",
  "message": "Detailed error message",
  "timestamp": "2025-08-03T15:30:00+00:00"
}
```

## 🛠️ Testing the API

### 1. Using the Web Interface
Open `test-client.html` in your browser for an interactive testing experience.

### 2. Using cURL
```bash
# Get all users
curl -X GET http://localhost:8000/users

# Get user by ID
curl -X GET http://localhost:8000/users/1

# Create user
curl -X POST http://localhost:8000/users \
  -H "Content-Type: application/json" \
  -d '{"name": "Test User", "email": "test@example.com"}'

# Update user
curl -X PUT http://localhost:8000/users/1 \
  -H "Content-Type: application/json" \
  -d '{"name": "Updated Name"}'

# Delete user
curl -X DELETE http://localhost:8000/users/1
```

### 3. Using JavaScript (Fetch API)
```javascript
// Get all users
async function getUsers() {
  const response = await fetch('/api/users');
  const data = await response.json();
  console.log(data);
}

// Create user
async function createUser(userData) {
  const response = await fetch('/api/users', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(userData)
  });
  const data = await response.json();
  console.log(data);
}
```

## 🗄️ Data Storage Options

### File-Based Storage (Default)
- **Location**: `api/data/users.json`
- **Pros**: No database setup required, perfect for learning
- **Cons**: Not suitable for production, no concurrent access protection

### MySQL Database (Advanced)
To enable MySQL storage:

1. **Create Database:**
```sql
CREATE DATABASE user_api_db;
USE user_api_db;
```

2. **Update Configuration:**
In `config/database.php`, change:
```php
private static $use_database = true;
```

3. **Update Database Credentials:**
```php
private static $host = 'localhost';
private static $database_name = 'user_api_db';
private static $username = 'your_username';
private static $password = 'your_password';
```

## 🔒 Data Validation Rules

### User Fields
- **name** (required): 2-100 characters
- **email** (required): Valid email format, must be unique
- **phone** (optional): Valid phone number format

### Validation Examples
```json
// Valid user data
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "+1-555-0123"
}

// Invalid user data (will return validation errors)
{
  "name": "J",           // Too short
  "email": "invalid",    // Invalid format
  "phone": "abc123"      // Invalid format
}
```

## 🎓 Student Exercises

### Beginner Level
1. **Test All Endpoints**: Use the web interface to test all CRUD operations
2. **Create Multiple Users**: Add 5 different users with various data
3. **Test Validation**: Try to create users with invalid data and observe errors
4. **Search Functionality**: Test the search feature with different keywords

### Intermediate Level
1. **Add New Fields**: Extend the User model to include `age` and `city`
2. **Implement Sorting**: Add sorting by name, email, or creation date
3. **Add Bulk Operations**: Create endpoint to create/update multiple users
4. **File Upload**: Add profile picture upload functionality

### Advanced Level
1. **Authentication**: Implement JWT-based authentication
2. **Database Migration**: Switch from file storage to MySQL
3. **API Versioning**: Create v2 of the API with enhanced features
4. **Rate Limiting**: Implement request rate limiting
5. **Unit Tests**: Write PHPUnit tests for all endpoints

## 🐛 Common Issues & Solutions

### 1. 404 Error on API Calls
**Problem**: URLs return 404 errors
**Solution**: 
- Check if `.htaccess` is working (Apache mod_rewrite enabled)
- Use `index.php` directly: `/api/index.php/users`
- For nginx, configure URL rewriting

### 2. CORS Issues
**Problem**: Browser blocks API calls from different origins
**Solution**: Headers are already configured in `.htaccess` and `index.php`

### 3. File Permissions
**Problem**: Cannot write to data directory
**Solution**:
```bash
chmod 755 api/data/
chmod 666 api/data/users.json
```

### 4. PHP Version Issues
**Minimum PHP Version**: 7.4+
**Required Extensions**: json, pdo (for MySQL)

## 📚 Learning Resources

### REST API Concepts
- [REST API Tutorial](https://restfulapi.net/)
- [HTTP Status Codes](https://httpstatuses.com/)
- [JSON API Specification](https://jsonapi.org/)

### PHP Development
- [PHP Documentation](https://www.php.net/docs.php)
- [PDO Tutorial](https://phpdelusions.net/pdo)

### Testing Tools
- [Postman](https://www.postman.com/) - API testing tool
- [Insomnia](https://insomnia.rest/) - Alternative to Postman
- [HTTPie](https://httpie.io/) - Command-line HTTP client

## 🔄 Version History

### v1.0 (Current)
- Complete REST API implementation
- File-based storage
- MySQL support
- Interactive test client
- Comprehensive documentation
- Student exercises

### Planned Features
- Authentication system
- API versioning
- Rate limiting
- Automated testing
- Docker support

## 📞 Support

For questions or issues:
1. Check the common issues section
2. Review the code comments
3. Test with the provided web interface
4. Ask your instructor for help

## 🏆 Best Practices Demonstrated

This project showcases:
- **RESTful Design**: Proper use of HTTP methods and status codes
- **Clean Code**: Well-organized, commented code structure
- **Error Handling**: Comprehensive error handling and validation
- **Security**: Input validation and data sanitization
- **Scalability**: Easy transition from file to database storage
- **Documentation**: Complete API documentation with examples
- **Testing**: Interactive testing interface for easy verification

Happy coding! 🚀
