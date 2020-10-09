<?php
require_once('./model/Manager.php');
class PostManager extends Manager
{
    public function getPosts() {
        $db = $this->dbConnect();
        $posts = $db->query('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM posts ORDER BY id DESC LIMIT 5');
        return $posts->fetchAll();
    }

    public function getPost($idPost) {
        $db = $this->dbConnect();
        $post = $db->prepare('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM posts WHERE id = ?');
        $post->execute(array($idPost));
        return $post->fetch();
    }

    public function checkPostExistence ($postID) {
        if($postID && !(preg_match("#[^0-9]+#", $postID)) && strlen($postID) <= 3) { 
            return true;
        }
    }
}