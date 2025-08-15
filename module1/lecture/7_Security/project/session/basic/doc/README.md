# Super Simple Session Demo

The most basic session example possible. Perfect for absolute beginners.

## Files (only 5!)

- `index.php` - Start here
- `login.php` - Login form  
- `welcome.php` - Protected page
- `logout.php` - Destroy session
- `check.php` - See session data

## How to run

```bash
cd session_simpler
php -S localhost:8000
```

## Login

Username: `john`  
Password: `secret`

## Core concepts

1. **session_start()** - Must be first line
2. **$_SESSION['key'] = value** - Store data
3. **if ($_SESSION['logged_in'])** - Check data
4. **session_destroy()** - End session

## Learning path

1. Open `index.php`
2. Click "Login" 
3. Use john/secret
4. Visit "Welcome Page" - it knows you!
5. Check "Session Data" - see what's stored
6. "Logout" - destroys session
7. Try "Welcome Page" again - should redirect to login

## The magic

After login, `welcome.php` shows your username because PHP stored it in `$_SESSION['username']` and remembers it!

## Next steps

Once students understand this, add features:
- More users
- User ID storage  
- Session timeout
- Better styling
- More protected pages

**This is the foundation. Build up from here!**
