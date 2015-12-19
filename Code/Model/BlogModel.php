<?php

require_once('lib/Model.php');
require_once('Database.php');

/**
 * Created by PhpStorm.
 * User: Nathanael
 * Date: 12/10/2015
 * Time: 8:38 AM
 * Handles all data requests of the Blog
 */

class BlogModel extends Model
{
    /**
     * @param int $userId
     * @param int $blogId
     * @return array
     * reads blog entities with a specific userid or blogid given
     */
    public function read($userId = 0,$blogId = 0,$page = 0) {
        $db = new MyDB();
        $st = "";

        if ($blogId != 0) {
            $sql = <<<EOF
                        SELECT B.Titel as Titel, B.Text as Text, B.Date as Date, U.Email as Email, U.Nickname as Nick, C.Description as Descr, U.ID as UID, count(Co.ID) as Comments, B.ID as ID, C.ID as CID
                        FROM Blog as B JOIN Users as U ON B.UserId = U.ID JOIN Categorie as C ON B.CategorieID = C.ID LEFT JOIN Comments as Co ON B.ID = Co.BlogID WHERE B.ID = ? ORDER BY B.Date desc;
EOF;
            $st = $db->prepare($sql);
            $st->bindParam(1,$blogId);
        } elseif ($userId == 0 && $blogId == 0) {
            $sql = <<<EOF
                        SELECT B.Titel as Titel, B.Text as Text, B.Date as Date, U.Email as Email, U.Nickname as Nick, C.Description as Descr, U.ID as UID, count(Co.ID) as Comments, B.ID as ID, C.ID as CID
                        FROM Blog as B JOIN Users as U ON B.UserId = U.ID JOIN Categorie as C ON B.CategorieID = C.ID LEFT JOIN Comments as Co ON B.ID = Co.BlogID GROUP BY B.ID ORDER BY B.Date desc LIMIT 7 OFFSET ?;
EOF;
            $st = $db->prepare($sql);
            $page = $page * 7;
            $st->bindParam(1,$page);
        } else {
            $sql = <<<EOF
                        SELECT B.Titel as Titel, B.Text as Text, B.Date as Date, U.Email as Email, U.Nickname as Nick, C.Description as Descr, U.ID as UID, count(Co.ID) as Comments, B.ID as ID, C.ID as CID
                        FROM Blog as B JOIN Users as U ON B.UserId = U.ID JOIN Categorie as C ON B.CategorieID = C.ID LEFT JOIN Comments as Co ON B.ID = Co.BlogID WHERE U.ID = ? GROUP BY B.ID ORDER BY B.Date desc LIMIT 7 OFFSET ?;
EOF;
            $st = $db->prepare($sql);
            $page = $page * 7;
            $st->bindParam(1,$userId);
            $st->bindParam(2,$page);
        }

        $ret = $st->execute();
        $result = array();

        if (!$ret) {
            echo $db->lastErrorMsg();
        }

        // goes through all rows in the query and sets the specific to an array
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
     * @param int $userId
     * @return array
     * used to read only title and date of an blog entity or blog entites
     */
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

    /**
     * @param $UserId
     * @param $blogName
     * @param $blogText
     * @param $categorieId
     * creates a blog entity
     */
    public function createBlog($UserId, $blogName,$blogText,$categorieId)
    {
        $blogName = htmlspecialchars($blogName);
        $blogText = htmlspecialchars($blogText);
        $dateNow = time();

        $db = new MyDB();
        $sql = "";

        $sql =<<<EOF
                    INSERT INTO BLOG (UserId,Titel,Text,Date,CategorieID) VALUES (?,?,
                    ?,?,?);
EOF;

        $st = $db->prepare($sql);
        $st->bindParam(1,$UserId);
        $st->bindParam(2,$blogName);
        $st->bindParam(3,$blogText);
        $st->bindParam(4,$dateNow);
        $st->bindParam(5,$categorieId);
        $ret = $st->execute();

        if (!$ret) {
            echo $db->lastErrorMsg();
        }

        $db->close();
    }

    /**
     * @param $id
     * deletes a blog
     */
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

    /**
     * @param $id
     * @return array
     * reads a blog entity by the id
     * calls the read method
     */
    public function readById($id)
    {
        return $this->read(0,$id);
    }

    /**
     * @param $id
     * @param $blogName
     * @param $blogText
     * @param $categorieId
     * update method, called by the change method in the blog controller
     */
    public function update($id, $blogName, $blogText, $categorieId)
    {
        $db = new MyDB();
        $st = "";

        $sql =<<<EOF
                UPDATE Blog SET Titel = ?, Text = ?, CategorieID = ? WHERE ID = ?;
EOF;
        $st = $db->prepare($sql);
        $st->bindParam(1,$blogName);
        $st->bindParam(2,$blogText);
        $st->bindParam(3,$categorieId);
        $st->bindParam(4,$id);
        $ret = $st->execute();
        if (!$ret) {
            echo $db->lastErrorMsg();
        }
        $db->close();
    }

    /**
     * @param int $userId
     * @return int
     * checks how many
     */
    public function howMany($userId = 0) {
        $db = new MyDB();

        $sql =<<<EOF
                SELECT count(*) as number FROM Blog
EOF;
        $sql .= $userId == 0 ? ";" : " WHERE UserID = ?;";
        $st = $db->prepare($sql);
        if ($userId != 0) {$st->bindParam(1,$userId);}
        $ret = $st->execute();
        $result = array();
        while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $result[] = $row['number'];
        }
        $db->close();
        return $result[0];
    }
}