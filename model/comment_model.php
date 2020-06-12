<?php
// function get_follow_comment_list($dbh, $user_id) {
//         $sql = 'SELECT
//                     sns_comment.id,
//                     sns_comment.comment_id,
//                     sns_comment.post_num,
//                     sns_comment.user_id,
//                     sns_comment.comment,
//                     sns_comment.created,
//                     sns_user.name,
//                     sns_user.id,
//                     sns_user.img
//                 FROM
//                     sns_comment
//                 INNER JOIN sns_user
//                 ON         sns_comment.user_id = sns_user.user_id
//                 WHERE
//                     sns_comment.user_id = ?
//                 OR sns_comment.user_id IN (SELECT follow_user FROM sns_follow WHERE user_id = ?)
//                 ORDER BY sns_comment.created DESC
//                 ';
//         return fetch_all_query($dbh, $sql, array($user_id, $user_id));

// }

function get_my_all_comment($dbh, $user_id) {
    $sql = 'SELECT
                sns_comment.comment_id,
                sns_comment.user_id,
                sns_comment.comment,
                sns_comment.created,
                sns_user.name,
                sns_user.name_id,
                sns_user.img
                FROM
                    sns_comment
                INNER JOIN sns_user
                ON         sns_comment.user_id = sns_user.user_id
                WHERE
                    sns_comment.user_id = ?
                ORDER BY
                    created DESC';
    return fetch_all_query($dbh, $sql, array($user_id));
}

// function get_follow_comment_list_union($dbh, $user_id) {
//         $sql = 'SELECT
//                     sns_comment.null_id,
//                     sns_comment.comment_id,
//                     sns_comment.reply_id,
//                     sns_comment.post_num,
//                     sns_comment.user_id,
//                     sns_comment.comment,
//                     sns_comment.created,
//                     sns_comment.updated,
//                     sns_user.name,
//                     sns_user.name_id,
//                     sns_user.img
//                 FROM
//                     sns_comment
//                 INNER JOIN sns_user
//                 ON         sns_comment.user_id = sns_user.user_id
//                 WHERE
//                     sns_comment.user_id = ?
//                 OR sns_comment.user_id IN (SELECT follow_user FROM sns_follow WHERE user_id = ?)
//                 UNION ALL
//                 SELECT
//                     sns_reply.id,
//                     sns_reply.comment_id,
//                     sns_reply.reply_id,
//                     sns_reply.post_num,
//                     sns_reply.user_id,
//                     sns_reply.reply_comment,
//                     sns_reply.created,
//                     sns_reply.updated,
//                     sns_user.name,
//                     sns_user.name_id,
//                     sns_user.img
//                 FROM
//                     sns_reply
//                 INNER JOIN sns_user
//                 ON sns_reply.user_id = sns_user.user_id
//                 WHERE
//                     sns_reply.user_id = ?
//                 OR sns_reply.user_id IN (SELECT follow_user FROM sns_follow WHERE user_id = ?)
//                 ORDER BY updated DESC, comment_id DESC, post_num
//                 ';
//         return fetch_all_query($dbh, $sql, array($user_id, $user_id, $user_id, $user_id));
// }

function get_follow_comment_list_join($dbh, $user_id) {
  $sql = 'SELECT
            sns_comment.comment_id,
            sns_comment.comment,
            sns_comment.created as comment_created,
            sns_comment.updated as comment_updated,
            sns_reply.id,
            sns_reply.reply_id,
            sns_reply.reply_comment,
            sns_reply.created as reply_created,
            sns_reply.updated as reply_updated,
            sns_user_comment.user_id as comment_user_id,
            sns_user_comment.name as comment_name,
            sns_user_comment.name_id as comment_name_id,
            sns_user_comment.img as comment_img,
            sns_user_reply.user_id as reply_user_id,
            sns_user_reply.name as reply_name,
            sns_user_reply.name_id as reply_name_id,
            sns_user_reply.img as reply_img
          FROM
            sns_comment
          LEFT JOIN sns_reply
          ON         sns_comment.comment_id = sns_reply.comment_id
          INNER JOIN sns_user as sns_user_comment
          ON         sns_comment.user_id = sns_user_comment.user_id
          LEFT JOIN sns_user as sns_user_reply
          ON         sns_reply.user_id = sns_user_reply.user_id
          WHERE (sns_comment.user_id = ? OR sns_comment.user_id IN (SELECT follow_user FROM sns_follow WHERE user_id = ?) )
          AND (sns_reply.reply_id = 0 OR sns_reply.reply_id is null)
        ';
  return fetch_all_query($dbh, $sql, array($user_id, $user_id));
}


function get_reply_comment($dbh, $comment_id) {
    $sql = 'SELECT
                sns_comment.comment_id,
                sns_comment.comment,
                sns_comment.created comment_created,
                sns_comment.updated comment_updated,
                sns_user.user_id,
                sns_user.name,
                sns_user.name_id,
                sns_user.img
            FROM
                    sns_comment
            INNER JOIN sns_user
            ON         sns_comment.user_id = sns_user.user_id
            WHERE
                    sns_comment.comment_id = ?
            ';
    return fetch_all_query($dbh, $sql, array($comment_id));
}

function insert_comment($dbh, $user_id, $comment, $created, $updated) {
    $sql = 'INSERT INTO
                sns_comment(
                user_id,
                comment,
                created,
                updated
                )
            VALUES(?, ?, ?, ?)';
    return execute_query($dbh, $sql, array($user_id, $comment, $created, $updated));
}

function update_comment_id($dbh, $comment_id) {
    $sql = 'UPDATE sns_comment
            SET    comment_id = ?,
                   post_num = 1
            WHERE  id = ?';
    return execute_query($dbh, $sql, array($comment_id, $comment_id));
}

function update_comment_list($dbh, $comment_id, $updated) {
    $sql = 'UPDATE sns_comment
            SET    updated = ?
            WHERE  comment_id = ?';
    return execute_query($dbh, $sql, array($updated, $comment_id));
}

function delete_comment($dbh, $comment_id) {
    $sql = 'DELETE FROM sns_comment
            WHERE comment_id = ?
            ';
    return execute_query($dbh, $sql, array($comment_id));
}

function check_comment($comment) {
    global $err_msg;

    if($comment === '') {
        $err_msg[] = 'コメントを入力してください';
    } else if(mb_strlen($comment) > '140') {
        $err_msg[] = 'コメントは140文字以内で入力してください';
    }
}

function sortByKey($key_name, $sort_order, $array) {
    foreach ($array as $key => $value) {
        $standard_key_array[$key] = $value[$key_name];
    }

    array_multisort($standard_key_array, $sort_order, $array);

    return $array;
}
