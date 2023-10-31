<?php
require_once __DIR__ . '/../bootstrap.php';

require_once __DIR__ . '/../partials/header.php';
?>
<!DOCTYPE html>
<html eng=vi>

<body>
    <?php
    require_once __DIR__ . '/../partials/navbar.php'
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
        </div>

</body>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>

</html>

