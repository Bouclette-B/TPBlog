<?php
namespace Bouclette\TPBlog\Model;

require_once('./model/Manager.php');

class PostManager extends Manager
{
    public function getPosts() {
        $db = $this->dbConnect();
        $postsArray = $db->query('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM posts ORDER BY id DESC LIMIT 5');
        $posts = $postsArray->fetchAll();
        $postsArray->closeCursor();
        return $posts;
    }

    public function getPost($idPost) {
        $db = $this->dbConnect();
        $postArray = $db->prepare('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM posts WHERE id = ?');
        $postArray->execute(array($idPost));
        $post = $postArray->fetch();
        $postArray->closeCursor();
        return $post;
    }
}