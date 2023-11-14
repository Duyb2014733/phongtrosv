<?php
require_once __DIR__ . '/src/help.php';
require_once __DIR__ . '/libraries/Psr4AutoloaderClass.php';
$loader = new Psr4AutoloaderClass;
$loader->register();
// Các lớp có không gian tên bắt đầu với website/src nằm ở src
$loader->addNamespace('website\src', __DIR__ . '/src');
try {
    $PDO = (new \website\src\PDOFactory())->create([
        'dbhost' => 'localhost',
        'dbname' => 'website',
        'dbuser' => 'b2014733',
        'dbpass' => '020502'
    ]);
} catch (Exception $ex) {
    echo 'Không thể kết nối đến MySQL,
    kiểm tra lại username/password đến MySQL.<br>';
    exit("<pre>${ex}</pre>");
}
require_once __DIR__ . '/src/help.php';