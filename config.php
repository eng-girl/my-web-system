<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "cosulta"; // Change this to your actual database name in phpMyAdmin

// Create connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
  die("Database connection failed: " . mysqli_connect_error());
}
?>
<?php
// عدّلي بيانات قاعدة البيانات حسب جهازك
$host = 'localhost';
$db = 'cosulta';
$user = 'root';
$pass = '';
try {
  $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
} catch (PDOException $e) {
  exit('تعذر الاتصال بقاعدة البيانات. تأكدي من تشغيل MySQL وإنشاء قاعدة cosulta ثم استيراد database.sql.');
}
if (session_status() === PHP_SESSION_NONE) session_start();
function h($v)
{
  return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
function user()
{
  return $_SESSION['user'] ?? null;
}
function require_login()
{
  if (!user()) {
    header('Location: login.php');
    exit;
  }
}
function require_role($role)
{
  require_login();
  if (user()['role'] !== $role) {
    http_response_code(403);
    exit('غير مسموح لك بالدخول لهذه الصفحة.');
  }
}
function go($url)
{
  header("Location: $url");
  exit;
}
function flash($msg)
{
  $_SESSION['flash'] = $msg;
}
function show_flash()
{
  if (!empty($_SESSION['flash'])) {
    echo '<div class="notice">' . h($_SESSION['flash']) . '</div>';
    unset($_SESSION['flash']);
  }
}
?>
