<?php
require_once __DIR__ . '/../bootstrap.php';

use website\src\User;

ob_start();
session_start();
// Xử lý đăng ký tài khoản
if (isset($_POST['register']) && ($_POST['register'])) {
    $user = new User($PDO);
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $add = $user->addUser($username, $password, $role);

    // Sau khi INSERT dữ liệu đăng ký thành công
    if (is_string($add)) {
        $error = $add;
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

<head>
    <title>Đăng ký tài khoản</title>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php" ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
                    <form method="post">
                        <h1>Đăng ký</h1>
                        <hr>
                        <?php if (isset($success)) { ?>
                            <div class="alert alert-success"><?= $success ?></div>
                        <?php } ?>
                        <?php if (isset($error)) { ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php } ?>
                        <div class="mb-3 mt-3">
                            <label for="username">Tên đăng ký :</label>
                            <input type="text" id="username" class="form-control" name="username" placeholder="Tên đăng ký" required>
                        </div>
                        <div class="mb-3">
                            <label for="password">Mật khẩu :</label>
                            <input type="password" id="password" class="form-control" name="password" placeholder="Mật khẩu" required>
                        </div>
                        <div class="mb-3">
                            <label for="role">Vai trò :</label>
                            <select name="role" id="role">
                                <option value="Owner">Chủ trọ</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <input type="submit" class="btn btn-primary" name="register" value="Đăng ký">
                    </form>
                </div>
                <br>
                <hr><br>
                <?php require_once __DIR__ . '/../partials/footer.php'; ?><br>
            </div>
        </div>

    </div>
</body>

</html>