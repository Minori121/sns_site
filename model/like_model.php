<?php
function insert_sns_like($dbh, $user_id, $comment_id, $created, $updated) {
    $sql = 'INSERT INTO
                sns_like(
                user_id,
                comment_id,
                created,
                updated)
            VALUES(?, ?, ?, ?)';
    return execute_query($dbh, $sql, array($user_id, $comment_id, $created, $updated));
}

function get_user_like($dbh, $user_id) {
        $sql = "SELECT
                    user_id,
                    comment_id
                FROM
                    sns_like
                WHERE
                    user_id = ?";
        return fetch_all_query($dbh, $sql, array($user_id));
}

function check_like($comment_id) {
    global $err_msg;

    if($comment_id === '') {
        $err_msg[] = '不適切な処理です';
    }
}
