<?php
require_once("../App/Controllers/crypt.php");
class Home {
    use Crypt;
    use AdresseIp;
    public function viewHome()
    {
        require_once("../App/Views/home.phtml");
    }
    public function viewLogin()
    {
        require_once("../App/Views/login.phtml");
    }

    public function register(){
        require_once("../App/Views/register.phtml");
    }

    public function viewForget()
    {
        require_once("../App/Views/forget.phtml");
    }

    public function contact()
    {
        require_once("../App/Views/contact.phtml");
    }

    public function about()
    {
        require_once("../App/Views/about.phtml");
    }
    public function articles()
    {
        require_once("../App/Views/articles.phtml");
    }

    public function logout()
    {
        @session_start();
        unset($_SESSION["Auth"]);
        session_destroy();
        $controller = $this->datacrypt('home');
        $action = $this->datacrypt('view-home');
        $url = "?goto=$controller&action=$action";
        header("Location:/$url");
    }

    public function dash()
    {
        require_once("../App/Views/admin/dashboard.phtml");
    }
}