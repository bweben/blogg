<?php

require_once('lib/Model.php');
require_once('Database.php');

/**
 * Created by PhpStorm.
 * User: Nathanael
 * Date: 12/10/2015
 * Time: 8:38 AM
 */

class BlogModel extends Model
{
    public function read($userId = 0) {
        $db = new MyDB();
        $sql = "";

        if ($userId == 0) {
            $sql = <<<EOF
                        SELECT B.Titel as Titel, B.Text as Text, B.Date as Date, U.Email as Email, U.Nickname as Nick, C.Description as Descr, U.ID as UID
                        FROM Blog as B JOIN Users as U ON B.UserId = U.ID JOIN Categorie as C ON B.CategorieID = C.ID ORDER BY B.Date desc;
EOF;
        } else {
            $sql = <<<EOF
                        SELECT B.Titel as Titel, B.Text as Text, B.Date as Date, U.Email as Email, U.Nickname as Nick, C.Description as Descr, U.ID as UID
                        FROM Blog as B JOIN Users as U ON B.UserId = U.ID JOIN Categorie as C ON B.CategorieID = C.ID WHERE UserID = '$userId' ORDER BY B.Date desc;
EOF;
        }

        $ret = $db->query($sql);
        $result = array();

        if (!$ret) {
            echo $db->lastErrorMsg();
        }

        while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $result[] = array();
            $result[count($result)-1][] = $row['Titel'];
            $result[count($result)-1][] = $row['Text'];
            $result[count($result)-1][] = $row['Date'];
            $result[count($result)-1][] = $row['Email'];
            $result[count($result)-1][] = $row['Nick'];
            $result[count($result)-1][] = $row['Descr'];
            $result[count($result)-1][] = $row['UID'];
        }

        $db->close();
        return $result;
    }

    public function readTitleDate($userId = 0) {
        $db = new MyDb();
        $sql = "";

        if ($userId == 0) {
            $sql =<<<EOF
                        SELECT Titel, Date FROM BLOG;
EOF;
        } else {
            $sql =<<<EOF
                        SELECT Titel, Date FROM BLOG WHERE UserID = '$userId';
EOF;
        }

        $ret = $db->query($sql);
        $result = array();

        while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $result[] = array();
            $result[count($result)-1][] = $row['Titel'];
            $result[count($result)-1][] = $row['Date'];
        }

        return $result;
    }

    public function createBlog($UserId, $blogName,$blogText,$categorieId)
    {
        $blogName = htmlspecialchars($blogName);
        $blogText = htmlspecialchars($blogText);
        $dateNow = time();

        $db = new MyDB();
        $sql = "";

        $sql =<<<EOF
                    INSERT INTO BLOG (UserId,Titel,Text,Date,CategorieID) VALUES ($UserId,'$blogName',
                    '$blogText','$dateNow',$categorieId);
EOF;

        $ret = $db->exec($sql);

        if (!$ret) {
            echo $db->lastErrorMsg();
        }

        $db->close();
    }

    public function deleteBlog($id) {
        $db = new MyDB();
        $sql = "";

        $sql =<<<EOF
                    DELETE FROM BLOG WHERE ID = $id;
EOF;

        $ret = $db->exec($sql);

        if (!$ret) {
            echo $db->lastErrorMsg();
        }

        $db->close();
    }
}