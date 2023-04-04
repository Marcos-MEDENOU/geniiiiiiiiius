<?php

class Category extends Database {
 /**
     * $conn, variable pour instancier la classe Connexion et pour faire la connexion à la bd avec la fonction connect()
     * 
     * $conn = $this->connect();
     */
    private $id, $name, $description;

    public function searchCategory($name)
    {
        $conn = $this->connect();
  
        $this->name = $name;
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT * FROM `blog`.categories WHERE category_name = ?;";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->name]);
        $result = $stmt->fetchAll();
        return $result;
    }

    // Affichage de toutes les catégories
    public function allCategories()
    {
        $conn = $this->connect();
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT category_id, category_name, category_description FROM `blog`.categories;";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function addCategory($name, $description) {

      $conn = $this->connect();

      $this->name = $name;
      $this->description = $description;

      /**
       * $sql, pour les requêtes vers la base de données
       */
      $sql = "INSERT INTO `blog`.categories VALUES(NULL, :name, :description)";
      
      /**
       * $stmt, pour recupérer la requête préparée
       */
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute([
          ":name" => $this->name,
          ":description" => $this->description
      ]);

    return $result;
  }
   
    // Suppression d'une catégorie
    public function deleteOneCategory($id)
    {
        $conn = $this->connect();
        $this->id = $id;
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "DELETE FROM `blog`.categories WHERE `categories`.category_id=?;";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->id]);
        $result = $stmt;
        return $result;
    }
}