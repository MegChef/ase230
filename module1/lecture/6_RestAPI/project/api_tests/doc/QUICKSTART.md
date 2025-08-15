# 🚀 Quick Start Guide - REST API Testing

## Start Your API Server First!
```bash
cd ../api
php -S localhost:8000
```

## Choose Your Testing Method:

### 1. 🌐 Web Interface (Best for Beginners)
```bash
# Simply open in your browser:
open index.html
```
- ✅ Visual interface
- ✅ Interactive testing
- ✅ Detailed explanations

### 2. 💻 JavaScript CLI (Advanced)
```bash
# Requires Node.js
node test_runner.js
node test_runner.js --verbose

# Or use convenience scripts
./run_tests.sh          # Linux/Mac
run_tests.bat           # Windows
```
- ✅ Detailed JSON validation
- ✅ Programming examples
- ✅ Automated execution

### 3. 🛠️ CURL Scripts (Universal)
```bash
# Make executable first (Linux/Mac)
chmod +x test_runner_curl.sh

# Run tests
./test_runner_curl.sh            # Linux/Mac
./test_runner_curl.sh --verbose  # With detailed output
test_runner_curl.bat             # Windows
```
- ✅ Works everywhere CURL is available
- ✅ Shell scripting examples
- ✅ Fast and lightweight

## Expected Output:
```
✅ Server Connection: Server is responding correctly!
✅ API Root: API root returns expected structure!
✅ Get All Students: All tests passed (3/3)
✅ Get Single Student: All tests passed (4/4)
✅ Create Student: Created student with ID: 4
✅ Update Student: All tests passed (3/3)  
✅ Delete Student: Student 4 deleted successfully!

📊 Test Summary
Total Tests: 7
Passed: 7
Failed: 0
🎉 All tests passed!
```

## Troubleshooting:
- **Connection Failed**: Check if PHP server is running on port 8000
- **Node.js Error**: Install Node.js from nodejs.org
- **CURL Error**: Install curl for your system
- **Permission Denied**: Run `chmod +x *.sh` on Linux/Mac

## What Gets Tested:
1. **Connection Tests**: Is the server alive?
2. **GET Tests**: Can we retrieve data?
3. **POST Tests**: Can we create new records?
4. **PUT Tests**: Can we update existing records?
5. **DELETE Tests**: Can we remove records?

**Happy Testing!** 🧪