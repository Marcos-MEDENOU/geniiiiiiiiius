<?php
require_once('../App/Conf/Database.php');
require_once('../App/Models/Article.php');
class ArticleController
{
    use Crypt;
    // Déclaration des variables
    private $article, $id, $title, $image, $body, $code_html, $category_id, $user_id, $created_at;

    // Ajout des articles
    public function addArticles()
    {
        $datas = file_get_contents("php://input");
        $datas = json_decode($datas);
        $this->code_html = $datas->code_html;
        $this->category_id = $datas->category_id;
        $this->user_id = $datas->user_id;
        $this->created_at = date("Y-m-d h:i:s");
        var_dump($this->code_html);

        // instanciation de la classe model article
        $this->article = new Article();

        // Je vérifie si dans le code html on a un ou plusieurs éléments src
        preg_match_all("|src=(?<source>\"(.*)\")|U", $this->code_html, $matches_files, PREG_PATTERN_ORDER);
        var_dump($matches_files);
        $this->image = $matches_files["source"][0];
        echo json_encode($this->image);

        // Je vérifie si dans le code html on a un ou plusieurs éléments h2
        preg_match_all("|<h2>(?<title>(.*))</h2>|U", $this->code_html, $matches_title, PREG_PATTERN_ORDER);
        var_dump($matches_title);
        $this->title = $matches_title["source"][0];
        echo json_encode($this->title);

        // Je vérifie si dans le code html on a  un ou plusieurs éléments qui ne sont pas des balises contenues dans des balises p
        preg_match_all("|<p>(?<body>([a-zA-Z\s\d\-\/\.\;\?\,\+]+))</p>|U", $this->code_html, $matches_body, PREG_PATTERN_ORDER);
        var_dump($matches_body);
        $this->body = $matches_body["body"][0];
        echo json_encode($this->body);

        // Je vérifie si il y a un titre dans la bdd correspondant au nouveau qu'on veut insérer dans la bdd
        $array = $this->article->getTitlesArticle($this->title);
        var_dump($array);
        $count = count($array);
        if ($count > 0) {
            echo json_encode("Article_exist");
        } else {
            // Insertion de l'article
            $insert = $this->article->addArticle($this->image, $this->title, $this->body, $this->code_html, $this->category_id, $this->user_id, $this->created_at);
            if ($insert === true) {
                $controller = "?goto=" . $this->datacrypt('home');
                $action = "action=" . $this->datacrypt('dash');
                $url = $controller . "&" . $action;
                echo json_encode("$url");
            } else {
                echo json_encode("Erreur_subvenue");
            }
        }
    }

    // Suppression des articles one by one
    public function deleteOneArticle()
    {
        $datas = file_get_contents("php://input");
        $datas = json_decode($datas);
        $this->id = $datas->id;

        // instanciation de la classe model article
        $this->article = new Article();

        // Suppression d'un article
        $array = $this->article->deleteOneArticle($this->id);

        if ($array === true) {
            echo json_encode("supprime");
        } else {
            echo json_encode("Erreur_subvenue");
        }
    }

}