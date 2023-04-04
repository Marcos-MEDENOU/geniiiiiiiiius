<?php

class Comment extends Database
{
    // Déclaration des variables
    private $id, $body, $user_id, $article_id, $created_at;

    // Ajoute les commentaires dans la bdd précisement dans la table comments
    public function addComment($body, $user_id, $article_id, $created_at)
    {
        $conn = $this->connect();
        $this->body = $body;
        $this->user_id = $user_id;
        $this->article_id = $article_id;
        $this->created_at = $created_at;

        // Requête SQL
        $sql = "INSERT INTO `blog`.comments VALUES(NULL,?,?,?,?);";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $result = $statement->execute([$this->body, $this->user_id, $this->article_id, $this->created_at]);

        // Retourne un null/true si c'est bon;
        return $result;
    }

    // Affiche tous les commentaires basés un article spécifique
    public function getAllComment($article_id)
    {
        $conn = $this->connect();
        $this->article_id = $article_id;

        // Requête SQL
        $sql = "SELECT `comments`.comment_id, `comments`.comment_body, `comments`.user_id, `comments`.article_id, `comments`.created_at FROM `blog`.comments INNER JOIN `blog`.articles ON `articles`.article_id = `comments`.article_id WHERE `articles`.article_id = ?;";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $result = $statement->execute([$this->article_id]);
        return $result;
    }

    // Affiche tous les commentaires d'un utilisateur spécifique
    public function getAllCommentByIdUser($user_id)
    {
        $conn = $this->connect();
        $this->user_id = $user_id;

        // Requête SQL
        $sql = "SELECT `comments`.comment_id, `comments`.comment_body, `comments`.user_id, `comments`.article_id, `comments`.created_at FROM `blog`.comments INNER JOIN `blog`.users ON `users`.user_id = `comments`.user_id WHERE `users`.user_id = ?;";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $result = $statement->execute([$this->user_id]);
        return $result;
    }

    // Suppression d'un commentaire
    public function deleteOneComment($id)
    {
        $conn = $this->connect();
        $this->id = $id;

        // Requête SQL
        $sql = "DELETE FROM `blog`.comments WHERE `comments`.comment_id=?";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $statement->execute([$this->id]);

        // Retourne un null/true si c'est bon;
        $result = $statement;
        return $result;
    }
}