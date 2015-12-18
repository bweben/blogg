<?php

require_once('Model/CategoryModel.php');

/**
 * Created by PhpStorm.
 * User: natha
 * Date: 17.12.2015
 * Time: 21:31
 * Handles all Category requests
 */
class CategoryController
{
    private $categoryModel;

    /**
     * CategoryController constructor.
     * creates the header
     */
    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $view = new View('header',array('title' => 'Category - Overview', 'heading' => 'Category'));
        $view->display();
    }

    /**
     * @param $id
     * Makes possible to click on a category badge to make a sort
     */
    public function index($id) {
        $view = new View("Overview");
        $view->blogs = $this->categoryModel->read($id);
        $view->category = $id;
        $view->newBlog = "Create new Blog";
        $view->display();
    }

    /**
     * @param $url
     */
    function redirect($url)
    {
        $string = '<script type="text/javascript">';
        $string .= 'window.location = "' . $url . '"';
        $string .= '</script>';

        echo $string;
    }

    /**
     * creates the footer
     */
    public function __destruct()
    {
        $view = new View('footer');
        $view->display();
    }
}