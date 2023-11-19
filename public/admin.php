<?php
require_once __DIR__ . '/../bootstrap.php';

use phongtrosv\src\User;
use phongtrosv\src\Owner;
use phongtrosv\src\Post;
use phongtrosv\src\Room;
use phongtrosv\src\Rental;
use phongtrosv\src\Pagination;
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: Dangnhap.php');
    exit();
}

$user = new User($PDO);
$owner = new Owner($PDO);
$post = new Post($PDO);
$room = new Room($PDO);
$rental = new Rental($PDO);
$users = $user->getAllUsers();
// Đây là trang quản trị, bạn có thể thêm các chức năng quản trị tại đây.

require_once __DIR__ . '/../partials/header.php';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Trang quản trị</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php" ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
                    <h2>Danh Sách Tài Khoản</h2>
                    <hr>
                    <a href="/Dangky_admin.php" class="btn btn-primary btn-lg" role="button">Đăng ký tài khoản</a>
                    <hr>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Vai trò</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['id_name']); ?></td>
                                    <td><?= htmlspecialchars($user['username']); ?></td>
                                    <td><?= htmlspecialchars($user['role']); ?></td>
                                    <td>
                                        <a href="editUser.php?id=<?= htmlspecialchars($user['id_name']); ?> " class="btn btn-primary" role="button">Edit</a>
                                        <a onclick="return confirm('Bạn có muốn xóa bài đăng này không!')" href="deleteUser.php?id=<?= htmlspecialchars($user['id_name']); ?>" class="btn btn-danger" role="button">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <?php
                        // Sử dụng lớp Pagination
                        $totalItems = 10;
                        $itemsPerPage = 3;
                        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                        $baseUrl = 'index.php';
                        $queryParameters = array('category' => 'news');
                        
                        $pagination = new Pagination($totalItems, $itemsPerPage, $currentPage, $baseUrl, $queryParameters);
                        echo $pagination->generatePaginationHtml();
                        ?>
                    </div>
                </div>
                <hr><br>
                <?php require_once __DIR__ . '/../partials/footer.php'; ?>
            </div>
            <br>
        </div>
    </div>


    </div>
</body>

</html>