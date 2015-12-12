<?php

require_once('model/LoginModel.php');

/**
 * Created by PhpStorm.
 * User: Nathanael
 * Date: 12/3/2015
 * Time: 8:34 AM
 */
class LoginController
{
    public function __construct()
    {
        $view = new View('header',array('title' => 'Login', 'heading' => 'Login'));
        $view->display();
    }

    public function index()
    {
        $loginModel = new LoginModel();
        $view = new View("main");
        $view->display();
    }

    public function login() {
        $loginModel = new LoginModel();

        if (strlen($_GET['password2']) > 0) {
            $this->create();
        } elseif (isset($_GET['username']) && isset($_GET['password1'])) {

            $email = $_GET['username'];
            $password = $_GET['password1'];
            $userId = $loginModel->login($email,$password) != 0;

            if ($userId == 0) {
                $this->redirect('/');
            } else {
                $_SESSION['UserId'] = $userId;
                $this->redirect('/Blog/index');
            }

        } else {
            $this->redirect('/');
        }
    }

    public function create() {
        $loginModel = new LoginModel();

        if (isset($_GET['username']) && isset($_GET['password1'])) {
            $email = $_GET['username'];
            $password1 = $_GET['password1'];
            $password2 = $_GET['password2'];

            if ($password1 == $password2) {
                $userId = 0;
                $userId = $loginModel->create($email,$password1);

                if ($userId != 0) {
                    $_SESSION['UserId'] = $userId;
                    $this->redirect('/Blog/index');
                }
            }

        }
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