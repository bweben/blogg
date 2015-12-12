<?php

require_once('lib/Model.php');
require_once('Database.php');

/**
 * Created by PhpStorm.
 * User: natha
 * Date: 12.12.2015
 * Time: 18:23
 */
class CategorieModel extends Model
{
    public function getId($categorie) {
        $this->chechEntities();
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

    public function chechEntities() {
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
}