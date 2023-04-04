<?php
require_once('../App/Conf/Database.php');
require_once('../App/Models/Category.php');

class CategoryController
{
    use Crypt;
    private $category;
    // déclaration des variables
    private $id, $category_name, $category_description;

    // Vérifie si les champs sont remplis
    public function verifyInputs()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->category_name = $this->sanitaze($data->category_name);
        $this->category_description = $data->category_description;
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
     * emptyInputs(), pour vérifiez si un des champs est vide
     */
    public function emptyInputs()
    {
        if (empty($this->category_name) || empty($this->category_description)) {
            echo json_encode("empty_input");
        } else {
            echo json_encode("valid_input");
        }
    }

    // Ajoute les catégories dans la table catégories
    public function addCategory()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->category = new Category();
        $this->category_name = $this->sanitaze($data->category_name);
        $this->category_description = nl2br($data->category_description);
        $array = $this->category->searchCategory($this->category_name);
        if (count($array) > 0) {
            echo json_encode("exist");
        } else {
            $this->category->addCategory($this->category_name, $this->category_description);
            $controller = "?goto=" . $this->datacrypt('dashboard');
            $action = "action=" . $this->datacrypt('category');
            $url = $controller . "&" . $action;
            echo json_encode("$url");
        }
    }

    // Affiche toutes les catégories
    public function allCategories()
    {
        $this->category = new Category();
        $array = $this->category->allCategories();
        return $array;
    }

    // Suppression d'une catégorie
    public function deleteOneCategory()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->id = $this->sanitaze($data->id);
        $this->category = new Category();
        $delete_cat = $this->category->deleteOneCategory($this->id);
    }
}