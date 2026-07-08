<?php
$title = 'Login';
include __DIR__ . '/../layouts/header.php';
?>

<div style="max-width: 400px; margin: 2rem auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; margin-bottom: 2rem;">Login</h2>

    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo e($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required value="<?php echo e($_POST['email'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-success" style="width: 100%; padding: 0.75rem;">Login</button>
    </form>

    <p style="text-align: center; margin-top: 1.5rem; color: #7f8c8d;">
        Belum punya akun? 
        <a href="/vanilla-php/register" style="color: #3498db; text-decoration: none; font-weight: 500;">Daftar di sini</a>
    </p>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
