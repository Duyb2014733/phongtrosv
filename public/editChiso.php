<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();

use phongtrosv\src\Chiso;

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: Dangnhap.php');
    exit();
}

$chiso = new Chiso($PDO);

if (!isset($_GET['id_Chiso'])) {
    header('Location: index.php');
    exit();
}

$id_Chiso = $_GET['id_Chiso'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newElec = $_POST['new_elec_Chiso'];
    $newWater = $_POST['new_water_Chiso'];

    if ($chiso->updateChiso($id_Chiso, $newElec, $newWater)) {
        $success = 'Chỉnh sửa thông tin chỉ số thành công!';
    } else {
        $error = 'Lỗi khi chỉnh sửa thông tin chỉ số!';
    }
}

$currentChiso = $chiso->getChisoById($id_Chiso);

require_once __DIR__ . '/../partials/header.php';
?>

<head>
    <title>Chỉnh sửa thông tin chỉ số</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php"; ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
                    <form method="post">
                        <h2>Chỉnh sửa thông tin chỉ số</h2>
                        <?php if (isset($success)) : ?>
                            <div class="alert alert-success"><?= $success ?></div>
                        <?php endif; ?>
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="elec_Chiso">Chỉ số điện hiện tại:</label>
                            <input type="text" class="form-control" value="<?= $currentChiso['elec_Chiso']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="water_Chiso">Chỉ số nước hiện tại:</label>
                            <input type="text" class="form-control" value="<?= $currentChiso['water_Chiso']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="new_elec_Chiso">Chỉ số điện mới:</label>
                            <input type="text" class="form-control" name="new_elec_Chiso" required>
                        </div>
                        <div class="form-group">
                            <label for="new_water_Chiso">Chỉ số nước mới:</label>
                            <input type="text" class="form-control" name="new_water_Chiso" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Chỉnh sửa</button>
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