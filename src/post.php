<?php

namespace phongtrosv\src;

use PDO;

class Post
{
    private ?PDO $db;
    private $errors = [];
    public function __construct(?PDO $pdo)
    {
        $this->db = $pdo;
    }

    private function uploadImage($image)
    {
        if (!isset($image) || !is_array($image)) {
            return false;
        }

        $upload_dir = './img';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $imagePath = $upload_dir . '/' . time() . '-' . basename($image['name']);

        $allowed_formats = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed_formats) || $image['size'] > 1000000) {
            return false;
        }

        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            return $imagePath;
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

        $this->clearErrors();

        if (empty($title)) {
            $this->addError('title', 'Phải nhập tiêu đề bài viết!');
        }

        if (empty($content)) {
            $this->addError('content', 'Phải nhập nội dung!');
        }

        if (!empty($this->errors)) {
            return false;
        }

        $imagePath = $this->uploadImage($image);

        if ($imagePath === false) {
            $this->addError('image', 'Lỗi tải lên tệp ảnh!');
            return false;
        }

        $sql = "INSERT INTO post (title, content, image, status, id_owner, id_room)
                VALUES (:title, :content, :image, :status, :id_owner, :id_room)";

        $statement = $this->db->prepare($sql);
        $statement->execute([
            ':title' => $title,
            ':content' => $content,
            ':image' => $imagePath,
            ':status' => $status,
            ':id_owner' => $id_owner,
            ':id_room' => $id_room
        ]);

        return true;
    }

    public function editPost($id_post, $title, $content, $image, $status)
    {
        $imagePath = $this->uploadImage($image);

        if ($imagePath === false) {
            return false;
        }

        $sql = "UPDATE post
                SET title = :title, content = :content, image = :image, status = :status
                WHERE id_post = :id_post";

        $statement = $this->db->prepare($sql);
        $result = $statement->execute([
            ':id_post' => $id_post,
            ':title' => $title,
            ':content' => $content,
            ':image' => $imagePath,
            ':status' => $status
        ]);

        return $result;
    }

    public function deletePost($id_post)
    {
        $sql = "SELECT image FROM post WHERE id_post = :id_post";
        $statement = $this->db->prepare($sql);
        $statement->execute([':id_post' => $id_post]);
        $imagePath = $statement->fetchColumn();

        $sql = "DELETE FROM post WHERE id_post = :id_post";
        $statement = $this->db->prepare($sql);
        $result = $statement->execute([':id_post' => $id_post]);


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
        $statement->execute([':search_area' => $search_area]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllPostRooms()
    {
        $sql = "SELECT p.title, p.content, p.image, r.id_room, r.price_room, r.area_room, r.status_room, o.name_owner, o.phone_owner, o.email_owner, o.address_owner
        FROM post p
        JOIN room r ON p.id_room = r.id_room
        JOIN owner o ON r.id_owner = o.id_owner
        ORDER BY p.created_at DESC";

        $statement = $this->db->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
