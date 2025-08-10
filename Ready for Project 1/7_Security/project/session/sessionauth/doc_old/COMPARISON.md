# Side-by-Side Comparison

## Login Process

### Basic Version (login.php)
```php
session_start();

if ($_POST['username'] == 'john' && $_POST['password'] == 'secret') {
    $_SESSION['user_id'] = 1;
    $_SESSION['username'] = 'john';
    $_SESSION['logged_in'] = true;
    header('Location: welcome.php');
    exit;
}
```

### SessionAuth Version (login.php)
```php
require_once 'SessionAuth.php';
$auth = new SessionAuth();

if ($_POST['username'] == 'john' && $_POST['password'] == 'secret') {
    $user_data = ['id' => 1, 'username' => 'john'];
    $auth->login_user($user_data);  // Includes session_regenerate_id()!
    header('Location: welcome.php');
    exit;
}
```

## Protected Page Authentication

### Basic Version (welcome.php)
```php
session_start();

if (!$_SESSION['logged_in']) {
    header('Location: login.php');
    exit;
}
```

### SessionAuth Version (welcome.php)  
```php
require_once 'SessionAuth.php';
$auth = new SessionAuth();

$auth->require_auth();  // One line!
```

## Logout Process

### Basic Version (logout.php)
```php
session_start();
session_destroy();
```

### SessionAuth Version (logout.php)
```php
require_once 'SessionAuth.php';
$auth = new SessionAuth();
$auth->logout_user();  // Does session_unset() + session_destroy()
```

## Benefits of SessionAuth

1. **Less Code**: No repetition of authentication logic
2. **More Secure**: Automatic session regeneration prevents attacks  
3. **Less Errors**: Can't forget session_start() or proper cleanup
4. **Consistent**: Same behavior across all pages

The HTML output is identical - only the PHP code is improved!
