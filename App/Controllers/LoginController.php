<?php
require_once('../App/Conf/Database.php');
require_once('../App/Models/User.php');
class LoginController
{
    use Crypt;
    /**
     * $user; on va utiliser cette variable pour instancier la classe user dans le controller
     */
    public $user;
    public $pseudo;
    public $password;

    public function verifyInputs()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->pseudo = $this->sanitaze($data->username);
        $this->password = $this->sanitaze($data->pass);
        $this->emptyInputs();
    }

    /**
     * verifyAccount(), vérifie s'il existe un utilisateur dans la bdd et compte tenu du résultat fait une redirection ou non
     */
    public function verifyAccount()
    {
        session_start();
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->pseudo = $this->sanitaze($data->username);
        $this->password = $this->sanitaze($data->pass);
        $this->user = new User();
        $result = $this->user->verifyPseudo($this->pseudo);
        $count = count($result);
        if ($count > 0) {
            $password = password_verify($this->password, $result[0]["user_password"]);
            if ($password === true) {
                $_SESSION["Auth"]["id"] = $result[0]["user_id"];
                $_SESSION["Auth"]["email"] = $result[0]["user_email"];
                $_SESSION["Auth"]["pseudo"] = $result[0]["user_pseudo"];
                $_SESSION["Auth"]["role"] = $result[0]["user_role"];
                $_SESSION["Auth"]["created_at"] = $result[0]["created_at"];
                $controller = "?goto=" . $this->datacrypt('home');
                $action = "action=" . $this->datacrypt('view-home');
                $url = $controller . "&" . $action;
                echo json_encode("$url");
            } else {
                echo json_encode("mot_passe_erroné");
            }
        } else {
            echo json_encode("User_not_exist");
        }
    }

    /**
     * sanitaze(); pour les espacements et les injections de codes
     */
    public function sanitaze($data)
    {
        $reg = preg_replace("/\s+/", " ", $data);
        $reg = preg_replace("/^\s*/", "", $reg);
        $reg = htmlspecialchars($reg);
        $reg = stripslashes($reg);
        $data = $reg;
        return $data;
    }
    /**
     * emptyInputs(), pour vérifiez si un des champs est vide
     */
    public function emptyInputs()
    {
        if (empty($this->pseudo) || empty($this->password)) {
            echo json_encode("empty_input");
        } else {
            echo json_encode("valid_input");
        }
    }

}