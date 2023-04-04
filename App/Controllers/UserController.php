<?php
require_once('../App/Conf/Database.php');
require_once('../App/Models/User.php');

class UserController
{
    use Crypt;
    // connexion avec la table user
    private $user;
    // déclaration des variables
    private $email;
    private $pseudo;
    private $password;
    private $confirm_password;
    private $role;
    private $timestamps;

    // Vérifie si tous les champs du formulaires sont remplis.
    public function verifyInputs()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->email = $this->sanitaze($data->email);
        $this->pseudo = $this->sanitaze($data->pseudo);
        $this->password = $this->sanitaze($data->password);
        $this->confirm_password = $this->sanitaze($data->confirm);
        $this->emptyInputs();
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
     * passWord(), format des mots de passe qu'on accepte
     */
    public function passWord()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->password = $data->password;
        if (preg_match("/^[a-zA-Z-\@]+[\d]+/i", $this->password) && strlen($this->password) >= 8) {
            echo json_encode("password_respect");
        } else {
            echo json_encode("password_not_respect");
        }
    }

    /**
     * emptyInputs(), pour vérifiez si un des champs est vide
     */
    public function emptyInputs()
    {
        if (empty($this->email) || empty($this->pseudo) || empty($this->password) || empty($this->confirm_password)) {
            echo json_encode("empty_input");
        } else {
            echo json_encode("valid_input");
        }
    }

    /**
     * verifyPassword(), pour vérifiez si les deux mot de passe que l'utilisateur entre sont corrects
     */
    public function verifyPassword()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->password = $data->password;
        $this->confirm_password = $data->confirm;
        if ($this->password !== $this->confirm_password) {
            echo json_encode("password_different");
        } else {
            echo json_encode("password_identique");
        }
    }

    /**
     * verifyEmail(), pour vérifiez si l'email suis les normes pré-requises
     */
    public function verifyEmail()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->email = $data->email;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode("email_invalid");
        } else {
            echo json_encode("email_valid");
        }
    }

    // Vérifie si dans notre bdd, on a un utilisateur qui a un email ou un pseudo correspondant à ceux entrés par un autre utilisateur. Si oui, il renvoie un tableau bien chargé.
    public function searchUser($email, $pseudo)
    {
        $this->user = new User();
        $array = $this->user->verifyEmailOrName($email, $pseudo);
        return $array;
    }

    // Renvoie un tableau contenant les informations liées à un pseudo spécifique 
    public function verifyPseudo($pseudo)
    {
        $this->user = new User();
        $array = $this->user->verifyPseudo($pseudo);
        return $array;
    }

    // Enrégistre les informations entrées par un utilisateur dans la `users` se trouvant dans notre bdd
    public function register()
    {
        session_start();
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->email = $this->sanitaze($data->email);
        $this->pseudo = $this->sanitaze($data->pseudo);
        $this->password = $this->sanitaze($data->password);
        $this->role = 1;
        $this->user = new User();
        $this->timestamps = date("Y-m-d h:i:s");

        $tableau = $this->searchUser($this->email,  $this->pseudo);
        if(count($tableau)>0)
        {
            echo json_encode("bad");
        } else {
            $result = $this->user->insertUser($this->email, $this->pseudo, $this->role, $this->password, $this->timestamps);
            $tableau = $this->verifyPseudo($this->pseudo);

            $_SESSION["Auth"]["id"] = $tableau[0]["user_id"];
            $_SESSION["Auth"]["email"] = $tableau[0]["user_email"];
            $_SESSION["Auth"]["pseudo"] = $tableau[0]["user_pseudo"];
            $_SESSION["Auth"]["role"] = $tableau[0]["user_role"];
            $_SESSION["Auth"]["created_at"] = $tableau[0]["created_at"];

            $controller = "?goto=" . $this->datacrypt('home');
            $action = "action=" . $this->datacrypt('view-home');
            $url = $controller . "&" . $action;
            echo json_encode("$url");
        }
    }
}