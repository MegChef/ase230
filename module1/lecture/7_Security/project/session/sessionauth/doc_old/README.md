# SessionAuth Demo - Simple Version

This is a clean rewrite of the basic session demo using the SessionAuth class.

## Key Differences from Basic Version

### Code Comparison

**Basic Version:**
```php
// Every file needs this
session_start();

// Login
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'john';  
$_SESSION['logged_in'] = true;
// No session regeneration!

// Auth check (copy to every protected page)
if (!$_SESSION['logged_in']) {
    header('Location: login.php');
    exit;
}

// Logout
session_destroy();
```

**SessionAuth Version:**
```php
// One time setup
require_once 'SessionAuth.php';
$auth = new SessionAuth();

// Login with security
$auth->login_user(['id' => 1, 'username' => 'john']);

// Auth check (one line)
$auth->require_auth();

// Logout with cleanup
$auth->logout_user();
```

## Security Improvements

1. **Session Fixation Prevention**: Automatic session ID regeneration on login
2. **Complete Cleanup**: Proper session_unset() + session_destroy() on logout  
3. **Consistent Authentication**: Same protection logic everywhere

## Files

- `SessionAuth.php` - The authentication class
- `index.php` - Home page (same as basic, but uses SessionAuth)
- `login.php` - Login form (same as basic, but uses SessionAuth)  
- `welcome.php` - Protected page (much cleaner auth check)
- `logout.php` - Logout (same as basic, but uses SessionAuth)
- `check.php` - Session info (same as basic, but uses SessionAuth)

## Try It

1. Login with john/secret
2. Check session info to see the session ID
3. Notice the session ID changes when you login (security feature!)
4. Try accessing welcome.php after logout (should redirect)

The functionality is identical to the basic version, but the code is cleaner and more secure.
