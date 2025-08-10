# JWT Token Authentication Demo

A simple PHP implementation of JWT (JSON Web Token) authentication for educational purposes.

## 📁 Project Structure

```
jwt_token/
├── index.html      # Web interface demo
├── SimpleJWT.php   # JWT encoding/decoding class
├── config.php      # Configuration and demo users
├── login.php       # Login endpoint (generates tokens)
├── protected.php   # Protected route (requires token)
└── README.md       # This file
```

## 🚀 How to Run

1. **Start PHP server:**
   ```bash
   cd jwt_token/
   php -S localhost:8000
   ```

2. **Open browser:**
   ```
   http://localhost:8000
   ```

## 🔐 Demo Accounts

| Username | Password    | Role  |
|----------|-------------|-------|
| john     | password123 | user  |
| admin    | admin123    | admin |

## 📋 API Endpoints

### POST /login.php
**Request:**
```json
{
    "username": "john",
    "password": "password123"
}
```

**Response:**
```json
{
    "message": "Login successful",
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "expires_in": 3600,
    "user": {
        "id": 1,
        "username": "john",
        "role": "user"
    }
}
```

### GET /protected.php
**Headers:**
```
Authorization: Bearer [your-jwt-token]
```

**Response:**
```json
{
    "message": "Access granted to protected resource",
    "user_data": { ... },
    "protected_data": { ... }
}
```

## 🎯 Learning Objectives

1. **Understand JWT Structure:**
   - Header (algorithm + type)
   - Payload (user data + claims)
   - Signature (verification)

2. **Token Generation:**
   - Create payload with user data
   - Set expiration time
   - Sign with secret key

3. **Token Verification:**
   - Parse JWT structure
   - Verify signature
   - Check expiration

4. **API Authentication:**
   - Send token in Authorization header
   - Protect routes with middleware
   - Handle authentication errors

## 🔧 Testing with cURL

**Login:**
```bash
curl -X POST http://localhost:8000/login.php \
  -H "Content-Type: application/json" \
  -d '{"username":"john","password":"password123"}'
```

**Access Protected Route:**
```bash
curl -X GET http://localhost:8000/protected.php \
  -H "Authorization: Bearer [your-token-here]"
```

## ⚠️ Important Notes

- This is a **simplified implementation** for educational purposes
- For production use, install `firebase/php-jwt` library
- Never expose secret keys in real applications
- Use HTTPS in production
- Store tokens securely (httpOnly cookies recommended)

## 🔍 Token Analysis

JWT tokens have 3 parts separated by dots:
```
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoxLCJ1c2VybmFtZSI6ImpvaG4iLCJleHAiOjE2ODc1NjAwMDB9.signature
```

1. **Header** (Base64 encoded):
   ```json
   {"alg":"HS256","typ":"JWT"}
   ```

2. **Payload** (Base64 encoded):
   ```json
   {"user_id":1,"username":"john","exp":1687560000}
   ```

3. **Signature** (HMAC-SHA256):
   ```
   HMACSHA256(header + "." + payload, secret)
   ```

## 🎓 Assignment Ideas

1. Add role-based access control
2. Implement token refresh mechanism
3. Add rate limiting to login endpoint
4. Create admin-only routes
5. Add password hashing with `password_hash()`
