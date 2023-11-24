<?php

namespace phongtrosv\src;

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
        $user = $this->getUser($username);
        if (!$user) {
            return 'User not found';
        }
        if (!password_verify($password, $user['password'])) {
            return 'Invalid password';
        }
        $username = $user['username'];
        return $username;
    }

    function checkUserRole($username, $password)
    {
        $user = $this->getuser($username);
        if (!$user) {
            return 'User not found';
        }
        if (!password_verify($password, $user['password'])) {
            return 'Invalid password';
        }
        $role = $user['role'];
        if ($role == 'Admin') {
            return 'Admin';
        } else if ($role == 'Owner') {
            return 'Owner';
        }
    }

    private function validateUserInput($username, $password, $role)
    {
        $errors = [];

        // Kiểm tra các điều kiện để xác định lỗi và thêm vào mảng lỗi
        if (empty($username)) {
            $errors['username'] = 'Tên đăng nhập không được trống';
        }

        if (empty($password)) {
            $errors['password'] = 'Mật khẩu không được trống';
        }

        if (!in_array($role, ['Admin', 'Owner'])) {
            $errors['role'] = 'Vai trò không hợp lệ';
        }

        return $errors;
    }

    public function addUser($username, $password, $role)
    {
        $user = $this->getUser($username);
        if (!empty($user)) {
            $error = "Tài khoản đã tồn tại!";
            return $error;
        } else {
            // Mã hóa mật khẩu
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            // Thêm tài khoản mới vào bảng user
            $sql = "INSERT INTO user (username, password, role) VALUES(:username, :password, :role)";
            $statement = $this->db->prepare($sql);
            $result = $statement->execute([
                ':username' => $username,
                ':password' => $password_hash,
                ':role' => $role
            ]);
            if ($result) {
                return "Tài khoản đã được tạo thành công!";
            } else {
                return "Có lỗi xảy ra khi tạo tài khoản.";
            }
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

    public function getAllUsers()
    {
        $sql = "SELECT * FROM user";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editUser($id, $username, $email)
    {
        $sql = "UPDATE user SET username = :username, email = :email WHERE id = :id";
        $statement = $this->db->prepare($sql);

        return $statement->execute([
            ':id' => $id,
            ':username' => $username,
            ':email' => $email,
        ]);
    }

    public function deleteUser($id_name)
    {
        $sql = "DELETE FROM user WHERE id_name = :id_name";
        $statement = $this->db->prepare($sql);
        $result = $statement->execute([':id_user' => $id_name]);

        // Kiểm tra xem có bản ghi nào bị ảnh hưởng không
        if ($result && $statement->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getIdName($username)
    {
        $sql = "SELECT id_name FROM user WHERE username = :username";
        $statement = $this->db->prepare($sql);
        $statement->execute([':username' => $username]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['id_name'] : null;
    }
}
