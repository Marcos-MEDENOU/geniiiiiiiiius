<?php
require_once('../App/Conf/Database.php');
require_once('../App/Models/User.php');

class ForgetController
{
    use Crypt ;
    // connexion avec la table user
    private $user;
    // déclaration des variables
    private $email;
    private $code;
    private $password;
    private $confirm_password;

    // Cette function vérifie si le champ de type email est remplit en appelant la function emailInputs()
    public function verifyEmailInputs()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->email = $this->sanitaze($data->email);
        $this->emailInputs();
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
     * emailInputs(), pour vérifiez si le champ est vide
     */
    public function emailInputs()
    {
        if (empty($this->email)) {
            echo json_encode("empty_email_input");
        } else {
            echo json_encode("valid_email_input");
        }
    }

    /**
     * passInputs(), pour vérifiez si un des champs est vide
     */
    public function passInputs()
    {
        if (empty($this->password) || empty($this->confirm_password)) {
            echo json_encode("empty_input");
        } else {
            echo json_encode("valid_input");
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

    // Pour vérifier si l'email entré par l'utilisateur existe dans notre bdd. Si oui, il renvoie un tableau chargé de données.
    public function verifyPseudo($email)
    {
        $this->user = new User();
        $array = $this->user->verifyPseudo($email);
        return $array;
    }

    // Function qui vérifie si le code email entré par l'utilisateur est conforme à celui qu'on lui a envoyé.
    public function codeEmail()
    {
        $this->user = new User();
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->email = $this->sanitaze($data->email);
        $this->code = $this->sanitaze($data->email_code);
        $array = $this->verifyPseudo($this->email);
        $array_code = $array[0]["email_code"];
        if ($this->code == $array_code) {
            echo json_encode("good");
        } else {
            echo json_encode("bad");
        }
    }

    /**
     * verifyPassword(), pour vérifiez si les deux mot de passe que l'utilisateur entre sont corrects
     */
    public function verifyPassword()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->password = $data->pass;
        $this->confirm_password = $data->new_pass;
        if ($this->password !== $this->confirm_password) {
            echo json_encode("password_different");
        } else {
            echo json_encode("password_identique");
        }
    }


    /**
     * passWord(), format des mots de passe qu'on accepte
     */
    public function passWord()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->password = $data->pass;
        if (preg_match("/^[a-zA-Z-\@]+[\d]+/i", $this->password) && strlen($this->password) >= 8) {
            echo json_encode("password_respect");
        } else {
            echo json_encode("password_not_respect");
        }
    }

    // Vérifie si les champs des passwords sont remplis.
    public function newEmptyPass()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->password = $this->sanitaze($data->pass);
        $this->confirm_password = $this->sanitaze($data->new_pass);
        $this->passInputs();
    }

    // Function pour changer le mot de passe de l'utilisateur
    public function updatePass()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->user = new User();
        $this->email = $this->sanitaze($data->email);
        $this->password = $this->sanitaze($data->pass);
        $updatePass = $this->user->updatePassword($this->password, $this->email);
        if ($updatePass === true) {
            $controller = "?goto=" . $this->datacrypt('home');
            $action = "action=" . $this->datacrypt('view-login');
            $url = $controller . "&" . $action;
            echo json_encode("$url");
        } else {
            echo json_encode("bad");
        }
    }

    // Function qui permet de changer la valeur du champ email_code de la table users et d'envoyer un mail à l'utilisateur
    public function update()
    {
        $this->user = new User();
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->email = $this->sanitaze($data->email);
        $array = $this->verifyPseudo($this->email);
        $code = rand(0, 1000000);
        if (count($array) > 0) {
            $update = $this->user->updateCode($code, $this->email);
            $result = $this->verifyPseudo($this->email);

            $to = $result[0]["user_email"];
            $code_randown = $result[0]["email_code"];
            $subject = "Pour l'intialisation de votre mot de passe vous devez entrer le code ci-dessous.";
            $message = "Code de confirmation d'email : " . $code_randown;
            $headers = "From: Genius Blog" . "\r\n" . "CC: geniusblog@gmail.com";
            // NB: geniusblog@gmail.com, cet email dépend de l'hébergeur sur lequel se trouve notre site et doit être valide.
            mail($to, $subject, $message, $headers);
            echo json_encode($update);
        } else {
            echo json_encode("bad");
        }

    }
}