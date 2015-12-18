<?php

require_once('Model/UserModel.php');

/**
 * Created by PhpStorm.
 * User: natha
 * Date: 17.12.2015
 * Time: 19:01
 * Handles all things relevanted to users
 */
class UserController
{
    private $userModel;

    /**
     * UserController constructor.
     * creates the header
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
        $view = new View('header',array('title' => 'User - Overview', 'heading' => 'User'));
        $view->display();
    }

    /**
     * creates the user overview window
     */
    public function index() {
        $view = new View("UserOverview");
        $view->users = $this->userModel->readAll();
        $view->display();
    }

    /**
     * @param $id
     * deletes a user
     */
    public function delete($id) {
        $this->userModel->delete($id);
        $this->redirect('/user');
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