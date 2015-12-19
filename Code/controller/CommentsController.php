<?php

require_once('Model/CommentsModel.php');

/**
 * Created by PhpStorm.
 * User: Nathanael
 * Date: 12/10/2015
 * Time: 8:38 AM
 * Handles all Comment relevant things
 */

class CommentsController
{
    /**
     * CommentsController constructor.
     * creates the header
     */
    public function __construct()
    {
        $view = new View('header',array('title' => 'Comment', 'heading' => 'Comment'));
        $view->display();
    }

    /**
     * @param $blogId
     * isn't used by anything
     */
    public function index($blogId)
    {
        $commentsModel = new CommentsModel();
        $view = new View("comments");
        $view->comments = $commentsModel->readComments($blogId,$_SESSION['UserId']);
        $view->display();
    }

    /**
     * @param $id
     * creates a comment
     */
    public function create($id) {
        $commentsModel = new CommentsModel();
        $commentsModel->createComment($_POST['Text'],$id,$_SESSION['UserId']);
        $this->redirect('/Blog/read/'.$id);
        $_SESSION['message'] = array('success','Created comment','You have successfully created a comment.');
    }

    /**
     * @param $commentId
     * deletes a comment
     */
    public function delete($commentId,$blogId) {
        $commentsModel = new CommentsModel();
        $commentsModel->deleteComment($commentId);
        $this->redirect('/blog/read/'.$blogId);
        $_SESSION['message'] = array('success','Deletd comment','You have successfully deleted a comment.');
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