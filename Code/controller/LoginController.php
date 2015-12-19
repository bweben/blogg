<?php

require_once('Model/LoginModel.php');

/**
 * Created by PhpStorm.
 * User: Nathanael
 * Date: 12/3/2015
 * Time: 8:34 AM
 * Handles all things which are Login / logout relevanted
 */
class LoginController
{
    /**
     * LoginController constructor.
     * creates the header
     */
    public function __construct()
    {
        $view = new View('header',array('warning' => 'Login', 'heading' => 'Login'));
        $view->display();
    }

    /**
     * @param $email
     * @return int
     * validates the email
     */
    public function emailValidation($email) {
        $regex = "/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i";
        if (preg_match($regex,$email)) {
            return true;
        } else {
            $_SESSION['message'] = array('danger','False email','You entered an incorrect email.');
            return false;
        }
    }

    /**
     * @param $nick
     * @return bool
     * checks if the nickname is valid
     */
    public function nickValidation($nick) {
        $regex = "/^[\d\w]{3,}$/i";
        if (preg_match($regex,$nick)) {
            return true;
        } else {
            $_SESSION['message'] = array('danger','False nickname','You entered an incorrect nickname.');
            return false;
        }
    }

    /**
     * creates the login/signup window if user not logged in
     */
    public function index()
    {
        if (isset($_SESSION['UserId'])) {
            $this->redirect('/Blog');
        }
        $loginModel = new LoginModel();
        $view = new View("index");
        $view->display();
    }

    /**
     * makes a login
     */
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
                $_SESSION['message'] = array('warning','Something happened...',
                    'There is an internal error, please try<a href="/">again</a>.');

            } else {
                $_SESSION['UserId'] = $userId;
                $_SESSION['UserName'] = $email;
                $_SESSION['message'] = array('success','Logged in','Yor are successfully logged in.');

                $this->redirect('/Blog/index');
            }

        } else {
            $_SESSION['message'] = array('warning','Something happened...',
                'There is an internal error, please try<a href="/">again</a>.');
            $this->redirect('/');
        }
    }

    /**
     * makes a logout and destroys the session
     */
    public function logout() {
        session_destroy();
        $this->redirect('/');
    }

    /**
     * creates a user
     */
    public function create() {
        $loginModel = new LoginModel();

        if (isset($_GET['username']) && isset($_GET['password1'])) {
            $email = $_GET['username'];
            $password1 = $_GET['password1'];
            $password2 = $_GET['password2'];
            $nick = $_GET['nickName'];

            if ($password1 == $password2 && !$loginModel->exists($email,$nick) && $this->emailValidation($email)
            && $this->nickValidation($nick)) {
                $userId = $loginModel->create($email,$password1,$nick);

                if ($userId != 0) {
                    $_SESSION['UserId'] = $userId;
                    $_SESSION['UserName'] = $email;
                    $_SESSION['message'] = array('success','Created User','Yor have successfully created an User.');

                    $this->redirect('/Blog/index');
                } else {
                    $_SESSION['message'] = array('warning','Something happened...',
                        'There is an internal error, please try<a href="/">again</a>.');
                }
            } else {
                $this->redirect('/');
                if (!isset($_SESSION['message'])) {
                    $_SESSION['message'] = array('info','Existing Username or Nick',
                        'You have an existing email or nickname, please <a href="/">login</a> instead.');
                }
            }

        }
    }

    /**
     * not relevant
     * used to test /user/index with many users
     */
    /*
    public function test() {
        $loginModel = new LoginModel();
        $hello = str_split("abcdefghijklmnopqrstuvwxyz");
        for($i = 0; $i < count($hello); $i++) {
            for ($j = 0; $j < count($hello); $j++) {
                $loginModel->create($hello[$j]."hallo@test.com","Welcome$15",$hello[$j]."test");
            }
        }
        $this->redirect('/user');
    }*/

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