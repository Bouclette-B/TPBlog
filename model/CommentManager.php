<?php
namespace Bouclette\TPBlog\Model;

require_once('./model/Manager.php');

class CommentManager extends Manager
{
    public function insertComment($idPost, $postContent) {
        $db = $this->dbConnect();
        if(isset($postContent)){
            $answer = $db->prepare('INSERT INTO comments (id, idPost, author, comment, dateComment) VALUES(NULL, :idPost, :author, :comment, NOW())');
            $answer->execute(array(
                'idPost' => $idPost, 
                'author' => $_SESSION['pseudo'],
                'comment' =>$postContent));
            $answer->closeCursor();
            }
    }

    public function getComments($idPost) {
        $db = $this->dbConnect();
        $commentsArray = $db->prepare('SELECT *, DATE_FORMAT(dateComment, \'%d/%m/%Y à %Hh%imin%ss\') AS dateComments FROM comments WHERE idPost = ? ORDER BY id DESC LIMIT 5');
        $commentsArray->execute(array($idPost));
        $comments = $commentsArray->fetchAll();
        $commentsArray->closeCursor();
        return $comments;
    }
    
    public function getComment($idComment) {
        $db = $this->dbConnect();
        $commentArray = $db->prepare('SELECT *, DATE_FORMAT(dateComment, \'%d/%m/%Y à %Hh%imin%ss\') AS dateComments FROM comments WHERE id = ?');
        $commentArray->execute(array($idComment));
        $comment = $commentArray->fetch();
        $commentArray->closeCursor();
        return $comment;
    }

    public function updateComment($newComment, $idComment, $idPost) {
        $db = $this->dbConnect();
        if(isset($newComment)){
            $updateComment = $db->prepare('UPDATE comments SET comment = :newComment WHERE id = :idComment');
            $updateComment->execute(array(
                'newComment' => $newComment,
                'idComment' => $idComment
            ));
            $updateComment->closeCursor();
            header('Location: index.php?action=post&id=' . $idPost);
        }
    }
}