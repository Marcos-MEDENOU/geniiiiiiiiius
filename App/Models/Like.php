<?php

class Like extends Database
{
    private $article_id, $user_id;

    // Ajoute les likes dans la table likes
    public function addLike($article_id, $user_id)
    {
        $connexion = $this->connect();
        $this->article_id = $article_id;
        $this->user_id = $user_id;

        // Requête SQL
        $sql = "INSERT INTO `blog`.likes VALUES(NULL,?,?);";

        // Requête préparée
        $statement = $connexion->prepare($sql);
        $result = $statement->execute([$this->article_id, $this->user_id]);

        // Retourne un null/true si c'est bon;
        return $result;
    }

    // selectCount(), pour compter le nombre de personnes ayant aimé une oeuvre
    public function selectCount($article_id)
    {
        $conn = $this->connect();
        $this->article_id = $article_id;

        // Requête préparée
        $sql = "SELECT COUNT(article_id) AS Nombre FROM `blog`.likes WHERE article_id = ?";

        // Retourne un null/true si c'est bon;
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->article_id]);
        $result = $stmt->fetch();
        return $result;
    }

    // deleteOneLikes(), pour supprimer le like qu'un utilisateur a mis pour un article
    public function deleteOneLikes($article_id, $user_id)
    {
        $connexion = $this->connect();
        $this->article_id = $article_id;
        $this->user_id = $user_id;

        // Requête SQL
        $sql = "DELETE FROM `blog`.likes WHERE article_id = ? AND user_id = ?";

        // Requête préparée
        $stmt = $connexion->prepare($sql);
        $result = $stmt->execute([$this->article_id, $this->user_id]);

        // Retourne un null/true si c'est bon;
        return $result;
    }
}