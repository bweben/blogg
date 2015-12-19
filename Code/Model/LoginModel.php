<?php

require_once('lib/Model.php');
require_once('Database.php');

/**
 * Created by PhpStorm.
 * User: Nathanael
 * Date: 12/3/2015
 * Time: 8:48 AM
 * handles all data things which are related to a login or sign up
 */
class LoginModel
{
    /**
     * @param $email
     * @param $nick
     * @return bool
     * checks if $email or $nick exists to avoid second sign up
     */
    public function exists($email,$nick){
        $email = htmlspecialchars($email);
        $nick = htmlspecialchars($nick);

        $db = new MyDB();
        $st = "";

        $sql =<<<EOF
                SELECT * FROM USERS WHERE Email LIKE ? OR Nickname LIKE ?;
EOF;
        $st = $db->prepare($sql);
        $st->bindParam(1,$email);
        $st->bindParam(2,$nick);
        $ret = $st->execute();
        $result = array();
        while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $result[] = $row['ID'];
            $result[] = $row['Email'];
            $result[] = $row['Nickname'];
            $result[] = $row['Admin'];
        }

        $db->close();
        return count($result) > 0;
    }

    /**
     * @param $id
     * @return array
     * reads users by there id
     * maybe isn't correct here because the better place is in the usermodel
     */
    public function readById($id) {
        $db = new MyDB();
        $st = "";

        $sql =<<<EOF
                SELECT * FROM USERS WHERE ID = ?;
EOF;
        $st = $db->prepare($sql);
        $st->bindParam(1,$id);
        $ret = $st->execute();
        $result = array();

        while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $result[] = $row['ID'];
            $result[] = $row['Email'];
            $result[] = $row['Nickname'];
            $result[] = $row['Admin'];
        }

        $db->close();
        return $result;
    }

    /**
     * @param $email
     * @param $password
     * @param string $nick
     * @return mixed
     * creates a user by the email, password and nickname,
     * the gender of the person isn't important
     */
    public function create($email, $password,$nick = "")
    {
        $email = htmlspecialchars($email);
        $nickname = $nick != "" ? htmlspecialchars($nick) : $email;
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

        //creates the session Admin entity
        $_SESSION['Admin'] = $admin == 1 ? true : false;

        return $this->login($email,$password);
    }

    /**
     * @param $email
     * @param $password1
     * @return mixed
     * checks if the user can safely log in
     */
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