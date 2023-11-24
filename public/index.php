<?php
require_once __DIR__ . '/../bootstrap.php';

use phongtrosv\src\Pagination;
use phongtrosv\src\Room;
use phongtrosv\src\Post;

session_start();


$post = new Post($PDO);
if (isset($_GET['search_area'])) {
    $search_area = $_GET['search_area'];
    $posts = $post->getsearchareaPosts($search_area);
}else{
    $allposts = $post->getAllPostRooms();
}

$room = new Room($PDO);
$areas = $room->getAllAreaRoms();

require_once __DIR__ . '/../partials/header.php';
?>

<head>
    <title>Trang chủ</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php"; ?>
            </div>
            <div class="col-sm-10 px-3 main">
                <div>
                    <div id="demo" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/img/1.jpg" alt="1" class="d-block w-100">
                            </div>
                            <div class="carousel-item">
                                <img src="/img/2.jpg" alt="2" class="d-block w-100">
                            </div>
                            <div class="carousel-item">
                                <img src="/img/3.jpg" alt="3" class="d-block w-100">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                    <hr>
                    <div>
                        <h1 style="text-align: center;">Các Bài Đăng</h1>
                        <hr>
                        <div>
                            <form method="get" action="index.php">
                                <label for="search_area">Tìm Kiếm theo Khu Vực:</label>
                                <select name="search_area" id="search_area">
                                    <option value="">-- Chọn Khu Vực --</option>
                                    <?php foreach ($areas as $area) : ?>
                                        <option value="<?= htmlspecialchars($area) ?>"><?= htmlspecialchars($area) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit">Tìm Kiếm</button>
                            </form>
                        </div>

                        <hr><br>
                        <div class="container-fluid">
                            <div class="row card_index">
                                <?php if (!empty($posts)) : ?>
                                    <?php
                                    foreach ($posts as $post) {
                                        if ($post['status_room'] != 'Đã thuê') {
                                            echo '<div class="col-sm-4">';
                                            echo '<div class="card mb-3">';
                                            echo '<img src="' .  htmlspecialchars($post['image']) . '" class="card-img-top" alt="Image"><hr>';
                                            echo '<div class="card-body d-flex flex-column">';
                                            echo '<h2 class="card-title">' .  htmlspecialchars($post['title']) . '</h2><hr>';
                                            echo '<p class="card-text">Khu vực: ' . htmlspecialchars($post['area_room']) . '</p>';
                                            echo '<a href="room_detail.php?id_room=' . htmlspecialchars($post['id_room']) . '" class="card-link">Chi tiết</a>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                    } ?>
                                <?php else : ?>
                                    <?php
                                    foreach ($allposts as $allpost) {
                                        if ($allpost['status_room'] != 'Đã thuê') {
                                            echo '<div class="col-sm-4">';
                                            echo '<div class="card mb-3">';
                                            echo '<img src="' .  htmlspecialchars($allpost['image']) . '" class="card-img-top" alt="Image"><hr>';
                                            echo '<div class="card-body d-flex flex-column">';
                                            echo '<h2 class="card-title">' .  htmlspecialchars($allpost['title']) . '</h2><hr>';
                                            echo '<p class="card-text">Khu vực: ' . htmlspecialchars($allpost['area_room']) . '</p>';
                                            echo '<a href="room_detail.php?id_room=' . htmlspecialchars($allpost['id_room']) . '" class="card-link">Chi tiết</a>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                    } ?>
                                <?php endif; ?>
                            </div><br>
                            <hr>
                            <div>
                                <?php
                                // Sử dụng lớp Pagination
                                $totalItems = 10;
                                $itemsPerPage = 3;
                                $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                                $baseUrl = 'index.php';
                                $queryParameters = array('category' => 'news');

                                $pagination = new Pagination($totalItems, $itemsPerPage, $currentPage, $baseUrl, $queryParameters);
                                echo $pagination->generatePaginationHtml();
                                ?>
                            </div>

                        </div>
                    </div>
                    <hr><br>
                    <?php require_once __DIR__ . '/../partials/footer.php'; ?><br>
                </div>
            </div>
        </div>
    </div>
</body>

</html>