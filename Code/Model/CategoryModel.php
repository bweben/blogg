<?php

require_once('lib/Model.php');
require_once('Database.php');

/**
 * Created by PhpStorm.
 * User: natha
 * Date: 17.12.2015
 * Time: 21:32
 * handles all data things which are related to categories
 */

class CategoryModel
{
    /**
     * @param $id
     * @return array
     * reads all blog entities which have a specific category id
     */
    public function read($id) {
        $db = new MyDB();
        $st = "";
        $sql =<<<EOF
                SELECT B.Titel as Titel, B.Text as Text, B.Date as Date, U.Email as Email, U.Nickname as Nick, C.Description as Descr, U.ID as UID, count(Co.ID) as Comments, B.ID as ID, C.ID as CID
                        FROM Blog as B JOIN Users as U ON B.UserId = U.ID JOIN Categorie as C ON B.CategorieID = C.ID LEFT JOIN Comments as Co ON B.ID = Co.BlogID WHERE CID = ? ORDER BY B.Date desc;
EOF;
        $st = $db->prepare($sql);
        $st->bindParam(1,$id);
        $ret = $st->execute();
        $result = array();

        // fetches the result to another array
        while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $result[] = array();
            $result[count($result)-1][] = $row['Titel'];
            $result[count($result)-1][] = $row['Text'];
            $result[count($result)-1][] = $row['Date'];
            $result[count($result)-1][] = $row['Email'];
            $result[count($result)-1][] = $row['Nick'];
            $result[count($result)-1][] = $row['Descr'];
            $result[count($result)-1][] = $row['UID'];
            $result[count($result)-1][] = $row['Comments'];
            $result[count($result)-1][] = $row['ID'];
            $result[count($result)-1][] = $row['CID'];
        }

        if (count($result) == 0) {
            $result = array();
        } else if (strlen($result[0][0]) == 0) {
            $result = array();
        }

        $db->close();
        return $result;
    }

    /**
     * @param $categorie
     * @return mixed
     * returns the id from a specific category (text)
     */
    public function getId($categorie) {
        $this->checkEntities();
        $db = new MyDB();
        $sql =<<<EOF
            SELECT ID FROM Categorie WHERE Description LIKE "$categorie";
EOF;
        $ret = $db->query($sql);

        $result = array();
        while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $result[] = $row['ID'];
        }

        $db->close();
        return $result[0];
    }

    /**
     * checks if all categories are in the database
     */
    public function checkEntities() {
        $db = new MyDB();
        $sql =<<<EOF
            SELECT count(ID) as Co FROM Categorie;
EOF;
        $ret = $db->query($sql);

        $result = array();
        while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $result[] = $row['Co'];
        }

        if ($result[0] < 5) {
            $sql =<<<EOF
                INSERT INTO Categorie (Description) VALUES ("Food"),("Art"),("Sport"),("Nature"),("Work");
EOF;
            $result = $db->exec($sql);
            if (!$result) {
                $db->lastErrorMsg();
            }

        }
        $db->close();
    }

    /**
     * @return array
     * reads all categories
     */
    public function readAll()
    {
        $db = new MyDB();
        $sql =<<<EOF
                SELECT Description FROM Categorie;
EOF;
        $st = $db->prepare($sql);
        $ret = $st->execute();
        $result = array();
        while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $result[] = $row['Description'];
        }
        $db->close();

        return $result;
    }
}