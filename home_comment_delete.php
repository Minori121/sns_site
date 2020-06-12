<?php
// SNSユーザーページのcontroller

// 設定ファイルを読み込み
require_once './conf/const.php';
require_once './model/common.php';
require_once './model/follow_model.php';
require_once './model/comment_model.php';
require_once './model/like_model.php';
require_once './model/reply_model.php';
require_once './model/user_model.php';

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
        if($process_kind === 'delete_comment') {
            $comment_id = get_post_data('comment_id');
            $null_id = get_post_data('null_id');
            var_dump($comment_id);
            var_dump($null_id);
            if($comment_id !== '' && $null_id !== '') {
                try {
                    delete_reply_comment($dbh, $null_id);
                    header('Location: home.php');
                    exit;
                } catch (PDOException $e) {
                    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
                }
            } else if($comment_id !== '' && $null_id === '') {
                try {
                    delete_comment($dbh, $comment_id);
                    header('Location: home.php');
                    exit;
                } catch (PDOException $e) {
                    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
                }
            }
        }
    }

} catch (PDOException $e) {
    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
}
