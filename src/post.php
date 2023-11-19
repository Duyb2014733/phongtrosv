<?php

namespace phongtrosv\src;

use PDO;

class Post
{
    private ?PDO $db;
    private $errors = []; // Mảng lưu trữ các thông báo lỗi
    public function __construct(?PDO $pdo)
    {
        $this->db = $pdo;
    }

    private function uploadImage($image)
    {
        if (!isset($image) || !is_array($image)) {
            return false;
        }

        // Thư mục lưu file ảnh
        $upload_dir = './img';

        // Tạo thư mục nếu nó không tồn tại
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Tên file mới
        $imagePath = $upload_dir . '/' . time() . '-' . basename($image['name']);

        // Kiểm tra định dạng và kích thước tệp ảnh
        $allowed_formats = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed_formats) || $image['size'] > 1000000) {
            return false;
        }

        // Di chuyển tệp ảnh vào thư mục lưu trữ
        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            return $imagePath; // Trả về đường dẫn của tệp ảnh đã tải lên
        }

        return false;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function addError($field, $message)
    {
        $this->errors[$field] = $message;
    }

    public function clearErrors()
    {
        $this->errors = [];
    }

    public function getPostById($id_post)
    {
        $sql = "SELECT * FROM post WHERE id_post = :id_post";
        $statement = $this->db->prepare($sql);
        $statement->execute([':id_post' => $id_post]);

        $post = $statement->fetch();
        return $post;
    }

    public function addPost($title, $content, $image, $status, $id_owner, $id_room)
    {

        $this->clearErrors(); // Xóa các thông báo lỗi trước đó

        // Kiểm tra và xử lý các trường
        if (empty($title)) {
            $this->addError('title', 'Phải nhập tiêu đề bài viết!');
        }

        if (empty($content)) {
            $this->addError('content', 'Phải nhập nội dung!');
        }

        // Kiểm tra lỗi
        if (!empty($this->errors)) {
            return false; // Có lỗi, không thực hiện thêm bài đăng
        }

        // Upload tệp ảnh
        $imagePath = $this->uploadImage($image);

        if ($imagePath === false) {
            $this->addError('image', 'Lỗi tải lên tệp ảnh!');
            return false; // Xử lý lỗi khi tải lên tệp ảnh
        }

        // Thêm bài đăng vào cơ sở dữ liệu
        $sql = "INSERT INTO post (title, content, image, status, id_owner, id_room) 
                VALUES (:title, :content, :image, :status, :id_owner, :id_room)";

        $statement = $this->db->prepare($sql);
        $statement->execute([
            ':title' => $title,
            ':content' => $content,
            ':image' => $imagePath, // Đường dẫn tới tệp ảnh đã tải lên
            ':status' => $status,
            ':id_owner' => $id_owner,
            ':id_room' => $id_room
        ]);

        return true; // Không có lỗi, bài đăng được thêm thành công
    }

    public function editPost($id_post, $title, $content, $image, $status)
    {
        // Upload tệp ảnh nếu có sự thay đổi
        $imagePath = $this->uploadImage($image);

        if ($imagePath === false) {
            return false; // Xử lý lỗi khi tải lên tệp ảnh
        }

        // Cập nhật bài đăng trong cơ sở dữ liệu
        $sql = "UPDATE post 
                SET title = :title, content = :content, image = :image, status = :status
                WHERE id_post = :id_post";

        $statement = $this->db->prepare($sql);
        $result = $statement->execute([
            ':id_post' => $id_post,
            ':title' => $title,
            ':content' => $content,
            ':image' => $imagePath, // Đường dẫn tới tệp ảnh đã tải lên
            ':status' => $status
        ]);

        return $result;
    }

    public function deletePost($id_post)
    {
        // Lấy đường dẫn tới tệp ảnh để xóa (nếu có)
        $sql = "SELECT image FROM post WHERE id_post = :id_post";
        $statement = $this->db->prepare($sql);
        $statement->execute([':id_post' => $id_post]);
        $imagePath = $statement->fetchColumn();

        // Xóa bài đăng khỏi cơ sở dữ liệu
        $sql = "DELETE FROM post WHERE id_post = :id_post";
        $statement = $this->db->prepare($sql);
        $result = $statement->execute([':id_post' => $id_post]);

        // Xóa tệp ảnh (nếu có)
        if ($result && !empty($imagePath) && is_file($imagePath)) {
            unlink($imagePath);
        }
        return $result;
    }

    public function getAllPosts()
    {
        $sql = "SELECT * FROM post";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPostsByOwnerId($id_owner)
    {
        $sql = "SELECT * FROM post WHERE id_owner = :id_owner";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_owner', $id_owner, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getsearchareaPosts($search_area)
    {
        $sql = "SELECT p.title, p.content, p.image, r.id_room, r.price_room, r.area_room, r.status_room, o.name_owner, o.phone_owner, o.email_owner, o.address_owner
        FROM post p
        JOIN room r ON p.id_room = r.id_room
        JOIN owner o ON r.id_owner = o.id_owner
        WHERE r.area_room = :search_area
        ORDER BY p.created_at DESC";

        $statement = $this->db->prepare($sql);
        $statement->execute(['search_area' => $search_area]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
