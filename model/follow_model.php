<?php
function get_follow_list($dbh, $user_id) {
    $sql = 'SELECT
                user_id,
                follow_user
            FROM
                sns_follow
            WHERE
                user_id = ?
            ';
    return fetch_all_query($dbh, $sql, array($user_id));
}

function get_follower_list($dbh, $user_id) {
    $sql = 'SELECT
                user_id,
                follow_user
            FROM
                sns_follow
            WHERE
                follow_user = ?';
    return fetch_all_query($dbh, $sql, array($user_id));
}

function count_follow($dbh, $user_id) {
    $sql = 'SELECT COUNT(follow_id)
            FROM sns_follow
            WHERE user_id = ?';
    return fetch_column_query($dbh, $sql, array($user_id));
}

function count_follower($dbh, $user_id) {
    $sql = 'SELECT COUNT(follow_id)
            FROM sns_follow
            WHERE follow_user = ?';
    return fetch_column_query($dbh, $sql, array($user_id));
}

function get_follow_list_detail($dbh, $user_id) {
    $sql = 'SELECT
                sns_follow.user_id,
                sns_follow.follow_user,
                sns_user.user_id,
                sns_user.name,
                sns_user.name_id,
                sns_user.comment,
                sns_user.img
            FROM
                sns_follow
            INNER JOIN
                sns_user
            ON
                sns_follow.follow_user = sns_user.user_id
            WHERE
                sns_follow.user_id = ?
            ';
    return fetch_all_query($dbh, $sql, array($user_id));
}

function get_follower_list_detail($dbh, $user_id) {
    $sql = 'SELECT
                sns_follow.user_id,
                sns_follow.follow_user,
                sns_user.user_id,
                sns_user.name,
                sns_user.name_id,
                sns_user.comment,
                sns_user.img
            FROM
                sns_follow
            INNER JOIN
                sns_user
            ON
                sns_follow.user_id = sns_user.user_id
            WHERE
                sns_follow.follow_user = ?
            ';
    return fetch_all_query($dbh, $sql, array($user_id));
}

// function get_follow_list_union($dbh, $user_id) {
//     $sql = 'SELECT
//                 user_id,
//                 follow_user
//             FROM
//                 sns_follow
//             WHERE
//                 follow_user = ?
//             UNION
//             SELECT
//                 user_id,
//                 follow_user
//             FROM
//                 sns_follow
//             WHERE
//                 user_id = ?';
//     return fetch_all_query($dbh, $sql, array($user_id, $user_id));
// }

function insert_sns_follow($dbh, $user_id, $follow_user_id, $created, $updated) {
    $sql = 'INSERT INTO
                sns_follow(
                user_id,
                follow_user,
                created,
                updated
                )
            VALUES(?, ?, ?, ?)';
    return execute_query($dbh, $sql, array($user_id, $follow_user_id, $created, $updated));
}
function delete_sns_follow($dbh, $user_id, $follow_user_id) {
    $sql = 'DELETE FROM sns_follow
            WHERE user_id = ?
            AND follow_user = ?';
    return execute_query($dbh, $sql, array($user_id, $follow_user_id));
}
