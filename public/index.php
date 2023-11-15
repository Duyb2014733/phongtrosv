<?php
require_once __DIR__ . '/../bootstrap.php';

use website\src\Pagination;

session_start();
$sql = "SELECT p.title, p.content, p.image, r.id_room, r.price_room, r.area_room, o.name_owner, o.phone_owner, o.email_owner, o.address_owner
        FROM post p
        JOIN room r ON p.id_room = r.id_room
        JOIN owner o ON r.id_owner = o.id_owner
        ORDER BY p.created_at DESC";

$statement = $PDO->prepare($sql);
$statement->execute();

$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

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
                    <hr>
                    <div>
                        <h1 style="text-align: center;">Các Bài Đăng</h1>
                        <hr><br>
                        <div class="container-fluid">
                            <div class="row card_index">
                                <?php
                                foreach ($posts as $post) {
                                    echo '<div class="col-sm-4">';
                                    echo '<div class="card mb-3">';
                                    echo '<img src="' . $post['image'] . '" class="card-img-top" alt="Image"><hr>';
                                    echo '<div class="card-body d-flex flex-column">';
                                    echo '<h2 class="card-title">' . $post['title'] . '</h2><hr>';
                                    echo '<p class="card-text">' . $post['content'] . '</p>';
                                    echo '<p class="card-text">Giá phòng: ' . $post['price_room'] . 'đ</p>';
                                    echo '<p class="card-text">Khu vực: ' . $post['area_room'] . '</p>';
                                    echo '<a href="room_detail.php?id_room=' . $post['id_room'] . '" class="card-link">Chi tiết</a>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                                ?>
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