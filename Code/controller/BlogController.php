<?php

require_once('model/BlogModel.php');
require_once('model/CategorieModel.php');

/**
 * Created by PhpStorm.
 * User: Nathanael
 * Date: 12/10/2015
 * Time: 8:38 AM
 */

class BlogController
{
    public function __construct()
    {
        $view = new View('header', array('title' => 'Blog', 'heading' => 'Blog'));
        $view->display();
    }

    public function index() {
        $blogModel = new BlogModel();
        $view = new View("Overview");
        $view->blogs = $blogModel->read();
        $view->newBlog = "Create new Blog";
        $view->display();
    }

    public function create() {
        $view = new View("newBlog");
        $view->display();
    }

    public function doCreate() {
        $blogModel = new BlogModel();
        $categorieModel = new CategorieModel();

        $categorieId = $categorieModel->getId($_POST['categorieId']);

        if ($_SESSION['UserId']) {
            if ($_POST['blogName'] != "") {
                $blogModel->createBlog($_SESSION['UserId'],$_POST['blogName'],$_POST['blogText'],
                    $categorieId);
            }

        }

        //$this->redirect('/Blog');
    }

    public function delete($blogId) {
        $blogModel = new BlogModel();
        $blogModel->deleteBlog($blogId);
    }

    function redirect($url)
    {
        $string = '<script type="text/javascript">';
        $string .= 'window.location = "' . $url . '"';
        $string .= '</script>';

        echo $string;
    }

    public function __destruct()
    {
        $view = new View('footer');
        $view->display();
    }
}