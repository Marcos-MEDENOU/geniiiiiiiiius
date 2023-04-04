<?php

class User extends Database
{
    /**
     * $conn, variable pour instancier la classe Connexion et pour faire la connexion à la bd avec la fonction connect()
     * 
     * $conn = $this->connect();
     */
    private $id, $email, $code, $pseudo, $password, $role, $timestamps;

    /**
     * verifyEmailOrName(), pour vérifier si il y a un utilisateur dans la bd ayant déjà ce genre d'email ou de nom d'utilisateur
     */
    public function verifyEmailOrName($email, $pseudo)
    {
        $this->email = $email;
        $this->pseudo = $pseudo;

        $conn = $this->connect();

        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT * FROM `blog`.users WHERE user_email = ? OR user_pseudo = ?;";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->email, $this->pseudo]);
        $result = $stmt->fetchAll();
        return $result;
    }

    // Requête renvoyant tous les utilisateurs ayant un compte sur le site
    public function getAllUsers()
    {
        $conn = $this->connect();
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT `users`.user_id, `users`.user_email, `users`.user_pseudo, `users`.user_role, `users`.created_at FROM `blog`.users;";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);
        $result = $stmt->fetchAll();
        return $result;
    }

    // Affichage des informations d'un utilisateur
    public function getOneUser($id)
    {
        $conn = $this->connect();
        $this->id = $id;
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT `users`.user_id, `users`.user_email, `users`.user_pseudo, `users`.user_role, `users`.created_at FROM `blog`.users WHERE `users`.user_id=?;";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->id]);
        $result = $stmt->fetchAll();
        return $result;
    }

    // Suppression d'un utilisateur
    public function deleteOneUser($id)
    {
        $conn = $this->connect();
        $this->id = $id;
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "DELETE FROM `blog`.users WHERE `users`.user_id =?;";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->id]);
        $result = $stmt;
        return $result;
    }

    // Vérifie si un utilisateur porte ces identifiants
    public function verifyPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        $conn = $this->connect();

        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT * FROM `blog`.users WHERE user_email = ? OR user_pseudo = ?;";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->pseudo, $this->pseudo]);
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * insertUser(), pour insérer dans la bd des utilisateurs
     */
    public function insertUser($email, $pseudo, $role, $password, $timestamps)
    {

        $conn = $this->connect();

        $this->email = $email;
        $this->pseudo = $pseudo;
        $this->password = $password;
        $this->role = $role;
        $this->timestamps = $timestamps;

        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "INSERT INTO `blog`.users VALUES(NULL, :email, NULL, :pseudo, :role, :password, :timesdate, NULL)";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ":email" => $this->email,
            ":pseudo" => $this->pseudo,
            ":role" => $this->role,
            ":password" => password_hash($this->password, PASSWORD_DEFAULT),
            ":timesdate" => $this->timestamps
        ]);

    }

    // Fais une modification dans la table users plus précisement dans le champ email_code
    public function updateCode($code, $email)
    {

        $conn = $this->connect();

        $this->email = $email;
        $this->code = $code;

        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "UPDATE `blog`.users set `users`.email_code = :code WHERE `users`.user_email = :email";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ":code" => $this->code,
            ":email" => $this->email
        ]);

    }

    // Change le mot de passe de l'utilisateur
    public function updatePassword($pass, $email)
    {

        $conn = $this->connect();

        $this->email = $email;
        $this->password = $pass;

        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "UPDATE `blog`.users set `users`.user_password = :password WHERE `users`.user_email = :email";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            ":password" => password_hash($this->password, PASSWORD_DEFAULT),
            ":email" => $this->email
        ]);

        return $result;
    }
}