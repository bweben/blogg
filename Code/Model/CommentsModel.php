<?php

require_once('lib/Model.php');
require_once('Database.php');

/**
 * Created by PhpStorm.
 * User: Nathanael
 * Date: 12/10/2015
 * Time: 8:38 AM
 */

class CommentsModel
{
    public function readComments($blogId, $userId = 0) {
        $db = new MyDB();
        $sql = "";

        if ($userId == 0) {
            $sql =<<<EOF
                    SELECT Text,Date FROM Comments WHERE BlogId = '$blogId';
EOF;
        } else {
            $sql =<<<EOF
                    SELECT Text,Date FROM Comments WHERE BlogId = '$blogId' AND UserId = '$userId';
EOF;
        }

        $ret = $db->query($sql);
        $result = array();

        while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $result[] = array();
            $result[count($result)-1][] = $row['Text'];
            $result[count($result)-1][] = $row['Date'];
        }

        $db->close();
        return $result;
    }

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