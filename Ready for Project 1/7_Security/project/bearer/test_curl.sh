#!/bin/bash

# Bearer Token Authentication - cURL Examples
# This file demonstrates how to use bearer tokens with cURL

echo "🔐 Bearer Token Authentication Examples"
echo "======================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Base URL (adjust if needed)
BASE_URL="http://localhost:8000"

echo -e "${BLUE}Step 1: Login to get a bearer token${NC}"
echo "======================================"
echo ""

echo "Login with valid credentials:"
echo "curl -X POST $BASE_URL/login.php \\"
echo "     -H \"Content-Type: application/json\" \\"
echo "     -d '{\"username\":\"student\",\"password\":\"student123\"}'"
echo ""

echo -e "${YELLOW}Try this command:${NC}"
curl -X POST $BASE_URL/login.php \
     -H "Content-Type: application/json" \
     -d '{"username":"student","password":"student123"}'
echo ""
echo ""

echo -e "${BLUE}Step 2: Use the token to access protected API${NC}"
echo "=============================================="
echo ""

echo "Access protected endpoint with valid token:"
echo "curl -H \"Authorization: Bearer student123\" \\"
echo "     $BASE_URL/protected_api.php"
echo ""

echo -e "${YELLOW}Try this command:${NC}"
curl -H "Authorization: Bearer student123" \
     $BASE_URL/protected_api.php
echo ""
echo ""

echo -e "${BLUE}Step 3: Test with invalid token${NC}"
echo "=================================="
echo ""

echo "Try with invalid token:"
echo "curl -H \"Authorization: Bearer invalid_token\" \\"
echo "     $BASE_URL/protected_api.php"
echo ""

echo -e "${YELLOW}This should return an error:${NC}"
curl -H "Authorization: Bearer invalid_token" \
     $BASE_URL/protected_api.php
echo ""
echo ""

echo -e "${BLUE}Step 4: Test without token${NC}"
echo "============================="
echo ""

echo "Try without any token:"
echo "curl $BASE_URL/protected_api.php"
echo ""

echo -e "${YELLOW}This should also return an error:${NC}"
curl $BASE_URL/protected_api.php
echo ""
echo ""

echo -e "${GREEN}Summary:${NC}"
echo "========"
echo "✅ Valid token: Returns protected data"
echo "❌ Invalid token: Returns 401 error"
echo "❌ No token: Returns 401 error"
echo ""

echo -e "${BLUE}Valid tokens for testing:${NC}"
echo "- student123 (user: student)"
echo "- teacher456 (user: teacher)"
echo "- abc123 (user: john_doe)"
echo "- xyz789 (user: jane_smith)"
echo "- def456 (user: admin_user)"
echo ""

echo -e "${BLUE}Other users you can login with:${NC}"
echo "- username: teacher, password: teacher456"
echo "- username: admin_user, password: admin789"
echo "- username: john_doe, password: password123"
echo "- username: jane_smith, password: secret456"