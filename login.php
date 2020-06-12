<?php
// SNSログインページのcontroller

// 設定ファイルを読み込み
require_once './conf/const.php';
require_once './model/common.php';
require_once './model/user_model.php';

$err_msg = array();
$data = array();
$result_msg = '';
$request_method = get_request_method();
$err_msg = array();

try {
    // DB接続
    $dbh = get_db_connect();
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        header('Location: home.php');
        exit;
    }

    if ($request_method === 'POST') {
        $id = get_post_data('id');
        $password = get_post_data('password');
        $register_regex = '/^[a-zA-Z0-9]{6,8}$/';

        check_id($register_regex, $id);
        check_password($register_regex, $password);

        if (count($err_msg) === 0) {
            try {
                check_sns_user_login($dbh, $id, $password);
                $result_msg = 'ログインできました';
            } catch (PDOException $e) {
                $err_msg[] = 'ユーザデータベース処理でエラーが発生しました。理由：' .$e->getMessage();
            }
        }

    }

} catch (PDOException $e) {
    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
}

include_once './view/login_view.php';
