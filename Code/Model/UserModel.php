<?php

require_once('lib/Model.php');
require_once('Database.php');

/**
 * Created by PhpStorm.
 * User: natha
 * Date: 17.12.2015
 * Time: 19:03
 * handles all things which are related to users
 */
class UserModel
{
    /**
     * @return array
     * reads all users to list them in /user/index
     */
    public function readAll() {
        $db = new MyDB();

        $st = "";
        $sql =<<<EOF
                SELECT * FROM USERS ORDER BY Nickname ASC;
EOF;
        $st = $db->prepare($sql);
        $ret = $st->execute();
        $result = array();
        while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $result[] = array();
            $result[count($result)-1][] = $row['ID'];
            $result[count($result)-1][] = $row['Email'];
            $result[count($result)-1][] = $row['Nickname'];
            $result[count($result)-1][] = $row['Admin'];
        }

        $db->close();
        return $result;
    }

    /**
     * @param $id
     * @return SQLite3Result
     * deletes a user to give admins the oppurtinity to delete users
     */
    public function delete($id) {
        $db = new MyDB();
        $st = "";
        $sql =<<<EOF
                DELETE FROM USERS WHERE ID = ?;
EOF;
        $st = $db->prepare($sql);
        $st->bindParam(1,$id);
        $ret = $st->execute();

        return $ret;
    }
}