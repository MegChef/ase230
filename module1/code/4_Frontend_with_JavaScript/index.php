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

function sendError(string $message, int $code = 400): void {
    sendJson([
        'success' => false,
        'message' => $message,
        'data'    => null,
    ], $code);
}

/** Extract path after index.php (works even in subfolders) */
$uri  = $_SERVER['REQUEST_URI'] ?? '/';
$path = trim(parse_url($uri, PHP_URL_PATH) ?? '/', '/');
$ix   = strpos($path, 'index.php');
if ($ix !== false) {
    $path = trim(substr($path, $ix + strlen('index.php')), '/');
}

/** Only GET for this minimal demo */
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($method !== 'GET') {
    header('Allow: GET');
    sendError('Only GET requests are allowed in this simple API', 405);
}

/** Routes */
switch ($path) {
    case 'api':
    case '': // allow / or /api to show info
        $info = [
            'name'        => 'Simple Student Management API',
            'version'     => '1.0',
            'description' => 'A minimal API for learning PHP basics with student data',
            'endpoints'   => [
                'GET /api' => 'Show this API information',
            ],
        ];
        sendResponse($info, 'Welcome to Simple Student Management API');
        break;

    default:
        sendError('Endpoint not found', 404);
}
?>