# Bearer Token Authentication Examples 🔐

This directory contains simple PHP examples demonstrating bearer token authentication for APIs.

## 📁 Files Overview

| File | Purpose | Description |
|------|---------|-------------|
| `bearer_auth.php` | Helper Functions | Core functions for token handling |
| `login.php` | Login Endpoint | Authenticates users and returns tokens |
| `protected_api.php` | Protected API | Example API that requires bearer token |
| `client_demo.html` | Frontend Demo | Interactive web interface to test the API |
| `test_curl.sh` | cURL Examples | Command-line testing examples |
| `README.md` | Documentation | This file |

## 🚀 Quick Start

### 1. Setup
Make sure you have a PHP server running. You can use:
```bash
# Start PHP built-in server
php -S localhost:8000
```

### 2. Test with Browser
Open `client_demo.html` in your browser and follow the interactive demo.

### 3. Test with cURL
Run the cURL examples:
```bash
chmod +x test_curl.sh
./test_curl.sh
```

## 🔑 How It Works

### Step 1: Login to Get Token
```bash
curl -X POST http://localhost:8000/login.php \
     -H "Content-Type: application/json" \
     -d '{"username":"student","password":"student123"}'
```

**Response:**
```json
{
  "message": "Login successful",
  "token": "student123",
  "user": "student",
  "expires_in": 3600
}
```

### Step 2: Use Token for API Access
```bash
curl -H "Authorization: Bearer student123" \
     http://localhost:8000/protected_api.php
```

**Response:**
```json
{
  "message": "Welcome to the protected API!",
  "authenticated_user": "student",
  "timestamp": "2025-08-05 10:30:00",
  "data": {
    "secret_info": "This is confidential data",
    "user_permissions": ["read", "write"],
    "server_info": "PHP 8.1.0"
  },
  "student_data": {
    "enrolled_courses": ["ASE230"],
    "grades": ["A", "B+", "A-"],
    "next_assignment": "Bearer Token Project"
  }
}
```

## 👥 Test Users

| Username | Password | Token | Role |
|----------|----------|-------|------|
| `student` | `student123` | `student123` | Student |
| `teacher` | `teacher456` | `teacher456` | Teacher |
| `admin_user` | `admin789` | `def456` | Admin |
| `john_doe` | `password123` | `abc123` | User |
| `jane_smith` | `secret456` | `xyz789` | User |

## 📊 HTTP Status Codes

| Code | Meaning | When |
|------|---------|------|
| `200` | Success | Valid token, authorized access |
| `400` | Bad Request | Missing username/password |
| `401` | Unauthorized | Invalid/missing token |
| `405` | Method Not Allowed | Wrong HTTP method |

## 🛡️ Security Features Demonstrated

### ✅ What This Demo Shows
- **Bearer token extraction** from Authorization header
- **Token validation** against known tokens
- **Proper HTTP status codes** for different scenarios
- **JSON API responses** with error handling
- **Role-based data** (different data for students/teachers/admins)

### ⚠️ Production Considerations
This is a **learning demo**. In production, you should:

1. **Use HTTPS only** - Never send tokens over HTTP
2. **Hash passwords** - Store bcrypt/argon2 hashes, not plain text
3. **Database storage** - Store tokens in database with expiration
4. **Secure token generation** - Use cryptographically secure random tokens
5. **Token expiration** - Implement automatic token expiry
6. **Rate limiting** - Prevent brute force attacks
7. **Input validation** - Sanitize and validate all inputs

## 🔧 Understanding the Code

### Bearer Token Format
```
Authorization: Bearer TOKEN_HERE
```

### Token Extraction (PHP)
```php
function getBearerToken() {
    $headers = getallheaders();
    if (isset($headers['Authorization'])) {
        if (preg_match('/Bearer\s+(.*)$/i', $headers['Authorization'], $matches)) {
            return trim($matches[1]);
        }
    }
    return null;
}
```

### Token Validation (Simplified)
```php
function isValidToken($token) {
    $validTokens = [
        'abc123' => 'john_doe',
        'xyz789' => 'jane_smith'
    ];
    return isset($validTokens[$token]) ? $validTokens[$token] : false;
}
```

## 🧪 Testing Scenarios

### Valid Token Test
```bash
curl -H "Authorization: Bearer student123" \
     http://localhost:8000/protected_api.php
# Expected: 200 OK with protected data
```

### Invalid Token Test
```bash
curl -H "Authorization: Bearer invalid123" \
     http://localhost:8000/protected_api.php
# Expected: 401 Unauthorized
```

### Missing Token Test
```bash
curl http://localhost:8000/protected_api.php
# Expected: 401 Unauthorized
```

### Wrong Login Credentials
```bash
curl -X POST http://localhost:8000/login.php \
     -H "Content-Type: application/json" \
     -d '{"username":"student","password":"wrong"}'
# Expected: 401 Unauthorized
```

## 🎯 Learning Objectives

After completing this demo, students should understand:

1. **What bearer tokens are** and why they're used
2. **How to implement** token-based authentication in PHP
3. **HTTP Authorization header** format and extraction
4. **Proper error handling** with HTTP status codes
5. **Client-side token usage** in JavaScript and cURL
6. **Security considerations** for production applications

## 🔗 Next Steps

1. **Add database storage** for tokens and users
2. **Implement token expiration** with timestamp checking
3. **Add refresh token** functionality
4. **Explore JWT tokens** for stateless authentication
5. **Add role-based permissions** beyond simple user identification
6. **Implement proper password hashing** with PHP's `password_hash()`

## 📚 Additional Resources

- [HTTP Authentication - MDN](https://developer.mozilla.org/en-US/docs/Web/HTTP/Authentication)
- [RFC 6750 - Bearer Token Usage](https://tools.ietf.org/html/rfc6750)
- [JWT.io - JSON Web Tokens](https://jwt.io/)
- [PHP password_hash() Documentation](https://www.php.net/manual/en/function.password-hash.php)

---

**Remember**: This is for educational purposes. Always follow security best practices in production applications! 🔒