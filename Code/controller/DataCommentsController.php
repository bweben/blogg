<?php

require_once('Model/CommentsModel.php');

/**
 * Created by PhpStorm.
 * User: natha
 * Date: 15.12.2015
 * Time: 22:19
 * Handles ajax events on comments
 */
class DataCommentsController
{
    /**
     * @param int $id
     * reads comment with a specific blogid
     */
    public function read($id = 0) {
        $commentsModel = new CommentsModel();
        $comments = $commentsModel->readComments($id,0);
        $comments[] = $id;
        echo json_encode($comments);
    }
}