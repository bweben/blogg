<?php

require_once('Model/CategoryModel.php');

/**
 * Created by PhpStorm.
 * User: natha
 * Date: 17.12.2015
 * Time: 21:31
 */
class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $view = new View('header',array('title' => 'Category - Overview', 'heading' => 'Category'));
        $view->display();
    }

    public function index($id) {
        $view = new View("Overview");
        $view->blogs = $this->categoryModel->read($id);
        $view->newBlog = "Create new Blog";
        $view->display();
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