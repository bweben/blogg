<?php

require_once('Model/LoginModel.php');

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
        if (isset($_SESSION['UserId'])) {
            $this->redirect('/Blog');
        }
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
            $userId = $loginModel->login($email,$password);

            if ($userId == 0) {
                $this->redirect('/');
            } else {
                $_SESSION['UserId'] = $userId;
                $_SESSION['UserName'] = $email;

                $this->redirect('/Blog/index');
            }

        } else {
            $this->redirect('/');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('/');
    }

    public function create() {
        $loginModel = new LoginModel();

        if (isset($_GET['username']) && isset($_GET['password1'])) {
            $email = $_GET['username'];
            $password1 = $_GET['password1'];
            $password2 = $_GET['password2'];
            $nick = $_GET['nickName'];

            if ($password1 == $password2) {
                $userId = 0;
                $userId = $loginModel->create($email,$password1,$nick);

                if ($userId != 0) {
                    $_SESSION['UserId'] = $userId;
                    $_SESSION['UserName'] = $email;

                    $this->redirect('/Blog/index');
                }
            }

        }
    }

    public function test() {
        $loginModel = new LoginModel();
        $hello = str_split("abcdefghijklmnopqrstuvwxyz");
        for($i = 0; $i < count($hello); $i++) {
            for ($j = 0; $j < count($hello); $j++) {
                $loginModel->create($hello[$j]."hallo@test.com","Welcome$15",$hello[$j]."test");
            }
        }
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