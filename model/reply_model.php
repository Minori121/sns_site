<?php
function get_follow_reply_comment($dbh, $user_id) {
  $sql = 'SELECT
            sns_reply.id,
            sns_reply.reply_id,
            sns_reply.reply_comment,
            sns_reply.created reply_created,
            sns_reply.updated reply_updated,
            sns_user.user_id,
            sns_user.name,
            sns_user.name_id,
            sns_user.img
          FROM
            sns_reply
          INNER JOIN sns_user
          ON         sns_reply.user_id = sns_user.user_id
          WHERE (sns_reply.user_id = ? OR sns_reply.user_id IN (SELECT follow_user FROM sns_follow WHERE user_id = ?) )
          AND sns_reply.reply_id != 0
        ';
  return fetch_all_query($dbh, $sql, array($user_id, $user_id));
}

function insert_reply_comment($dbh, $comment_id, $reply_id, $user_id, $reply_comment, $created, $updated){
    $sql = 'INSERT INTO
                sns_reply(
                comment_id,
                reply_id,
                user_id,
                reply_comment,
                created,
                updated
                )
            VALUES(?, ?, ?, ?, ?, ?)';
            if($reply_id === '') { $reply_id = 0; }
            var_dump(array($comment_id, $reply_id, $user_id, $reply_comment, $created, $updated));
    return execute_query($dbh, $sql, array($comment_id, $reply_id, $user_id, $reply_comment, $created, $updated));
}

function get_reply($dbh, $reply_id) {
    $sql = 'SELECT
                sns_reply.id as reply_id,
                sns_reply.comment_id,
                sns_reply.reply_comment comment,
                sns_reply.created comment_created,
                sns_reply.updated comment_updated,
                sns_user.user_id,
                sns_user.name,
                sns_user.name_id,
                sns_user.img
            FROM
                    sns_reply
            INNER JOIN sns_user
            ON         sns_reply.user_id = sns_user.user_id
            WHERE
                    sns_reply.id = ?';
    return fetch_all_query($dbh, $sql, array($reply_id));
}



function update_reply_list($dbh, $comment_id, $updated) {
    $sql = 'UPDATE sns_reply
            SET    updated = ?
            WHERE  comment_id = ?';
    return execute_query($dbh, $sql, array($updated, $comment_id));
}

function delete_reply_comment($dbh, $null_id) {
    $sql = 'DELETE FROM sns_reply
            WHERE id = ?
            ';
    return execute_query($dbh, $sql, array($null_id));
}
