<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();
$sql = "SELECT title, content, image 
        FROM post
        ORDER BY created_at DESC";

$statement = $PDO->prepare($sql);
$statement->execute();

$posts = $statement->fetchAll(PDO::FETCH_ASSOC);


require_once __DIR__ . '/../partials/header.php';
?>
<!DOCTYPE html>
<html eng=vi>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . '/../partials/sidebar.php'; ?>
            </div>
            <div class="col-sm-10">
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
                    <div class="col-sm-4">
                        <?php
                        // Vòng lặp để hiển thị các bài đăng
                        foreach ($posts as $post) {

                            echo '<div class="post">';
                            echo '<img src="' . $post['image'] . '" >';
                            echo '<h2>' . $post['title'] . '</h2>';
                            echo '<p>' . $post['content'] . '</p>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
                <?php require_once __DIR__ . '/../partials/footer.php'; ?>
            </div>
        </div>

    </div>
</body>

</html>