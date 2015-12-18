<?php

require_once('model/BlogModel.php');
require_once('model/CategoryModel.php');
require_once('model/CommentsModel.php');

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
        $view = new View('header', array('title' => 'Blog - Overview', 'heading' => 'Blog'));
        $view->display();
    }

    public function checkLogin() {
        if (isset($_SESSION['UserId'])) {
            return true;
        } else {
            $this->redirect('/Blog/index');
            return false;
        }
    }

    public function checkPermissionDel($userId) {
        return $_SESSION['UserId'] == $userId || $_SESSION['Admin'];
    }

    public function checkPermissionCha($userId) {
        return $_SESSION['UserId'] == $userId;
    }

    public function index($userId = 0) {
        $blogModel = new BlogModel();
        $view = new View("Overview");
        $view->blogs = $blogModel->read($userId);
        $view->newBlog = "Create new Blog";
        $view->display();
    }

    public function create() {
        if ($this->checkLogin()) {
            $categoryModel = new CategoryModel();
            $view = new View("newBlog");
            $view->src = "/Blog/doCreate";
            $view->blogName = "";
            $view->blogText = "";
            $view->categories = $categoryModel->readAll();
            $view->display();
        } else {
            $this->redirect('/');
        }
    }

    public function read($id) {
        $blogModel = new BlogModel();
        $commentsModel = new CommentsModel();

        $view = new View("OverviewOwn");
        $view->blog = $blogModel->read(0,$id);
        $view->comments = $commentsModel->readComments($id);
        $view->display();
    }

    public function doCreate() {
        $blogModel = new BlogModel();
        $categorieModel = new CategoryModel();

        $categorieId = $categorieModel->getId($_POST['categorieId']);

        if ($this->checkLogin()) {
            if ($_POST['blogName'] != "" && $_POST['blogText'] != "" && $categorieId != "") {
                $blogModel->createBlog($_SESSION['UserId'],$_POST['blogName'],$_POST['blogText'],
                    $categorieId);
            }

        }

        $this->redirect('/Blog');
    }

    public function delete($blogId) {
        if ($this->checkLogin()) {
            $blogModel = new BlogModel();
            $blogModel->deleteBlog($blogId);
        }
    }

    public function change($blogId) {
        if ($this->checkLogin()) {
            $blogModel = new BlogModel();
            $categoryModel = new CategoryModel();
            $blog = $blogModel->read(0,$blogId);
            $view = new View("newBlog");
            $view->src = "/Blog/doChange/".$blogId;
            $view->blogName = $blog[0][0];
            $view->blogText = $blog[0][1];
            $view->category = $blog[0][5];
            $view->categories = $categoryModel->readAll();
            $view->display();
        }
    }

    public function doChange($id) {
        if ($this->checkLogin()) {
            $categoryModel = new CategoryModel();
            $blogModel = new BlogModel();
            $blogModel->update($id,$_POST['blogName'],$_POST['blogText'],$categoryModel->getId($_POST['categorieId']));
        }
        $this->redirect('/Blog/read/'.$id);
    }

    public function readById($Id) {
        $blogModel = new BlogModel();
        return json_encode($blogModel->read(0,$Id));
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