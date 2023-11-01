<?php
require_once __DIR__ . '/../bootstrap.php';
ob_start();
session_start();
// Xử lý đăng ký tài khoản
if (isset($_POST['register'])) {
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Kiểm tra username đã tồn tại chưa
    $sql = "SELECT * FROM user WHERE username = :username";
    $statement = $PDO->prepare($sql);
    $statement->execute([':username' => $username]);

    if ($statement->rowCount() > 0) {
        $error = "Username đã tồn tại!";
        $msg = $error;
    } else {
        // Mã hóa mật khẩu
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Thêm tài khoản mới vào bảng users
        $sql = "INSERT INTO user(username, password, role) VALUES(:username, :password, :role);";

        $statement = $PDO->prepare($sql);

        $statement->execute([
            ':username' => $username,
            ':password' => $password_hash,
            ':role' => $role
        ]);
        // Sau khi INSERT dữ liệu đăng ký thành công
        if ($statement->rowCount() > 0) {

            $id_name = $PDO->lastInsertId('id_name');
            // Nếu là chủ trọ
            if ($role == 'Owner') {

                // Lưu session
                $_SESSION['id_name'] = $id_name;
                $_SESSION['role'] = 'Owner';

                // Chuyển hướng
                header('Location: info_owner.php');
                exit();
            } else {
                // Ngược lại là user thường
                $success = "Đăng ký thành công!";
                $msg = $success;
            }
        }

        //$success = "Đăng ký thành công!";
        
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

