<?php
require_once __DIR__ . '/../bootstrap.php';

use website\src\Pagination;
use website\src\Customer;

session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: login.php');
    exit();
}
// lấy danh sách Customer
$customer = new Customer($PDO);
$customers = $customer->getCustomers();

require_once __DIR__ . '/../partials/header.php';
?>

<head>
    <title>
        Khách hàng
    </title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php" ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
                    <h2>Danh sách khách hàng</h2>
                    <hr>
                    <a href="/addCustomer.php" class="btn btn-primary btn-lg" role="button">Thêm</a>
                    <hr>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers as $customer) : ?>
                                <tr>
                                    <td><?= $customer['id_customer'] ?></td>
                                    <td><?= $customer['name_customer'] ?></td>
                                    <td><?= $customer['phone_customer'] ?></td>
                                    <td><?= $customer['email_customer'] ?></td>
                                    <td><?= $customer['address_customer'] ?></td>
                                    <td>
                                        <a href="/editCustomer.php?id_customer=<?php echo $customer['id_customer']; ?>" class="btn btn-info" role="button" style="background-color: #FF7F50;">
                                            Edit
                                        </a>
                                        <a onclick="return confirm('Bạn có muốn xóa khách hàng này không!')" href="/deleteCustomer.php?id_customer=<?php echo $customer['id_customer']; ?>" class="btn btn-danger" role="button" style="background-color: #B22222;">
                                            Delete
                                            <?php $_SESSION['id_customer'] = $customer['id_customer']; ?>
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
                        $baseUrl = 'index.php';
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

</html>