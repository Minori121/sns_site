<?php
// snsフォローのcontroller

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
        $id = $_SESSION['id'];
        $comment = $_SESSION['comment'];
        $user_img = $_SESSION['img'];
    } else {
        header('Location: login.php');
        exit;
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
                    header('Location: home.php');
                    exit;
                } catch (PDOException $e) {
                    $err_msg[] = 'データをinsetできませんでした。理由：'. $e->getMessage();
                }
            } else if($follow_status === '0') {
                try {
                    delete_sns_follow($dbh, $user_id, $follow_user_id);
                    header('Location: home.php');
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
