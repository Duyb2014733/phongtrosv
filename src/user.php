<?php

namespace website\labs;

use PDO;

class User
{
    private ?PDO $db;
    public $id_name;
    public $username;
    public $password;
    public $role;
    public function __construct(?PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function getUser($username)
    {
        $sql = "SELECT * FROM user WHERE username = :username";

        $statement = $this->db->prepare($sql);
        $statement->execute([':username' => $username]);

        $user = $statement->fetch();
        return $user;
    }
    public function checkUser($username, $password)
    {
        // Lấy thông tin tài khoản dựa vào username
        $user = $this->getUser($username);
        // Kiểm tra tài khoản có tồn tại không
        if (!$user) {
            return 'User not found';
        }
        if (!password_verify($password, $user['password'])) {
            return 'Invalid password';
        }
        // Lấy giá trị trường role
        $username = $user['username'];
        // Kiểm tra và trả về kết quả
        return $username;
    }

    function checkUserRole($username, $password)
    {
        // Lấy thông tin tài khoản dựa vào username
        $user = $this->getuser($username);
        // Kiểm tra tài khoản có tồn tại không
        if (!$user) {
            return 'User not found';
        }
        if (!password_verify($password, $user['password'])) {
            return 'Invalid password';
        }
        // Lấy giá trị trường role
        $role = $user['role'];
        // Kiểm tra và trả về kết quả
        if ($role == 'Admin') {
            return 'Admin';
        } else if ($role == 'Owner') {
            return 'Owner';
        }
    }
    public function addUser($username, $password, $role)
    {
        $user = $this->getUser($username);
        if (!$user) {
            $error = "Tài khoản đã tồn tại!";
            return $error;
        } else {
            // Mã hóa mật khẩu
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            // Thêm tài khoản mới vào bảng user
            $sql = "INSERT INTO user (username, password, role) VALUES(:username, :password, :role)";
            $statement = $this->db->prepare($sql);
            $statement->execute([
                ':username' => $username,
                ':password' => $password_hash,
                ':role' => $role
            ]);
            return $statement->rowCount();
        }
    }
    public function getUserIdName($username)
    {
        $sql = "SELECT id_name FROM user WHERE username = :username";

        $statement = $this->db->prepare($sql);
        $statement->execute([':username' => $username]);

        $result = $statement->fetch();

        if ($result) {
            return $result['id_name'];
        } else {
            return null; // Trả về null nếu không tìm thấy người dùng
        }
    }

    public function getOwnerIdByIdName($username)
{
    $id_name = $this->getUserIdName($username);
    $sql = "SELECT id_owner FROM owner WHERE id_name = :id_name";

    $statement = $this->db->prepare($sql);
    $statement->execute([':id_name' => $id_name]);

    $result = $statement->fetch();
    
    if ($result) {
        return $result['id_owner'];
    } else {
        return null; // Trả về null nếu không tìm thấy id_name
    }
}
}
