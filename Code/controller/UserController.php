<?php

require_once('Model/UserModel.php');

/**
 * Created by PhpStorm.
 * User: natha
 * Date: 17.12.2015
 * Time: 19:01
 */
class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $view = new View('header',array('title' => 'User - Overview', 'heading' => 'User'));
        $view->display();
    }

    public function index() {
        $view = new View("UserOverview");
        $view->users = $this->userModel->readAll();
        $view->display();
    }

    public function delete($id) {
        $this->userModel->delete($id);
        $this->redirect('/user');
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