<?php
// Validate CSRF
if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
    redirectWithMessage('/vanilla-php/login', 'error', 'Permintaan tidak valid.');
}

// Validate input
$errors = validate($_POST, [
    'email' => 'required|email',
    'password' => 'required',
]);

if (!empty($errors)) {
    $title = 'Login';
    include __DIR__ . '/../pages/layouts/header.php';
    include __DIR__ . '/../pages/auth/login.php';
    include __DIR__ . '/../pages/layouts/footer.php';
    exit();
}

// Attempt login
if (login($_POST['email'], $_POST['password'])) {
    redirectWithMessage('/vanilla-php/produk', 'success', 'Selamat Datang! Anda berhasil login.');
} else {
    $errors['email'] = 'Email atau password yang Anda masukkan salah.';
    $title = 'Login';
    include __DIR__ . '/../pages/layouts/header.php';
    include __DIR__ . '/../pages/auth/login.php';
    include __DIR__ . '/../pages/layouts/footer.php';
    exit();
}
?>
