<?php

require_once('lib/Model.php');
require_once('Model/LoginModel.php');
require_once('Database.php');

/**
 * Created by PhpStorm.
 * User: Nathanael
 * Date: 12/10/2015
 * Time: 8:38 AM
 * handles all data things which are related to comments
 */

class CommentsModel
{
    /**
     * @param $blogId
     * @param int $userId
     * @return array
     * reads all comments where the comment or and userid is like the specific
     */
    public function readComments($blogId, $userId = 0) {
        $db = new MyDB();
        $loginModel = new LoginModel();
        $st = "";

        if ($userId == 0) {
            $sql =<<<EOF
                    SELECT Text,Date,UserId as User,ID FROM Comments WHERE BlogId = ?;
EOF;
            $st = $db->prepare($sql);
            $st->bindParam(1,$blogId);

        } else {
            $sql =<<<EOF
                    SELECT Text,Date,UserId as User,ID FROM Comments WHERE BlogId = ? AND UserId = ?;
EOF;
            $st = $db->prepare($sql);
            $st->bindParam(1,$blogId);
            $st->bindParam(2,$userId);
        }

        $ret = $st->execute();
        $result = array();

        // fetchs the result array and makes a new to return
        while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $result[] = array();
            $result[count($result)-1][] = $row['Text'];
            $result[count($result)-1][] = $row['Date'];
            $result[count($result)-1][] = $row['User'];
            $result[count($result)-1][] = $loginModel->readById($row['User'])[2];
            $result[count($result)-1][] = $row['ID'];
        }

        $db->close();
        return $result;
    }

    /**
     * @param $text
     * @param $blogId
     * @param $UserId
     * creates a new comment
     */
    public function createComment($text, $blogId, $UserId)
    {
        $text = htmlspecialchars($text);
        $date = time();

        $db = new MyDB();
        $sql = "";

        $sql =<<<EOF
                    INSERT INTO Comments (UserId,BlogId,Text,Date) VALUES
                    ($UserId,$blogId,'$text','$date');
EOF;
        $ret = $db->exec($sql);
        if (!$ret) {
            echo $db->lastErrorMsg();
        }

        $db->close();
    }

    /**
     * @param $id
     * delete a comment by his id
     */
    public function deleteComment($id) {
        $db = new MyDB();
        $sql = "";

        $sql =<<<EOF
                    DELETE FROM Comments WHERE ID = $id;
EOF;
        $ret = $db->exec($sql);
        if (!$ret) {
            echo $db->lastErrorMsg();
        }

        $db->close();
    }
}