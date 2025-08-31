<?php
// --- Development toggles (on for class demos; off in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

/** Core JSON responder (status + header + body, then exit) */
function sendJson(array $payload, int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

function sendResponse($data, string $message = 'Success', int $code = 200): void {
    $count = is_countable($data) ? count($data) : 1;
    sendJson([
        'success' => true,
        'message' => $message,
        'data'    => $data,
        'count'   => $count,
    ], $code);
}

function sendError(string $message, int $code = 400, array $extra = []): void {
    sendJson([
        'success' => false,
        'message' => $message,
        'data'    => null,
        ...$extra,
    ], $code);
}

/** Method guard: POST only */
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($method !== 'POST') {
    header('Allow: POST');
    sendError('Only POST requests are allowed in this simple API', 405);
}

/** Content negotiation & body parsing */
$contentType = $_SERVER['CONTENT_TYPE'] ?? $_SERVER['HTTP_CONTENT_TYPE'] ?? '';
if (strpos($contentType, ';') !== false) {
    $contentType = strtolower(trim(strtok($contentType, ';'))); // strip boundary/charset
} else {
    $contentType = strtolower(trim($contentType));
}

$name = '';
$email = '';

switch ($contentType) {
    case 'application/json': {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            sendError('Invalid JSON body', 400, ['json_error' => json_last_error_msg()]);
        }
        $name  = $data['name']  ?? '';
        $email = $data['email'] ?? '';
        break;
    }

    // Treat classic HTML form posts (and file forms) the same
    case 'application/x-www-form-urlencoded':
    case 'multipart/form-data':
    case '': // some clients omit Content-Type; try $_POST
        $name  = $_POST['name']  ?? '';
        $email = $_POST['email'] ?? '';
        break;

    default:
        sendError('Unsupported Content-Type: ' . $contentType, 415, [
            'supported' => [
                'application/json',
                'application/x-www-form-urlencoded',
                'multipart/form-data'
            ]
        ]);
}

/** Minimal validation (for the demo) */
if ($name === '' || $email === '') {
    sendError('Both "name" and "email" are required.', 422, [
        'received' => ['name' => $name, 'email' => $email]
    ]);
}

/** Build response payload */
$info = [
    'name'  => $name,
    'email' => $email,
    // In a real app, you might also inspect $_FILES for uploads.
];

sendResponse($info, 'Response from POST request');
?>