<?php
require_once __DIR__ . '/../bootstrap.php';
ob_start();
session_start();
// Xử lý nhập thông tin chủ trọ
if (isset($_POST['register'])) {
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'Owner') {
        $nameErr = $emailErr = $phoneErr = $addressErr = "";
    if (empty($_POST["name_owner"])) {
        $nameErr = "Phải nhập tên!";
    }

    if (empty($_POST["phone_owner"])) {
        $phoneErr = "Phải nhập số điện thoại!";
    } else if (!preg_match('/^[0-9]{10,11}$/', $_POST["phone_owner"])) {
        $phoneErr = "Định dạng số điện thoại không hợp lệ!";
    }

    if (empty($_POST["email_owner"])) {
        $emailErr = "Phải nhập email!";
    } else if (!filter_var($_POST['email_owner'], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Định dạng email không hợp lệ!";
    }

    if (empty($_POST["address_owner"])) {
        $addressErr = "Phải nhập địa chỉ!";        
    }

    if (empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($addressErr)) {
        $id_name = $_SESSION['id_name'];
        $name_owner = $_POST['name_owner'];
        $phone_owner = $_POST['phone_owner'];
        $email_owner = $_POST['email_owner'];
        $address_owner = $_POST['address_owner'];
        // Insert vào bảng owner
        $sql = "INSERT INTO owner(name_owner, phone_owner, email_owner, address_owner, id_name)
                VALUES(:name_owner,:phone_owner, :email_owner, :address_owner, :id_name);";
                 
        $statement = $PDO->prepare($sql);
      
        $statement->execute([
          ':name_owner' => $name_owner,
          ':phone_owner' =>  $phone_owner,
          ':email_owner' =>   $email_owner,
          ':address_owner' =>  $address_owner,
          ':id_name' => $id_name
        ]);
        
        $successMsg = "Thêm thông tin thành công!";
        header('Location: index_owner.php');
    }
    }
    
}
require_once __DIR__ . '/../partials/header.php';
?>

<!DOCTYPE html>
<html lang="vi">

<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<head>
    <title>Nhập thông tin chủ trọ</title>
</head>

<body>
    <div class="container">

        <form action="" method="post" class="register-form">
            <h2>Nhập thông tin chủ trọ</h2>
            <div class="form-group">
                Name: <input type="text" name="name_owner" placeholder="Họ và tên chủ trọ">
                <?php if(!empty($nameErr)){ echo "<span>$nameErr</span>"; } ?>
            </div><br><br>
            <div class="form-group">
                Phone: <input type="mumber" name="phone_owner" placeholder="Số điện thoại chủ trọ" >
                <?php if(!empty($phoneErr)){ echo "<span>$phoneErr</span>"; } ?>
            </div><br><br>
            <div class="form-group">
                E-mail: <input type="text" name="email_owner" placeholder="Email chủ trọ" >
                <?php if(!empty($emailErr)){ echo "<span>$emailErr</span>"; } ?>
            </div><br><br>
            <div class="form-group">
                Address: <input type="text" name="address_owner" placeholder="Địa chỉ chủ trọ" >
                <?php if(!empty($emailErr)){ echo "<span>$emailErr</span>"; } ?>
            </div><br><br>
            <button type="submit" class="btn btn-primary" name="register">Submit</button>
        </form>
    </div>
</body>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>
</html>