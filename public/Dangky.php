<?php
require_once __DIR__ . '/../bootstrap.php';

use website\labs\User;

ob_start();
session_start();
// Xử lý đăng ký tài khoản
if (isset($_POST['register']) && ($_POST['register'])) {
    $user = new User($PDO);
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $add = $user ->addUser($username, $password, $role);

    // Sau khi INSERT dữ liệu đăng ký thành công
    if ($add > 0) {

        $id_name = $PDO->lastInsertId('id_name');
        // Nếu là chủ trọ
        if ($role == 'Owner') {
            // Lưu session
            $_SESSION['id_name'] = $id_name;
            $_SESSION['role'] = 'Owner';
            // Chuyển hướng
            header('Location: info_owner.php');
            exit();
        }
    }
}


require_once __DIR__ . '/../partials/header.php';
?>

<!DOCTYPE html>
<html lang="vi">
<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<head>
    <title>Đăng ký tài khoản</title>
</head>

<body>

    <div class="container">

        <form action="" method="post" class="register-form">
            <h1>Đăng ký</h1><br>
            <div class="from-group">
                <label for="username">Username :</label>
                <input type="text" class="form-control mr-sm-2" name="username" placeholder="Tên đăng ký" required>
            </div><br><br>
            <div class="from-group">
                <label for="password">Password :</label>
                <input type="password" class="form-control mr-sm-2" name="password" placeholder="Mật khẩu" required>
            </div><br><br>
            <div class="from-group">
                <label for="role">Vai trò :</label>
                <select name="role">
                    <option value="Owner">Chủ trọ</option>
                    <!-- <option value="Admin">Admin</option> -->
                </select>
            </div><br>
            <div class="from-group text-center " style="color: #B22222;">
                <?php if (!empty($msg)) { ?>
                    <span><?= $msg ?></span>
                <?php } ?>
            </div> <br><br>
            <div class="from-group">
                <input type="submit" class="btn btn-primary" name="register" value="Đăng ký">
            </div>
        </form>
    </div>

    </div>

</body>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>

</html>