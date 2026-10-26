<link rel="stylesheet" href="/cosulta_practical/assets/style.css">
<?php require_once __DIR__ . '/../config.php'; ?>
<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($title ?? 'COSULTA') ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <header class="top"><a class="brand" href="index.php">COSULTA<span>+</span></a>
        <nav><a href="index.php">الرئيسية</a><?php if (user()): ?><a href="dashboard.php">لوحة التحكم</a><span class="hello">مرحباً، <?= h(user()['full_name']) ?></span><a href="logout.php">خروج</a><?php else: ?><a href="login.php">دخول</a><a class="navbtn" href="register.php">إنشاء حساب</a><?php endif; ?></nav>
    </header>
    <main class="container"><?php show_flash(); ?>