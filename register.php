<?php
// sns会員登録ページのcontroller

// 設定ファイルの読み込み
require_once './conf/const.php';
require_once './model/common.php';
require_once './model/user_model.php';

date_default_timezone_set('Asia/Tokyo');
$created = date('Y-m-d H:i:s');
$updated = date('Y-m-d H:i:s');

$err_msg = array();
$data = array();
$result_msg = '';
$img_dir          = './user_img/';
$new_img_filename = '';

$request_method = get_request_method();

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
        $name_id = get_post_data('name_id');
        $user_name = get_post_data('user_name');
        $password = get_post_data('password');
        $user_comment = get_post_data('comment');
        $register_regex = '/^[a-zA-Z0-9]{6,8}$/';
        // エラーチェック
        check_id($register_regex, $name_id);
        check_password($register_regex, $password);

        // アップロード画像ファイルの保存
            if (count($err_msg) === 0) {
                $tmpfile  = $_FILES['new_img']['tmp_name'];
                $filename = $_FILES['new_img']['name'];
                $new_img_filename = file_upload ($tmpfile, $filename, $img_dir);
            }

        if (count($err_msg) === 0) {
            //同じIDのユーザがいないか確認のため、userテーブルから情報を取得
            $data = get_sns_user_register($dbh, $name_id);
            if (empty($data)) {
                try {
                    // ユーザ情報を登録
                    insert_sns_user($dbh, $user_name, $name_id, $password, $user_comment, $new_img_filename, $created, $updated);
                    header('Location: login.php');
                    exit;
                } catch (PDOException $e) {
                    $err_msg[] = 'ユーザ登録ができませんでした。理由：' .$e->getMessage();
                }
            } else {
                $err_msg[] = 'このユーザ名は既に使用されています。';
            }
        }
    }

} catch (PDOException $e) {
    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
}

include_once './view/register_view.php';
