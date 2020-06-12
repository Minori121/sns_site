<?php
// SNSユーザーページのcontroller

// 設定ファイルを読み込み
require_once './conf/const.php';
require_once './model/common.php';
require_once './model/follow_model.php';
require_once './model/comment_model.php';
require_once './model/reply_model.php';

$user_img_dir = './user_img/';
$comment_img_dir = './comment_img/';
$request_method = get_request_method();
date_default_timezone_set('Asia/Tokyo');
$created = date('Y-m-d H:i:s');
$updated = date('Y-m-d H:i:s');
$process_kind = '';
$err_msg = array();

try {
    // DB接続
    $dbh = get_db_connect();

    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $name = $_SESSION['name'];
        $name_id = $_SESSION['name_id'];
        $comment = $_SESSION['comment'];
        $user_img = $_SESSION['img'];
    } else {
        header('Location: login.php');
        exit;
    }

    if ($request_method === 'POST') {
        $process_kind = get_post_data('process_kind');
        if ($process_kind === 'first_reply') {
            $comment_id = get_post_data('comment_id_reply');
            if(isset($comment_id)) {
                $comments = get_reply_comment($dbh, $comment_id);
                // $end = end($comments);
            }
        } else if($process_kind === 'second_reply') {
            $reply_id = get_post_data('reply_id');
                if(isset($reply_id)) {
                    $comments = get_reply($dbh, $reply_id);
                }

        }

        if($process_kind === 'insert_reply') {
            $reply_comment = get_post_data('reply_comment');
            $reply_id = get_post_data('reply_id');
            $comment_id =get_post_data('comment_id');
            check_comment($reply_comment);
            if(count($err_msg) === 0) {
                $dbh->beginTransaction();
                try {
                    insert_reply_comment($dbh, $comment_id, $reply_id, $user_id, $reply_comment, $created, $updated);
                    update_comment_list($dbh, $comment_id, $updated);
                    update_reply_list($dbh, $comment_id, $updated);
                    $dbh->commit();
                    header('Location:./home.php');
                    exit;
                } catch (PDOException $e) {
                    $dbh->rollback();
                    throw $e;
                }
            }
        }
    } else {
        header('Location: home.php');
        exit;
    }

} catch (PDOException $e) {
    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
}

include_once './view/reply_view.php';
