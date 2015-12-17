<?php

require_once('Model/CommentsModel.php');

/**
 * Created by PhpStorm.
 * User: Nathanael
 * Date: 12/10/2015
 * Time: 8:38 AM
 */

class CommentsController
{
    public function __construct()
    {
        $view = new View('header',array('title' => 'Comment', 'heading' => 'Comment'));
        $view->display();
    }

    public function index($blogId)
    {
        $commentsModel = new CommentsModel();
        $view = new View("comments");
        $view->comments = $commentsModel->readComments($blogId,$_SESSION['UserId']);
        $view->display();
    }

    public function create($id) {
        $commentsModel = new CommentsModel();
        $commentsModel->createComment($_POST['Text'],$id,$_SESSION['UserId']);
        $this->redirect('/Blog/read/'.$id);
    }

    public function delete($commentId) {
        $commentsModel = new CommentsModel();
        $commentsModel->deleteComment($commentId);
        $this->redirect('/Blog/index');
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