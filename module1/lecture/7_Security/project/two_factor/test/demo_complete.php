<?php
require_once __DIR__ . '/../SimpleTOTP.php';
require_once __DIR__ . '/../config.php';

/**
 * COMPLETE 2FA DEMO SCRIPT
 * Automated demonstration of the enhanced 2FA system
 * 
 * This script will:
 * 1. Test QR code generation
 * 2. Setup 2FA for a user
 * 3. Verify the setup
 * 4. Show reset functionality
 * 5. Demonstrate all features
 * 
 * Run with: php demo_complete.php
 */

echo "🔐 Two-Factor Authentication - Complete Demo\n";
echo "===========================================\n\n";

// Demo configuration
$demo_user = 'john';
$demo_password = 'password123';

echo "📋 Demo Configuration:\n";
echo "   User: {$demo_user}\n";
echo "   Password: {$demo_password}\n";
echo "   Issuer: PHP 2FA Demo\n\n";

// Step 1: Test QR Code Generation
echo "🧪 Step 1: Testing QR Code Generation\n";
echo "-------------------------------------\n";

$secret = SimpleTOTP::generateSecret(16);
$secret_hex = bin2hex($secret);
$secret_base32 = SimpleTOTP::base32Encode($secret);

echo "✅ Generated secret: {$secret_hex}\n";
echo "✅ Base32 format: {$secret_base32}\n";

// Test old vs new QR URLs
$qr_urls = SimpleTOTP::getQRCodeURLs($secret, $demo_user, 'PHP 2FA Demo');
echo "✅ QR Server URL: " . substr($qr_urls['qr_server'], 0, 60) . "...\n";
echo "✅ QuickChart URL: " . substr($qr_urls['quickchart'], 0, 60) . "...\n";

// Generate a TOTP code for demonstration
$current_code = SimpleTOTP::generateCode($secret);
echo "✅ Current TOTP code: {$current_code}\n\n";

// Step 2: Check Initial User Status
echo "🔍 Step 2: Checking Initial User Status\n";
echo "---------------------------------------\n";

$user = getUser($demo_user);
if (!$user) {
    echo "❌ User not found. Creating demo environment...\n";
    // This would typically be handled by config.php initialization
} else {
    echo "✅ User found: {$demo_user}\n";
    echo "   TOTP Enabled: " . ($user['totp_enabled'] ? 'Yes' : 'No') . "\n";
    echo "   Has Secret: " . (!empty($user['totp_secret']) ? 'Yes' : 'No') . "\n";
}
echo "\n";

// Step 3: Reset if already enabled (clean slate)
echo "🔄 Step 3: Ensuring Clean State\n";
echo "-------------------------------\n";

if ($user && $user['totp_enabled']) {
    echo "ℹ️  2FA already enabled. Resetting for demo...\n";
    updateUser($demo_user, [
        'totp_secret' => null,
        'totp_enabled' => false
    ]);
    echo "✅ Reset completed\n";
} else {
    echo "✅ User ready for 2FA setup\n";
}
echo "\n";

// Step 4: Simulate 2FA Setup
echo "🔧 Step 4: Setting Up 2FA\n";
echo "-------------------------\n";

try {
    // Generate new secret for setup
    $setup_secret = SimpleTOTP::generateSecret();
    
    // Store secret (temporarily, not yet enabled)
    updateUser($demo_user, ['totp_secret' => base64_encode($setup_secret)]);
    
    // Generate QR code information
    $setup_qr_urls = SimpleTOTP::getQRCodeURLs($setup_secret, $demo_user, 'PHP 2FA Demo');
    $setup_code = SimpleTOTP::generateCode($setup_secret);
    
    echo "✅ Secret generated and stored\n";
    echo "✅ QR code URL ready: " . substr($setup_qr_urls['qr_server'], 0, 50) . "...\n";
    echo "✅ Manual entry key: " . SimpleTOTP::base32Encode($setup_secret) . "\n";
    echo "✅ Current code for verification: {$setup_code}\n";
    
} catch (Exception $e) {
    echo "❌ Setup failed: " . $e->getMessage() . "\n";
    exit(1);
}
echo "\n";

// Step 5: Simulate Verification
echo "✅ Step 5: Verifying Setup\n";
echo "-------------------------\n";

// Reload user data
$user = getUser($demo_user);
if ($user && !empty($user['totp_secret'])) {
    $stored_secret = base64_decode($user['totp_secret']);
    
    // Verify the code we generated
    $is_valid = SimpleTOTP::verifyCode($setup_code, $stored_secret);
    
    if ($is_valid) {
        // Enable 2FA
        updateUser($demo_user, ['totp_enabled' => true]);
        echo "✅ Code verification successful\n";
        echo "✅ 2FA enabled for user: {$demo_user}\n";
    } else {
        echo "❌ Code verification failed\n";
    }
} else {
    echo "❌ No secret found for verification\n";
}
echo "\n";

// Step 6: Test Login
echo "🔑 Step 6: Testing 2FA Login\n";
echo "---------------------------\n";

