<?php
require_once("../App/Controllers/crypt.php");
require_once("../App/Controllers/CategoryController.php");
class Dashboard {
    use Crypt;
    use AdresseIp;

 
    public function category()
    {
        $categories = new CategoryController();
        $allCategories = $categories->allCategories();
        require_once("../App/Views/admin/category_page.phtml");
    }
    public function users()
    {
        require_once("../App/Views/admin/Users.phtml");
    }
    public function articles()
    {
        $categories = new CategoryController();
        $allCategories = $categories->allCategories();
        require_once("../App/Views/admin/articles.phtml");
    }
    public function editor()
    {
       
        require_once("../App/Views/admin/editor.phtml");
    }
   
}