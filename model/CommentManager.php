<?php
class CommentManager extends Manager
{
    public function insertComment($idPost, $comment) {
        $db = $this->dbConnect();
        if(isset($comment)){
            $answer = $db->prepare('INSERT INTO comments (id, idPost, author, comment, dateComment) VALUES(NULL, :idPost, :author, :comment, NOW())');
            $answer->execute(array(
                'idPost' => $idPost, 
                'author' => $_SESSION['pseudo'],
                'comment' =>$comment));
            $answer->closeCursor();
            }
    }

    public function getComments($idPost) {
        $db = $this->dbConnect();
        $comments = $db->prepare('SELECT *, DATE_FORMAT(dateComment, \'%d/%m/%Y à %Hh%imin%ss\') AS dateComments FROM comments WHERE idPost = ? ORDER BY id DESC LIMIT 5');
        $comments->execute(array($idPost));
        return $comments->fetchAll();;
    }
    
    public function getComment($idComment) {
        $db = $this->dbConnect();
        $comment = $db->prepare('SELECT *, DATE_FORMAT(dateComment, \'%d/%m/%Y à %Hh%imin%ss\') AS dateComments FROM comments WHERE id = ?');
        $comment->execute(array($idComment));
        return $comment->fetch();
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