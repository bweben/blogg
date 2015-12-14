<?php

require_once('lib/Model.php');
require_once('Database.php');

/**
 * Created by PhpStorm.
 * User: Nathanael
 * Date: 12/3/2015
 * Time: 8:48 AM
 */
class LoginModel
{

    public function create($email, $password,$nick = "")
    {
        $email = htmlspecialchars($email);
        $nickname = $nick != "" ? $nick : $email;
        $admin = 0;
        $password2 = md5($password);

        if ($email == "admin@admin.ch") {
            $admin = 1;
        }

        $db = new MyDb();
        $sql =<<<EOF
			INSERT INTO Users (Email,Password,Nickname,Admin)
			VALUES ("$email","$password2","$nickname",$admin);
EOF;

        $userId = $db->exec($sql);
        if (!$userId) {
            echo $db->lastErrorMsg();
        } else {

        }

        $db->close();

        $_SESSION['Admin'] = $admin == 1 ? true : false;

        return $this->login($email,$password);
    }

    public function login($email, $password1)
    {
        $userId = 0;

        $email = htmlspecialchars($email);
        $password1 = md5($password1);

        $db = new MyDB();

        if(!$db) {
            echo $db->lastErrorMsg();
        }

        $sql =<<<EOF
                    SELECT ID,Admin FROM USERS WHERE EMAIL = '$email' AND PASSWORD = '$password1';
EOF;
        $ret = $db->query($sql);

        $result = array();
        while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $result[] = $row['ID'];
            $result[] = $row['Admin'];
        }

        if ($result[1] == 1) {
            $_SESSION['Admin'] = true;
        } else {
            $_SESSION['Admin'] = false;
        }

        return $userId = $result[0];
    }
}