<?php

namespace website\labs;

use PDO;

class Post
{
    private ?PDO $db;
    public $title;
    public $content;
    public $image_post;
    public $stastu_post;
    public $image_path;
    public function __construct(?PDO $pDO)
    {
        $this->db = $pDO;
    }

    public function getPosts($page = 1, $perPage = 10)
    {
        $start = ($page - 1) * $perPage;

        $sql = "SELECT * FROM post ORDER BY id_post DESC LIMIT $start, $perPage";

        $result = $this->db->query($sql);

        return $result->fetchAll();
    }

    public function getAllPosts($page = 1, $perPage = 10)
    {
        $start = ($page - 1) * $perPage;
        $sql = "";
        $result = $this->db->query($sql);
        return $result->fetchAll();
    }

    public function fill(array $data): Post
    {
        $this->title = $data["title"] ?? '';
        $this->content = $data["content"] ?? '';
        $this->image_post = $data["image_post"] ?? '';
        $this->stastu_post = $data["status_post"] ?? '';
        return $this;
    }

    public function addPost()
    {
        $sql = "INSERT INTO post(title, content, image_post, status_post) VALUES(:title, :content, :image_post, :status_post)";
        $this->image_path = $this->uploadImage($_FILES['image_post'] ?? null);
        $statement = $this->db->prepare($sql);
        $id_owner = $_SESSION['id_owner']; 
        $statement->execute([
            'title' => $this->title,
            'content' => $this->content,
            'image_post' => $this->image_path,
            'status_post' => $this->stastu_post,
            'id_owner'=> $id_owner
        ]);
    }

    public function uploadImage($image)
    {
        if (!isset($image["name"]) || !isset($image["tmp_name"]) || !isset($image["size"])) {
            return "Missing required parameters";
        }
        $target_dir = "/img";
        $target_file = $target_dir . basename($image["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra kích thước và loại file
        if ($image["size"] > 500000) {
            return "File quá lớn";
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            return "Chỉ chấp nhận file JPG, JPEG, PNG";
        }

        // Xử lý upload file
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            return $target_file;
        }

        return "Có lỗi xảy ra khi upload";
    }

    public function updatePost($id, $data)
    {
        $sql = "UPDATE post SET title = :title, content = :content WHERE id_post = :id_post";

        $statement = $this->db->prepare($sql);
        $statement->execute([
            ':id_post' => $id,
            ':title' => $data['title'],
            ':content' => $data['content']
        ]);
    }

    public function deletePost($id)
    {
        $sql = "DELETE FROM post WHERE id_post = :id_post";

        $statement = $this->db->prepare($sql);
        $statement->execute(['id_post' => $id]);
    }
}
