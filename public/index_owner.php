<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();
if (!isset($_SESSION['id_owner'])) {
    header('Location: Dangnhap.php');
}

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
            <?php require_once __DIR__ . "/../partials/navbar_fixed_owner.php" ?>
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
                                <?php foreach ($posts as $post) { ?>
                                    <div class="col-sm-4">
                                        <div class="card mb-3">
                                            <img src="<?php echo $post['image']; ?>" class="card-img-top" alt="Image">
                                            <hr>
                                            <div class="card-body d-flex flex-column">
                                                <h2 class="card-title"><?php echo $post['title']; ?></h2>
                                                <hr>
                                                <p class="card-text"><?php echo $post['content']; ?></p>
                                                <p class="card-text">Giá phòng: <?php echo $post['price_room']; ?>đ</p>
                                                <p class="card-text">Khu vực: <?php echo $post['area_room']; ?></p>
                                                <a href="room_detail.php?id_room=<?php echo $post['id_room']; ?>" class="card-link">Xem chi tiết</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                    <br>
                    <hr><br>
                    <?php require_once __DIR__ . '/../partials/footer.php'; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>