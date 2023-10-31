<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();
// Xử lý khi submit form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    function uploadImage($image)
    {
        if (!isset($image) && !is_array($image)) {
            return false;
        }
        // Thư mục lưu file
        $target_dir = "/img";

        // Tên file mới 
        $target_file = $target_dir . time() . "-" . basename($image["name"]);

        // Kiểm tra kích thước và định dạng file
        $allowed = array('jpg', 'jpeg', 'png');
        $ext = pathinfo($target_file, PATHINFO_EXTENSION);
        if ($image['size'] > 1000000 || !in_array($ext, $allowed)) {
            return false;
        }

        // Thực hiện upload 
        if (move_uploaded_file($image['tmp_name'], $target_file)) {
            return $target_file; // Trả về đường dẫn file đã lưu
        }

        return false;
    }

    // Kiểm tra biến $_POST
    if (!isset($_POST) || !is_array($_POST)) {
        return false;
    }

    // Lấy dữ liệu
    $title = $_POST['title'];
    $content = $_POST['content'];
    $status_post = $_POST['status_post'];
    $id_owner = $_SESSION['id_owner']; // lấy từ phiên đăng nhập
    $image_post = $_FILES['image_post'];
    $imagePath = uploadImage($image_post);


    // Insert vào bảng post
    $sql = "INSERT INTO post(title, content, image_post, created_at, update_at, status_post, id_owner) 
           VALUES(:title, :content, :image_post, now(), now(), :status_post, :id_owner)";

    $statement = $PDO->prepare($sql);
    $statement->execute([
        ':title' => $title,
        ':content' => $content,
        ':image_post' => $imagePath,
        ':status_post' => $status_post,
        ':id_owner' => $id_owner
    ]);
    echo "Đăng bài thành công!";
}

require_once __DIR__ . '/../partials/header.php';
?>

<!DOCTYPE html>
<html lang="vi">
<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<head>
    <title>Bài đăng</title>
</head>

<body>
    <div class="container text-center">
        <div class="row">
            <div class="col">
                <form method="post" enctype="multipart/form-data" class="register-form">

                    <input type="text" name="title" placeholder="Tiêu đề bài viết">

                    <textarea name="content" placeholder="Nội dung bài viết"></textarea>

                    <input type="file" name="image_post">

                    <select name="status_post">
                        <option value="draft">Bản nháp</option>
                        <option value="published">Công khai</option>
                    </select>

                    <button type="submit" name="submit">Đăng bài</button>

                </form>
            </div>
        </div>
    </div>

</body>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>

</html>