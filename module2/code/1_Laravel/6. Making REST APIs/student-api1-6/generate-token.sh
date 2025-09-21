#!/bin/bash
echo "Creating test user and generating API token..."

cat > temp_token.php << 'PHPEOF'
<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

$user = User::factory()->create([
    'name' => 'Test User',
    'email' => 'test@example.com'
]);

$token = $user->createToken('api-token')->plainTextToken;
echo $token;
PHPEOF

TOKEN=$(php temp_token.php)
rm temp_token.php

if [ -n "$TOKEN" ]; then
    echo "Token: $TOKEN"
    echo "$TOKEN" > api_token.txt
    echo "Token saved to api_token.txt"
    echo "Test: curl -H \"Authorization: Bearer \$(cat api_token.txt)\" http://localhost:8000/api/goodbye"
else
    echo "Failed to generate token"
fi