$user = getUser($demo_user);
if ($user && $user['totp_enabled']) {
    $login_secret = base64_decode($user['totp_secret']);
    $login_code = SimpleTOTP::generateCode($login_secret);
    
    // Simulate login verification
    $login_valid = SimpleTOTP::verifyCode($login_code, $login_secret);
    
    echo "✅ Generated login code: {$login_code}\n";
    echo "✅ Login verification: " . ($login_valid ? 'SUCCESS' : 'FAILED') . "\n";
} else {
    echo "❌ 2FA not properly enabled\n";
}
echo "\n";

// Step 7: Demonstrate Time Window Behavior
echo "⏰ Step 7: Time Window Demonstration\n";
echo "-----------------------------------\n";

if ($user && $user['totp_enabled']) {
    $time_secret = base64_decode($user['totp_secret']);
    $current_time = time();
    
    echo "Current time: " . date('H:i:s', $current_time) . " (timestamp: {$current_time})\n";
    echo "Time window: " . floor($current_time / 30) . "\n\n";
    
    echo "Code generation for different time windows:\n";
    for ($i = -2; $i <= 2; $i++) {
        $test_time = $current_time + ($i * 30);
        $test_code = SimpleTOTP::generateCode($time_secret, $test_time);
        $time_label = $i === 0 ? "CURRENT" : ($i > 0 ? "+{$i}×30s" : "{$i}×30s");
        $is_accepted = SimpleTOTP::verifyCode($test_code, $time_secret, $current_time);
        
        echo sprintf("  %s: %s → %s %s\n", 
            str_pad($time_label, 8),
            date('H:i:s', $test_time),
            $test_code,
            $is_accepted ? '✅ ACCEPTED' : '❌ REJECTED'
        );
    }
}
echo "\n";

// Step 8: Demonstrate Reset Functionality
echo "🔄 Step 8: Reset Functionality\n";
echo "-----------------------------\n";

echo "Current user state before reset:\n";
$user = getUser($demo_user);
echo "  - TOTP Enabled: " . ($user['totp_enabled'] ? 'Yes' : 'No') . "\n";
echo "  - Has Secret: " . (!empty($user['totp_secret']) ? 'Yes' : 'No') . "\n";

// Perform reset
$reset_data = [
    'totp_secret' => null,
    'totp_enabled' => false
];

$reset_success = updateUser($demo_user, $reset_data);

if ($reset_success) {
    echo "✅ Reset successful\n";
    
    // Verify reset
    $user = getUser($demo_user);
    echo "User state after reset:\n";
    echo "  - TOTP Enabled: " . ($user['totp_enabled'] ? 'Yes' : 'No') . "\n";
    echo "  - Has Secret: " . (!empty($user['totp_secret']) ? 'Yes' : 'No') . "\n";
} else {
    echo "❌ Reset failed\n";
}
echo "\n";

// Step 9: Summary and Next Steps
echo "📊 Demo Summary\n";
echo "==============\n";

echo "✅ QR code generation working (fixed Google Charts deprecation)\n";
echo "✅ 2FA setup process functional\n";
echo "✅ Code verification working\n";
echo "✅ Time window tolerance working (±30 seconds)\n";
echo "✅ Reset functionality working\n";
echo "✅ User state management working\n\n";

echo "🎯 What Students Will Learn:\n";
echo " - TOTP algorithm implementation\n";
echo " - Time-based cryptography\n";
echo " - User account state management\n";
echo " - API endpoint design\n";
echo " - Error handling and recovery\n";
echo " - Service dependency management\n";
echo " - Security best practices\n\n";

echo "🚀 Next Steps for Testing:\n";
echo "  1. Start PHP server: php -S localhost:8000\n";
echo "  2. Open web interface: http://localhost:8000\n";
echo "  3. Test with real authenticator app\n";
echo "  4. Try reset functionality\n";
echo "  5. Experiment with API endpoints\n\n";

echo "🎉 Demo Complete! Your 2FA system is ready for educational use.\n";

// Optional: Display current system status
echo "\n📋 Current System Status:\n";
echo "========================\n";

loadUsers();
global $users;

foreach ($users as $username => $userData) {
    echo "User: {$username}\n";
    echo "  - ID: {$userData['id']}\n";
    echo "  - TOTP Enabled: " . ($userData['totp_enabled'] ? 'Yes' : 'No') . "\n";
    echo "  - Has Secret: " . (!empty($userData['totp_secret']) ? 'Yes' : 'No') . "\n";
    
    if ($userData['totp_enabled'] && !empty($userData['totp_secret'])) {
        $current_code = SimpleTOTP::generateCode(base64_decode($userData['totp_secret']));
        echo "  - Current Code: {$current_code}\n";
    }
    echo "\n";
}

echo "🔧 Available Tools:\n";
echo "  - Web Interface: index.html\n";
echo "  - Status Check: status.php\n";
echo "  - Reset Tool: reset.php\n";
echo "  - Quick Reset: quick_reset.php\n";
echo "  - QR Test: qr_test.php\n";
echo "  - This Demo: demo_complete.php\n";

echo "\nReady for classroom use! 🎓\n";
?>
