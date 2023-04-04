<?php
require_once("../App/Conf/key.php");

class Router
{
    // Fonction permettante de rechercher les controllers et de les appeler au niveau de l'index.php 
    public function autoload($classname)
    {
        return spl_autoload_register(
            function ($classname) {
                $root = "../App/Controllers/";
                $file = $root . $classname . ".php";
                if (is_readable($file)) {
                    require("../App/Controllers/" . $classname . ".php");
                } else {
                    require("../App/Views/error/404.phtml");
                    exit();
                }
            }
        );
    }

    // Fonction de décryptage
    public function datadecrypt($input)
    {
        $input = str_replace('[plus]', '+', $input);
        $first_key = base64_decode(KEYONE);
        $second_key = base64_decode(KEYTWO);
        $mix = base64_decode($input);

        $method = "aes-256-cbc";
        $iv_length = openssl_cipher_iv_length($method);

        $iv = substr($mix, 0, $iv_length);
        $first_encrypted = substr($mix, $iv_length);

        $data = openssl_decrypt($first_encrypted, $method, $first_key, OPENSSL_RAW_DATA, $iv);
        return $data;
    }

    // Conversion d'une chaîne de caractères contenant un ou plusieurs '-' en MajminMajmin
    public function convertToPascalCase($url)
    {
        return preg_replace("/-/", "", ucwords($url, "-"));
    }

    // Conversion d'une chaîne de caractères contenant un ou plusieurs '-' en minMajminMaj
    public function convertToCamelCase($url)
    {
        return lcfirst($this->convertToPascalCase($url));
    }

    // Fonction qui fait les redirections compte tenu ce que l'on retrouve dans l'url
    public function dispatch()
    {
        $url = $_SERVER["QUERY_STRING"];
        /*******************************************************************************
         * GOTO & ACTION
         * ****************************************************************************/
        if (isset($_GET['goto'])) {
            $controller = $this->datadecrypt($_GET['goto']);
            $controller = $this->convertToPascalCase($controller);
            if ($this->autoload($controller)) {
                $controller_object = new $controller();
                if (isset($_GET["action"])) {
                    $action = $this->datadecrypt($_GET["action"]);
                    $action = $this->convertToCamelCase($action);

                    if (method_exists($controller, $action)) {
                        $controller_object->$action();
                    } else {
                        echo "La page que vous recherchez n'existe pas. Veuillez revoir le chemin que vous avez entré:";
                        exit();
                    }
                } else {
                    require("../App/Views/error/404.phtml");
                    exit();
                }

            } else {
                require("../App/Views/error/404.phtml");
                exit();
            }
        }

        /*******************************************************************************
         * AJAX & ACTION
         * ****************************************************************************/

        if (isset($_GET['ajax'])) {
            $controller = $this->convertToPascalCase($_GET['ajax']);
            if ($this->autoload($controller)) {
                $controller_object = new $controller();
                if (isset($_GET["action"])) {
                    $action = $this->convertToCamelCase($_GET["action"]);

                    if (method_exists($controller, $action)) {
                        $controller_object->$action();
                    } else {
                        echo "La page que vous recherchez n'existe pas. Veuillez revoir le chemin que vous avez entré:";
                        exit;
                    }
                } else {
                    echo "action n'existe dans l'url";
                    exit;
                }

            } else {
                echo "Le controller n'existe pas";
                exit;
            }
        }

        if ($url === "") {
            $controller = "Home";
            $action = "viewHome";
            if ($this->autoload($controller)) {
                $controller_object = new $controller();
                $controller_object->$action();
            }
        }
    }
}