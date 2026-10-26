<?php
require_once 'config.php';

// توليد تشفير صحيح وصالح بنسبة 100% لكلمة المرور Demo123!
$new_hash = password_hash('Demo123!', PASSWORD_DEFAULT);

// تحديث كلمة المرور لحساب المدير
$sql = "UPDATE users SET password_hash = '$new_hash' WHERE email = 'admin@cosulta.test'";

if (mysqli_query($conn, $sql)) {
    echo "تم تحديث كلمة المرور بنجاح! يمكنك الآن تسجيل الدخول بـ:<br>";
    echo "البريد: admin@cosulta.test<br>";
    echo "كلمة المرور: Demo123!<br>";
    echo "<br><a href='login.php'>الذهاب لصفحة تسجيل الدخول</a>";
} else {
    echo "حدث خطأ أثناء التحديث: " . mysqli_error($conn);
}
