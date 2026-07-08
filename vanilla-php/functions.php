<?php
// ==========================================
// HELPER FUNCTIONS
// ==========================================

// Session Management
function startSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_name(SESSION_NAME);
        session_start();
    }
}

function isLoggedIn()
{
    startSession();
    return isset($_SESSION['user_id']);
}

function getCurrentUser()
{
    startSession();
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    return $_SESSION;
}

function isAdmin()
{
    startSession();
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function login($email, $password)
{
    $db = Database::getInstance();
    $user = $db->fetch("SELECT * FROM users WHERE email = ?", [$email]);
    
    if ($user && password_verify($password, $user['password'])) {
        startSession();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        return true;
    }
    return false;
}

function logout()
{
    startSession();
    session_destroy();
    $_SESSION = [];
}

// Redirect
function redirect($url)
{
    header("Location: $url");
    exit();
}

function redirectWithMessage($url, $type, $message)
{
    startSession();
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
    redirect($url);
}

// Get Session Message
function getMessage()
{
    startSession();
    if (isset($_SESSION['message'])) {
        $msg = [
            'text' => $_SESSION['message'],
            'type' => $_SESSION['message_type'] ?? 'info'
        ];
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        return $msg;
    }
    return null;
}

// Validation
function validate($data, $rules)
{
    $errors = [];
    
    foreach ($rules as $field => $fieldRules) {
        $value = $data[$field] ?? '';
        
        $ruleList = explode('|', $fieldRules);
        foreach ($ruleList as $rule) {
            if ($rule === 'required' && empty($value)) {
                $errors[$field] = ucfirst($field) . ' harus diisi.';
            } elseif (strpos($rule, 'email') === 0 && !empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = 'Format email tidak valid.';
            } elseif (strpos($rule, 'min:') === 0 && strlen($value) < (int)substr($rule, 4)) {
                $errors[$field] = ucfirst($field) . ' minimal ' . substr($rule, 4) . ' karakter.';
            }
        }
    }
    
    return $errors;
}

// Hash Password
function hashPassword($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

// File Upload
function uploadFile($file, $folder = '')
{
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    
    if ($file['size'] > MAX_UPLOAD_SIZE) {
        return false;
    }
    
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ALLOWED_EXTENSIONS)) {
        return false;
    }
    
    if (!is_dir(UPLOAD_DIR . $folder)) {
        mkdir(UPLOAD_DIR . $folder, 0755, true);
    }
    
    $filename = uniqid() . '.' . $ext;
    $destination = UPLOAD_DIR . $folder . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return UPLOAD_URL . $folder . $filename;
    }
    
    return false;
}

// Format Currency
function formatCurrency($amount)
{
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

// Escape HTML
function e($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

// Get Current Page
function getCurrentPage()
{
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = str_replace('/vanilla-php', '', $path);
    return $path ?: '/';
}

// CSRF Token
function generateCSRFToken()
{
    startSession();
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCSRFToken($token)
{
    startSession();
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Pagination
function paginate($currentPage, $totalItems, $itemsPerPage = 10)
{
    $totalPages = ceil($totalItems / $itemsPerPage);
    $currentPage = max(1, min($currentPage, $totalPages));
    
    return [
        'current' => $currentPage,
        'total' => $totalPages,
        'offset' => ($currentPage - 1) * $itemsPerPage,
        'limit' => $itemsPerPage,
    ];
}
?>
