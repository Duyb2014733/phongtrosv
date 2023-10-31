<?php
require_once __DIR__ . '/../bootstrap.php';

session_start();

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lấy user dựa vào username
    $sql = "SELECT * FROM user WHERE username = :username";

    $statement = $PDO->prepare($sql);
    $statement->execute([':username' => $username]);

    $user = $statement->fetch();
    // Kiểm tra password
    if ($user && password_verify($password, $user['password'])) {

        $sql = "SELECT id_owner FROM owner WHERE id_name = :id_name";

        $statement = $PDO->prepare($sql);
        $statement->execute([':id_name' => $user['id_name']]);

        $owner = $statement->fetch();

        $_SESSION['id_owner'] = $owner['id_owner'];
        $_SESSION['id_name'] = $user['id_name'];
        $_SESSION['username'] = $user['username'];
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Owner') {
            header('Location: index_owner.php');
            exit;
        }
    } else {
        $error = 'Sai thông tin đăng nhập';
    }
}
require_once __DIR__ . '/../partials/header.php';
?>

<!DOCTYPE html>
<html lang=vi>
<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<head>
    <title>Đăng nhập tài khoản</title>
</head>

<body>
    <div class="container">

        <form action="" method="post" class="register-form">
            <h1>Đăng nhập</h1><br>
            <div class="from-group">
                <label for="username">Username :</label>
                <input type="text" class="form-control mr-sm-2" name="username" placeholder="Tên đăng nhập" required>
            </div><br>
            <div class="from-group">
                <label for="password">Password :</label>
                <input type="password" class="form-control mr-sm-2" name="password" placeholder="Mật khẩu" required>
            </div><br>
            <div class="from-group text-center " style="color: #B22222;">
                <?php if (!empty($error)) { ?>
                    <span><?= $error ?></span>
                <?php } ?>
            </div> <br>
            <div class="from-group">
                <input type="submit" class="btn btn-primary" name="login" value="Đăng nhập">
            </div><br>
            <div class="from-group" style="text-align: right;">
                <span class="psw">Forgot <a href="#">password?</a></span>
            </div>
        </form>

        </form>
    </div>
</body>

</html>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>