<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();
if (!isset($_SESSION['id_owner'])) {
    header('Location: Dangnhap.php');
}

$sql = "SELECT title, content, image 
        FROM post
        ORDER BY created_at DESC";

$statement = $PDO->prepare($sql);
$statement->execute();

$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../partials/header.php';
?>
<head>
    <title>
        Trang chủ 
    </title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once __DIR__ . "/../partials/navbar_fixed_owner.php" ?>
            <div class="col-sm-10 main">
                <div >
                    <div id="demo" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/img/1.jpg" alt="1" class="d-block" style="width:100%">
                            </div>
                            <div class="carousel-item">
                                <img src="/img/2.jpg" alt="2" class="d-block" style="width:100%">
                            </div>
                            <div class="carousel-item">
                                <img src="/img/3.jpg" alt="3" class="d-block" style="width:100%">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                    <div>
                        <h1 style="text-align: center;">Các Bài Đăng</h1>
                        <div class="col-md-8 offset-md-2">
                            <?php
                            // Vòng lặp để hiển thị các bài đăng
                            foreach ($posts as $post) {

                                echo '<div class="post card mb-3"">';
                                echo '<img src="' . $post['image'] . '" class="card-img-top" alt="Image" >';
                                echo '<div class="card-body">';
                                echo '<h2 class="card-title">' . $post['title'] . '</h2>';
                                echo '<p class="card-text">' . $post['content'] . '</p>';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                    <hr class="text-white">
                    <?php require_once __DIR__ . '/../partials/footer.php'; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>