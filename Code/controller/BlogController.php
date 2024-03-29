<?php

require_once('model/BlogModel.php');
require_once('model/CategoryModel.php');
require_once('model/CommentsModel.php');

/**
 * Created by PhpStorm.
 * User: Nathanael
 * Date: 12/10/2015
 * Time: 8:38 AM
 * handles all things with Blogs like create / delete and more
 */

class BlogController
{
    /**
     * BlogController constructor.
     * creates the header with params
     */
    public function __construct()
    {
        $view = new View('header', array('title' => 'Blog - Overview', 'heading' => 'Blog'));
        $view->display();
    }

    /**
     * @return bool
     * checks if User is logged in,
     * else go to /Blog/index
     */
    public function checkLogin() {
        if (isset($_SESSION['UserId'])) {
            return true;
        } else {
            $this->redirect('/Blog/index');
            $_SESSION['message'] = array('warning','No permission','You have no permission to do this.');
            return false;
        }
    }

    /**
     * @param $userId
     * @return bool
     * checks if user has permission to delete
     */
    public function checkPermissionDel($userId) {
        return $_SESSION['UserId'] == $userId || $_SESSION['Admin'];
    }

    /**
     * @param $userId
     * @return bool
     * checks if user has permission to change
     */
    public function checkPermissionCha($userId) {
        return $_SESSION['UserId'] == $userId;
    }

    /**
     * @param int $userId
     * makes the Overview of all Blog Entities or
     * limited by the user
     */
    public function index($userId = 0,$page = 0) {
        $blogModel = new BlogModel();
        $view = new View("Overview");
        $view->blogs = $blogModel->read($userId,0,$page);
        $view->newBlog = "Create new Blog Entity";
        $view->page = $page;
        $view->user = $userId;
        $view->more = $blogModel->howMany($userId) - ($page+1) * 7 > 0;
        $view->display();
    }

    /**
     * Creates a new Blog Entity View
     */
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

    /**
     * @param $id
     * Reads a Blog Entity where the id is set
     * Gives a better view of the blog
     */
    public function read($id) {
        $blogModel = new BlogModel();
        $commentsModel = new CommentsModel();

        $view = new View("OverviewOwn");
        $view->blog = $blogModel->read(0,$id);
        $view->comments = $commentsModel->readComments($id);
        $view->display();
    }

    /**
     * Creates the Blog Entity
     */
    public function doCreate() {
        $blogModel = new BlogModel();
        $categorieModel = new CategoryModel();

        $categorieId = $categorieModel->getId($_POST['categorieId']);

        if ($this->checkLogin()) {
            if ($_POST['blogName'] != "" && $_POST['blogText'] != "" && $categorieId != "") {
                $blogModel->createBlog($_SESSION['UserId'],$_POST['blogName'],$_POST['blogText'],
                    $categorieId);
                $_SESSION['message'] = array('success','Created Blog Entity','You have successfully created a Blog Entity.');
            } else {
                $_SESSION['message'] = array('info','Something in the Blog Creation isn\'t correct.');
            }

        }

        $this->redirect('/Blog');
    }

    /**
     * @param $blogId
     * deletes a Blog Entity by the blogid
     */
    public function delete($blogId) {
        $blogModel = new BlogModel();
        if ($this->checkLogin() && $this->checkPermissionDel($blogModel->readById($blogId)[0][6])) {
            $blogModel->deleteBlog($blogId);
            $this->redirect('/');
            $_SESSION['message'] = array('success','Deleted Blog Entity','You have successfully deleted this Blog Entity.');
        } else {
            $_SESSION['message'] = array('warning','No permission','You have no permission to do this.');
        }
    }

    /**
     * @param $blogId
     * Uses the new Blog View to change a Blog Entity
     */
    public function change($blogId) {
        $blogModel = new BlogModel();
        if ($this->checkLogin() && $this->checkPermissionCha($blogModel->readById($blogId)[0][6])) {
            $categoryModel = new CategoryModel();
            $blog = $blogModel->read(0,$blogId);
            $view = new View("newBlog");
            $view->src = "/Blog/doChange/".$blogId;
            $view->blogName = $blog[0][0];
            $view->blogText = $blog[0][1];
            $view->category = $blog[0][5];
            $view->categories = $categoryModel->readAll();
            $view->display();
        } else {
            $_SESSION['message'] = array('warning','No permission','You have no permission to do this.');
        }
    }

    /**
     * @param $id
     * Changes effectifly a Blog
     */
    public function doChange($id) {
        if ($this->checkLogin()) {
            $categoryModel = new CategoryModel();
            $blogModel = new BlogModel();
            $blogModel->update($id,$_POST['blogName'],$_POST['blogText'],$categoryModel->getId($_POST['categorieId']));
            $_SESSION['message'] = array('success','Changed Blog Entity','You have successfully changed this Blog Entity.');
        }
        $this->redirect('/Blog/read/'.$id);
    }

    /**
     * @param $Id
     * @return string
     * used for ajax to give the values of e specific blog
     */
    public function readById($Id) {
        $blogModel = new BlogModel();
        return json_encode($blogModel->read(0,$Id));
    }

    /**
     * @param $url
     * only commented here
     * changes the url of the site to make a redirect to a specific url
     */
    function redirect($url)
    {
        $string = '<script type="text/javascript">';
        $string .= 'window.location = "' . $url . '"';
        $string .= '</script>';

        echo $string;
    }

    /**
     * is called when url isn't valid
     */
    public function notfound() {
        $view = new View('404');
        $view->display();
    }

    /**
     * Creates the footer
     */
    public function __destruct()
    {
        $view = new View('footer');
        $view->display();
    }
}