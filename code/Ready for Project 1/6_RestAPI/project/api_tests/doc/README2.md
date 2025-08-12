# REST API Testing Guide

This directory contains simple educational examples for testing the Student Management REST API using **three different approaches**.

## 📁 Files Overview

### **Web-Based Testing (JavaScript)**
- **`index.html`** - Interactive web-based testing interface
- Best for beginners and visual learners

### **Command-Line Testing (Node.js)**
- **`test_runner.js`** - Node.js testing script with detailed validation
- **`run_tests.sh/.bat`** - Easy execution scripts

### **Command-Line Testing (CURL)**
- **`test_runner_curl.sh`** - Unix/Linux/Mac CURL testing script
- **`test_runner_curl.bat`** - Windows CURL testing script
- Universal tool available on most systems

### **Documentation**
- **`README.md`** - This comprehensive guide
- **`package.json`** - Node.js project configuration

## 🚀 Getting Started

### Prerequisites

1. **Start your PHP API server**:
   ```bash
   cd ../api
   php -S localhost:8000
   ```

2. **Verify the API is accessible** at `http://localhost:8000`

## 🌐 Method 1: Web-Based Testing (Recommended for Beginners)

1. Open `index.html` in your web browser
2. Make sure the API URL is set to `http://localhost:8000`
3. Click individual test buttons or "Run All Tests"
4. Observe the results with detailed explanations

**Features:**
- ✅ Visual pass/fail indicators
- 📊 Detailed test results with JSON responses
- 🎯 Educational explanations for each test
- 🔧 Configurable API URL
- 🎨 Color-coded results

## 💻 Method 2: Command-Line Testing (Node.js)

### Prerequisites
- Node.js installed (version 12 or higher)

### Usage
```bash
# Navigate to the tests directory
cd api_tests

# Run all tests
node test_runner.js

# Run with detailed JSON output
node test_runner.js --verbose

# Or use the convenience scripts
./run_tests.sh          # Linux/Mac
run_tests.bat           # Windows
```

**Features:**
- 🚀 Fast automated execution
- 📝 Detailed JSON validation
- 🎯 Precise error reporting
- 🔄 Integration-friendly

## 🌍 Method 3: CURL Testing (Universal)

### Prerequisites
- CURL installed (usually pre-installed on Linux/Mac, available for Windows)

### Usage
```bash
# Linux/Mac
chmod +x test_runner_curl.sh
./test_runner_curl.sh

# With verbose output
./test_runner_curl.sh --verbose

# Windows
test_runner_curl.bat
```

**Features:**
- 🌍 Works on any system with CURL
- 📜 Shell scripting examples
- ⚡ Lightweight and fast
- 🔧 Easy to modify and extend

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

## 📊 Comparison of Testing Methods

| Feature | Web Interface | Node.js | CURL |
|---------|--------------|---------|------|
| **Beginner Friendly** | ✅ Excellent | ⚠️ Medium | ⚠️ Medium |
| **Visual Feedback** | ✅ Rich UI | ⚠️ Console | ⚠️ Console |
| **Automation** | ❌ Manual | ✅ Excellent | ✅ Excellent |
| **Scripting** | ❌ Limited | ✅ Full JS | ✅ Shell |
| **Cross-Platform** | ✅ Browser | ✅ Node.js | ✅ CURL |
| **Prerequisites** | Just browser | Node.js | CURL |
| **JSON Validation** | ✅ Detailed | ✅ Advanced | ⚠️ Basic |
| **Learning Value** | ✅ High | ✅ High | ✅ High |

## 📚 Educational Value

These tests demonstrate important concepts:

### **HTTP Fundamentals**
- Status codes (200, 201, 404, etc.)
- Request methods (GET, POST, PUT, DELETE)
- Headers and content types
- Request/response structure

### **API Testing Patterns**
- Connection testing vs functional testing
- Data validation techniques
- Error handling approaches
- Test automation strategies

### **Programming Skills**
- **JavaScript**: Async/await, fetch API, JSON parsing
- **Shell Scripting**: Variables, conditionals, text processing
- **CURL**: Command-line tools, HTTP requests

### **Best Practices**
- Test structure (Arrange, Act, Assert)
- Independent test cases
- Comprehensive validation
- Clear error reporting

## 🔧 Customization Examples

### Adding a New Test Case

#### JavaScript (test_runner.js)
```javascript
async function testStudentValidation() {
    const invalidStudent = {
        name: '',  // Invalid: empty name
        email: 'invalid-email'  // Invalid: no @ symbol
    };
    
    const result = await makeRequest(`${API_BASE_URL}/students`, 'POST', invalidStudent);
    
    if (result.status === 400) {
        console.log('✅ Validation Test: API correctly rejects invalid data');
        return true;
    } else {
        console.log('❌ Validation Test: API should reject invalid data');
        return false;
    }
}
```

