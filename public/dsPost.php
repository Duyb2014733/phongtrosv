<?php
require_once __DIR__ . '/../bootstrap.php';
use website\src\Post;
use website\src\Pagination;
session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['role'] === 'Owner') {
    $ownerId = $_SESSION['id_owner'];
    $sql = "SELECT p.id_post, p.title, p.content, p.image, r.price_room, r.area_room, p.created_at
            FROM post p
            JOIN room r ON p.id_room = r.id_room
            WHERE r.id_owner = :ownerId
            ORDER BY p.created_at DESC";
    $statement = $PDO->prepare($sql);
    $statement->execute([':ownerId' => $ownerId]);
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
}else {
    // Nếu là admin, hiển thị tất cả bài đăng
    $post = new Post($PDO);
    $posts = $post->getAllPost();
}
require_once __DIR__ . '/../partials/header.php';
?>

<head>
    <title>
        Danh sách bài đăng
    </title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php
                require_once __DIR__ . "/../partials/navbar_fixed.php";
                ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
                    <h2>Danh sách bài đăng</h2>
                    <hr>
                    <a href="/addPost.php" class="btn btn-primary btn-lg" role="button">Thêm</a><hr>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($posts as $post) : ?>
                                <tr>
                                    <td><?= $post['id_post']; ?></td>
                                    <td><?= $post['title']; ?></td>
                                    <td><?= $post['created_at']; ?></td>
                                    <td>
                                        <a href="/editPost.php?id_post=<?= $post['id_post']; ?>" class="btn btn-info" role="button" style="background-color: #FF7F50;">
                                            Edit
                                        </a>
                                        <a onclick="return confirm('Bạn có muốn xóa bài đăng này không!')" href="/deletePost.php?id_post=<?= $post['id_post']; ?>" class="btn btn-danger" role="button" style="background-color: #B22222;">
                                            Delete
                                            <?php $_SESSION['id_post'] = $post['id_post']; ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div>
                                <?php
                                // Sử dụng lớp Pagination
                                $totalItems = 10;
                                $itemsPerPage = 3;
                                $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                                $baseUrl = 'dsPost.php';
                                $queryParameters = array('category' => 'news');

                                $pagination = new Pagination($totalItems, $itemsPerPage, $currentPage, $baseUrl, $queryParameters);
                                echo $pagination->generatePaginationHtml();
                                ?>
                            </div>
                </div>
                <br>
                <hr><br>
                <?php require_once __DIR__ . '/../partials/footer.php'; ?><br>
            </div>
        </div>
    </div>
</body>

</htm>