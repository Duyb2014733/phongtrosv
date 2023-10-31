<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();
if (!isset($_SESSION['id_name'])) {
    header('Location: Dangnhap.php');
}

$sql = "SELECT title, content, image_post 
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
    <?php
    require_once __DIR__ . '/../partials/navbar_owner.php';
    ?>

    <div class="container">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

            <div class="carousel-inner">
                <div class="item active">
                    <img src="/img/1.jpg" alt="1">
                </div>

                <div class="item">
                    <img src="/img/2.jpg" alt="2">
                </div>

                <div class="item">
                    <img src="/img/3.jpg" alt="3">
                </div>
            </div>

            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div><br><br>
        <div class="column">
            <div class="col-sm-4">
                <?php
                // Vòng lặp để hiển thị các bài đăng
                foreach ($posts as $post) {

                    echo '<div class="post">';
                    echo '<img src="' . $post['image_post'] . '" >';
                    echo '<h2>' . $post['title'] . '</h2>';
                    echo '<p>' . $post['content'] . '</p>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>



</body>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>

</html>