#### CURL (test_runner_curl.sh)
```bash
test_student_validation() {
    echo -e "${BLUE}Testing POST /students with invalid data...${NC}"
    
    local invalid_student='{
        "name": "",
        "email": "invalid-email"
    }'
    
    local response=$(make_curl_request "$API_BASE_URL/students" "POST" "$invalid_student")
    local http_code=$(echo "$response" | tail -n1)
    
    if [[ "$http_code" == "400" ]]; then
        print_result "Validation Test" "true" "API correctly rejects invalid data"
        return 0
    else
        print_result "Validation Test" "false" "API should reject invalid data"
        return 1
    fi
}
```

### Customizing API URL

#### Web Interface
Use the configuration section at the top of the page

#### Node.js
Edit the `API_BASE_URL` variable in `test_runner.js`

#### CURL Scripts
Edit the `API_BASE_URL` variable in the shell scripts

## 🐛 Troubleshooting

### Common Issues

#### **1. Connection Failed**
- **Check**: Is the PHP server running?
  ```bash
  cd ../api
  php -S localhost:8000
  ```
- **Check**: Is port 8000 available?
- **Check**: Firewall settings

#### **2. CORS Errors (Web Interface)**
- The PHP API includes CORS headers
- Try using a local web server instead of `file://` protocol

#### **3. Node.js Not Found**
- Install Node.js from [nodejs.org](https://nodejs.org)
- Ensure `node` command is in your PATH

#### **4. CURL Not Found**
- **Linux/Ubuntu**: `sudo apt-get install curl`
- **CentOS/RHEL**: `sudo yum install curl`
- **Windows**: Download from [curl.se](https://curl.se/windows/)
- **Mac**: Usually pre-installed

#### **5. Permission Denied (Shell Scripts)**
```bash
chmod +x test_runner_curl.sh
chmod +x run_tests.sh
```

### Debug Tips

#### **Verbose Output**
All testing methods support verbose output:
```bash
# Node.js
node test_runner.js --verbose

# CURL
./test_runner_curl.sh --verbose
```

#### **Check API Response Manually**
```bash
# Quick test with CURL
curl http://localhost:8000

# Detailed response
curl -v http://localhost:8000/students
```

#### **JSON Validation**
```bash
# Use jq for better JSON formatting
curl -s http://localhost:8000/students | jq .
```

## 🎯 Learning Progression

### **Beginner (Start Here)**
1. Use the **Web Interface** (`index.html`)
2. Understand the visual feedback
3. Learn about HTTP status codes
4. See JSON response structures

### **Intermediate**
1. Try the **Node.js** version (`test_runner.js`)
2. Understand async/await patterns
3. Learn JSON validation techniques
4. Practice command-line execution

### **Advanced**
1. Use the **CURL** scripts
2. Learn shell scripting patterns
3. Understand HTTP at the protocol level
4. Create custom test scenarios

## 🚀 Next Steps

### **Enhance Your Tests**
1. Add authentication testing
2. Test error scenarios (400, 401, 500)
3. Performance testing (response time)
4. Load testing (multiple concurrent requests)

### **Learn More Tools**
- **Postman** - GUI API testing tool
- **Insomnia** - Another excellent API client
- **Newman** - Command-line Postman runner
- **Jest/Mocha** - Advanced JavaScript testing frameworks

### **Advanced Concepts**
- Mocking and test data management
- Continuous Integration (CI/CD)
- API contract testing
- Security testing (OWASP API Security)

## 📖 Additional Resources

### **Documentation**
- [HTTP Status Codes](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status)
- [REST API Design](https://restfulapi.net/)
- [CURL Manual](https://curl.se/docs/manual.html)
- [JavaScript Fetch API](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API)

### **Tools**
- [JSONLint](https://jsonlint.com/) - JSON validator
- [jq](https://stedolan.github.io/jq/) - Command-line JSON processor
- [httpie](https://httpie.io/) - User-friendly HTTP client

### **Testing Frameworks**
- [Jest](https://jestjs.io/) - JavaScript testing framework
- [Supertest](https://github.com/visionmedia/supertest) - HTTP assertion library
- [Newman](https://learning.postman.com/docs/running-collections/using-newman-cli/command-line-integration-with-newman/) - Postman CLI

## 🎓 Assignment Ideas

### **Basic Level**
1. Run all three testing methods and compare results
2. Modify test data and observe responses
3. Add a new student record and test all CRUD operations

### **Intermediate Level**
1. Add validation tests for edge cases
2. Create tests for non-existent student IDs
3. Implement response time measurement

### **Advanced Level**
1. Create a complete test suite for a new endpoint
2. Add authentication and authorization tests
3. Implement database state verification

---

## 🎉 Conclusion

This testing suite provides three complementary approaches to API testing, each with its own strengths:

- **Web Interface**: Perfect for learning and demonstration
- **Node.js**: Great for detailed validation and programming practice  
- **CURL**: Excellent for automation and system integration

Choose the method that best fits your learning style and requirements. Remember, understanding the concepts is more important than the tools you use!

**Happy Testing!** 🧪