<?php require_once 'config.php';
$title = 'تسجيل الدخول';
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $s = $pdo->prepare("SELECT * FROM users WHERE email=? AND status='active'");
    $s->execute([$email]);
    $u = $s->fetch();
    if ($u && password_verify($password, $u['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => $u['id'], 'full_name' => $u['full_name'], 'email' => $u['email'], 'role' => $u['role']];
        go('dashboard.php');
    }
    $err = 'بيانات الدخول غير صحيحة أو الحساب غير نشط.';
}
require 'includes/header.php'; ?><div class="formbox">
    <h1>تسجيل الدخول</h1><?php if ($err): ?><div class="error"><?= h($err) ?></div><?php endif; ?><form method="post"><label>البريد الإلكتروني</label><input type="email" name="email" required><label>كلمة المرور</label><input type="password" name="password" required>
        <div class="btnrow"><button class="btn">دخول</button><a href="register.php">إنشاء حساب جديد</a></div>
    </form>
    <p class="muted">للتجربة، أنشئي حساباً من صفحة التسجيل.</p>
</div><?php require 'includes/footer.php'; ?>