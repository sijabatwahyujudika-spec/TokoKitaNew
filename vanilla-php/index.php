<?php
// ==========================================
// MAIN APPLICATION ENTRY POINT
// ==========================================
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/functions.php';

startSession();

// Get the requested page
$page = getCurrentPage();

// Parse URL and query string
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/vanilla-php', '', $uri);
$uri = rtrim($uri, '/') ?: '/';

// Handle routing
switch ($uri) {
    // ==========================================
    // PUBLIC ROUTES
    // ==========================================
    case '/':
        require_once __DIR__ . '/pages/home.php';
        break;

    case '/produk':
        require_once __DIR__ . '/pages/produk/list.php';
        break;

    case preg_match('/^\/produk\/(\d+)$/', $uri, $matches) ? true : false:
        $_GET['id'] = $matches[1];
        require_once __DIR__ . '/pages/produk/detail.php';
        break;

    // ==========================================
    // AUTH ROUTES
    // ==========================================
    case '/login':
        if (isLoggedIn()) {
            redirect('/vanilla-php/produk');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/actions/login.php';
        } else {
            require_once __DIR__ . '/pages/auth/login.php';
        }
        break;

    case '/logout':
        logout();
        redirectWithMessage('/vanilla-php/', 'success', 'Anda telah berhasil logout.');
        break;

    // ==========================================
    // PROTECTED ROUTES (REQUIRE LOGIN)
    // ==========================================
    case '/pesanan':
        if (!isLoggedIn()) {
            redirect('/vanilla-php/login');
        }
        require_once __DIR__ . '/pages/pesanan/list.php';
        break;

    case '/pesanan/create':
        if (!isLoggedIn()) {
            redirect('/vanilla-php/login');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/actions/pesanan_create.php';
        } else {
            require_once __DIR__ . '/pages/pesanan/create.php';
        }
        break;

    case '/pesanan/detail':
        if (!isLoggedIn()) {
            redirect('/vanilla-php/login');
        }
        require_once __DIR__ . '/pages/pesanan/detail.php';
        break;

    // ==========================================
    // ADMIN ROUTES (REQUIRE ADMIN ROLE)
    // ==========================================
    case '/admin/produk':
        if (!isLoggedIn() || !isAdmin()) {
            redirect('/vanilla-php/');
        }
        require_once __DIR__ . '/pages/admin/produk/list.php';
        break;

    case '/admin/produk/create':
        if (!isLoggedIn() || !isAdmin()) {
            redirect('/vanilla-php/');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/actions/produk_create.php';
        } else {
            require_once __DIR__ . '/pages/admin/produk/create.php';
        }
        break;

    case preg_match('/^\/admin\/produk\/(\d+)\/edit$/', $uri, $matches) ? true : false:
        if (!isLoggedIn() || !isAdmin()) {
            redirect('/vanilla-php/');
        }
        $_GET['id'] = $matches[1];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/actions/produk_update.php';
        } else {
            require_once __DIR__ . '/pages/admin/produk/edit.php';
        }
        break;

    case preg_match('/^\/admin\/produk\/(\d+)\/delete$/', $uri, $matches) ? true : false:
        if (!isLoggedIn() || !isAdmin()) {
            redirect('/vanilla-php/');
        }
        $_GET['id'] = $matches[1];
        require_once __DIR__ . '/actions/produk_delete.php';
        break;

    case '/admin/pesanan':
        if (!isLoggedIn() || !isAdmin()) {
            redirect('/vanilla-php/');
        }
        require_once __DIR__ . '/pages/admin/pesanan/list.php';
        break;

    case preg_match('/^\/admin\/pesanan\/(\d+)$/', $uri, $matches) ? true : false:
        if (!isLoggedIn() || !isAdmin()) {
            redirect('/vanilla-php/');
        }
        $_GET['id'] = $matches[1];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/actions/pesanan_update_status.php';
        } else {
            require_once __DIR__ . '/pages/admin/pesanan/detail.php';
        }
        break;

    // ==========================================
    // 404 PAGE
    // ==========================================
    default:
        http_response_code(404);
        require_once __DIR__ . '/pages/404.php';
        break;
}
?>
