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

    try {
        $followers = get_follower_list_detail($dbh, $user_id);
        $follower_num = count_follower($dbh, $user_id);
        // var_dump($followers);
    } catch (PDOException $e) {
            $err_msg[] = 'データを取得できませんでした。理由：'. $e->getMessage();
    }
   try {
        $follows = get_follow_list($dbh, $user_id);
        $follow_num = count_follow($dbh, $user_id);
        // var_dump($follows);
    } catch (PDOException $e) {
            $err_msg[] = 'データを取得できませんでした。理由：'. $e->getMessage();
    }

} catch (PDOException $e) {
    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
}

include_once './view/follower_view.php';
