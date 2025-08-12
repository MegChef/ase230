# REST API Testing Guide

This directory contains simple educational examples for testing the Student Management REST API.

## 📁 Files Overview

- **`index.html`** - Interactive web-based testing interface
- **`test_runner.js`** - Command-line testing script
- **`README.md`** - This guide

## 🚀 Getting Started

### Prerequisites

1. Make sure your PHP API server is running:
   ```bash
   cd ../api
   php -S localhost:8000
   ```

2. The API should be accessible at `http://localhost:8000`

## 🌐 Web-Based Testing (Recommended for Beginners)

1. Open `index.html` in your web browser
2. Make sure the API URL is set to `http://localhost:8000`
3. Click individual test buttons or "Run All Tests"
4. Observe the results with detailed explanations

**Features:**
- ✅ Visual pass/fail indicators
- 📊 Detailed test results with JSON responses
- 🎯 Educational explanations for each test
- 🔧 Configurable API URL

## 💻 Command-Line Testing (For Advanced Users)

1. Open terminal/command prompt
2. Navigate to this directory
3. Run the test script:
   ```bash
   node test_runner.js
   ```

**Options:**
- `--verbose` - Show detailed JSON responses

**Example:**
```bash
node test_runner.js --verbose
```

## 🧪 What These Tests Do

### Part 1: Basic Connection Tests
1. **Server Connection** - Checks if the API server is running
2. **API Root Endpoint** - Verifies the root endpoint returns API information

### Part 2: Functional Tests (Unit Test Style)
1. **Get All Students** - Tests `GET /students` endpoint
2. **Get Single Student** - Tests `GET /students/{id}` endpoint
3. **Create New Student** - Tests `POST /students` endpoint
4. **Update Student** - Tests `PUT /students/{id}` endpoint
5. **Delete Student** - Tests `DELETE /students/{id}` endpoint

## 📚 Educational Value

These tests demonstrate:

- **HTTP Status Codes**: Understanding 200, 201, 404, etc.
- **Request Methods**: GET, POST, PUT, DELETE
- **JSON Validation**: Checking response structure and data types
- **API Testing Patterns**: Connection → Functional → Cleanup
- **Error Handling**: Managing failed requests and network issues

## 🔧 Customization

### Change API URL
- **Web**: Use the configuration section at the top
- **CLI**: Edit the `API_BASE_URL` variable in `test_runner.js`

### Add New Tests
1. Create a new test function following the existing pattern
2. Add validation logic specific to your test case
3. Include the test in the main test runner

## 🎯 Learning Objectives

After using these tests, students should understand:

1. How to make HTTP requests to REST APIs
2. How to validate API responses
3. The importance of testing different HTTP methods
4. How to structure automated tests
5. The difference between connection tests and functional tests

## 🐛 Troubleshooting

**Common Issues:**

1. **Connection Failed**
   - Make sure PHP server is running: `php -S localhost:8000`
   - Check if port 8000 is available
   - Verify API URL configuration

2. **CORS Errors** (Web version)
   - The PHP API includes CORS headers
   - Try using a local web server instead of file:// protocol

3. **JSON Parse Errors**
   - Check if the API is returning valid JSON
   - Look for PHP errors in the server output

4. **Node.js Not Found** (CLI version)
   - Install Node.js from nodejs.org
   - Ensure node command is in your PATH

## 📖 Next Steps

1. Try modifying the test data to see how the API responds
2. Add new test cases for edge cases
3. Implement error scenario testing
4. Learn about more advanced testing frameworks like Jest or Mocha