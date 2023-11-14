<?php
require_once __DIR__ . '/../bootstrap.php';

use website\labs\User;
use website\labs\Owner;
use website\labs\Post;
use website\labs\Room;
use website\labs\Rental;

session_start();

if (!isset($_SESSION['id_name']) || $_SESSION['role'] !== 'Admin') {
    header('Location: login.php');
    exit();
}

$user = new User($PDO);
$owner = new Owner($PDO);
$post = new Post($PDO);
$room = new Room($PDO);
$rental = new Rental($PDO);

// Đây là trang quản trị, bạn có thể thêm các chức năng quản trị tại đây.

require_once __DIR__ . '/../partials/header.php';
?>

<!DOCTYPE html>
<html lang="vi">
<?php //require_once __DIR__ . '/../partials/navbar_admin.php'; ?>

<head>
    <title>Trang quản trị</title>
</head>

<body>
    <div class="container">
        <h2>Trang quản trị</h2>
        <!-- Đây là nơi để bạn thêm các chức năng quản trị, ví dụ: -->
        <div class="row">
            <div class="col">
                <h3>Quản lý Users</h3>
                <!-- Thêm các chức năng quản lý Users tại đây -->
            </div>
            <div class="col">
                <h3>Quản lý Customers</h3>
                <!-- Thêm các chức năng quản lý Customers tại đây -->
            </div>
            <div class="col">
                <h3>Quản lý Owners</h3>
                <!-- Thêm các chức năng quản lý Owners tại đây -->
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h3>Quản lý Bài đăng</h3>
                <!-- Thêm các chức năng quản lý Bài đăng tại đây -->
            </div>
            <div class="col">
                <h3>Quản lý Phòng</h3>
                <!-- Thêm các chức năng quản lý Phòng tại đây -->
            </div>
            <div class="col">
                <h3>Quản lý Thuê phòng</h3>
                <!-- Thêm các chức năng quản lý Thuê phòng tại đây -->
            </div>
        </div>
    </div>
</body>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>

</html>
