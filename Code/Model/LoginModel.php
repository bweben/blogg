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

    public function create($email, $password)
    {
        $email = htmlspecialchars($email);
        $nickname = $email;
        $admin = 0;

        if ($email == "admin@admin.ch") {
            $admin = 1;
        }

        $db = new MyDb();
        $sql =<<<EOF
			INSERT INTO Users (Email,Password,Nickname,Admin)
			VALUES ("$email","$password","$nickname",$admin);
EOF;

        $userId = $db->exec($sql);
        if (!$userId) {
            echo $db->lastErrorMsg();
        }

        $db->close();

        $_SESSION['Admin'] = $admin == 1 ? true : false;

        return $userId;
    }

    public function login($email, $password1)
    {
        $userId = 0;

        $email = htmlspecialchars($email);

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