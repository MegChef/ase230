<h1>Authentication Demo - Super Simple</h1>

<h2>What is authentication?</h2>
<p>Authentication is <strong>"Who are you?"</strong> - proving your identity with username and password.</p>

<h2>Why authentication matters:</h2>
<ul>
    <li><strong>Security:</strong> Protects user accounts and sensitive data</li>
    <li><strong>Access Control:</strong> Only authorized users can perform actions</li>
    <li><strong>User Experience:</strong> Personalized content and settings</li>
    <li><strong>Business Logic:</strong> Different users have different permissions</li>
</ul>

<h2>Examples:</h2>
<p><a href="basic_auth.php">1. Basic Authentication (simple example)</a></p>
<p><a href="register.php">2. User Registration</a></p>
<p><a href="login.php">3. User Login</a></p>
<p><a href="dashboard.php">4. Protected Dashboard</a></p>
<p><a href="change_password.php">5. Change Password</a></p>
<p><a href="user_management.php">6. User Management</a></p>
<p><a href="logout.php">7. User Logout</a></p>

<h3>🔒 Security Principles:</h3>
<div style="background: #ffeeee; padding: 10px; border-left: 4px solid red;">
    <strong>NEVER store plain passwords!</strong><br>
    ❌ Dangerous: $password = "secret123"<br>
    ✅ Safe: $hash = password_hash("secret123", PASSWORD_DEFAULT)
</div>

<div style="background: #eeffee; padding: 10px; border-left: 4px solid green; margin-top: 10px;">
    <strong>Always verify passwords properly!</strong><br>
    ✅ Safe: password_verify($input, $stored_hash)
</div>

<h3>📊 Authentication Flow:</h3>
<ol>
    <li><strong>Registration:</strong> User creates account → Hash password → Store in database</li>
    <li><strong>Login:</strong> User enters credentials → Verify password → Create session</li>
    <li><strong>Access:</strong> Check session on protected pages</li>
    <li><strong>Logout:</strong> Destroy session → Redirect to login</li>
</ol>
