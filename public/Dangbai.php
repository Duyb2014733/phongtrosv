<?php
require_once __DIR__ . '/../bootstrap.php';

use website\labs\Post;

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Khởi tạo object
    $post = new Post($PDO);
  
    // Gán giá trị vào các thuộc tính 
    $post->fill($_POST);
  
    // Lưu bài viết
    $post->addPost();
    
    echo "Đăng bài viết thành công!";
  
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
                <form method="post" enctype="multipart/form-data">

                    <input type="text" name="title" placeholder="Tiêu đề bài viết">

                    <textarea name="content" placeholder="Nội dung bài viết"></textarea>

                    <input type="file" name="image">

                    <select name="status">
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