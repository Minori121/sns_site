<?php
// SNSユーザーページのcontroller

// 設定ファイルを読み込み
require_once './conf/const.php';
require_once './model/common.php';
require_once './model/follow_model.php';
require_once './model/user_model.php';

$user_img_dir = './user_img/';
$request_method = get_request_method();
date_default_timezone_set('Asia/Tokyo');
$created = date('Y-m-d H:i:s');
$updated = date('Y-m-d H:i:s');
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
        $all_users = get_all_users($dbh, $user_id);
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
    try {
        $followers = get_follower_list($dbh, $user_id);
        $follower_num = count_follower($dbh, $user_id);
        // var_dump($followers);
    } catch (PDOException $e) {
            $err_msg[] = 'データを取得できませんでした。理由：'. $e->getMessage();
    }

    if($request_method === 'POST') {
        $follow_status = get_post_data('follow_user');
        $follow_user_id = get_post_data('follow_user_id');
        $check_follow = check_sns_user_follow($dbh, $follow_user_id);
        check_follow_user($follow_user, $check_follow);
        check_follow_status($follow_status);
        if(count($err_msg) === 0) {
            if($follow_status === '1') {
                try {
                    insert_sns_follow($dbh, $user_id, $follow_user_id, $created, $updated);
                    header('Location: search.php');
                    exit;
                } catch (PDOException $e) {
                    $err_msg[] = 'データをinsetできませんでした。理由：'. $e->getMessage();
                }
            } else if($follow_status === '0') {
                try {
                    delete_sns_follow($dbh, $user_id, $follow_user_id);
                    header('Location: search.php');
                    exit;
                } catch (PDOException $e) {
                    $err_msg[] = 'データをinsetできませんでした。理由：'. $e->getMessage();
                }
            }
        }
    }
} catch (PDOException $e) {
    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
}

include_once './view/search_view.php';
