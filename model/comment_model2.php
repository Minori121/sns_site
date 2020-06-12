<?php
function get_follow_comment_list($dbh, $user_id) {
  $sql = 'SELECT
            sns_comment.comment_id,
            sns_comment.user_id,
            sns_comment.created comment_created,
            sns_comment.updated comment_updated,
            sns_reply.id,
            sns_reply.reply_id,
            sns_reply.user_id,
            sns_reply.created reply_created,
            sns_reply.updated reply_updated,
            sns_user.name,
            sns_user.name_id,
            sns_user.img
          FROM
            sns_comment
          INNER JOIN sns_user
          ON         sns_comment.user_id = sns_user.user_id
          INNER JOIN sns_reply'
}

function get_follow_comment_list_join($dbh, $user_id) {
  $sql = 'SELECT
            sns_user.name,
            sns_user.name_id,
            sns_user.img,
            sns_comment.comment_id,
            sns_comment.user_id,
            sns_comment.created comment_created,
            sns_comment.updated comment_updated,
            sns_reply.id,
            sns_reply.reply_id,
            sns_reply.user_id,
            sns_reply.created reply_created,
            sns_reply.updated reply_updated
          FROM
            sns_user
          INNER JOIN sns_comment
          ON         sns_user.user_id = sns_comment.user_id
          INNER JOIN sns_reply
          ON         sns_comment.comment_id = sns_reply.comment_id
          WHERE
              sns_user.user_id = ?
          OR sns_user.user_id IN (SELECT follow_user FROM sns_follow WHERE user_id = ?)
          ';
  return fetch_all_query($dbh, $sql, array($user_id, $user_id));
}


function get_follow_comment_list_join($dbh, $user_id) {
  $sql = 'SELECT
            sns_comment.comment_id,
            sns_comment.comment,
            sns_comment.created comment_created,
            sns_comment.updated comment_updated,
            sns_reply.id,
            sns_reply.reply_comment,
            sns_reply.created reply_created,
            sns_reply.updated reply_updated,
            sns_user.user_id,
            sns_user.name,
            sns_user.name_id,
            sns_user.img
          FROM
            sns_comment
          LEFT JOIN sns_reply
          ON         sns_comment.comment_id = sns_reply.comment_id
          INNER JOIN sns_user
          ON         sns_comment.user_id = sns_user.user_id
          WHERE (sns_comment.user_id = ? OR sns_comment.user_id IN (SELECT follow_user FROM sns_follow WHERE user_id = ?) )
          AND (sns_reply.reply_id = 0 OR sns_reply.reply_id is null)
        ';
  return fetch_all_query($dbh, $sql, array($user_id, $user_id));
}

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
