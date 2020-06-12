<?php
/** ユーザテーブルのデータを取得する
* 必要なデータのみを取得
*/
function get_sns_user_register($dbh, $name_id) {
        $sql = "SELECT
                    name_id
                FROM
                    sns_user
                WHERE
                    name_id = ?";
        return fetch_all_query($dbh, $sql, array($name_id));
}

function check_sns_user_follow($dbh, $follow_user) {
        $sql = "SELECT
                    name_id
                FROM
                    sns_user
                WHERE
                    user_id = ?";
        return fetch_all_query($dbh, $sql, array($follow_user));
}

function get_all_users($dbh, $user_id) {
        $sql = "SELECT
                    user_id,
                    name,
                    name_id,
                    comment,
                    img
                FROM
                    sns_user
                WHERE
                    user_id != ?";
        return fetch_all_query($dbh, $sql, array($user_id));
}

function get_three_users($dbh, $user_id) {
        $sql = "SELECT
                    user_id,
                    name,
                    name_id,
                    comment,
                    img
                FROM
                    sns_user
                WHERE
                    user_id != ?
                LIMIT 3";
        return fetch_all_query($dbh, $sql, array($user_id));
}

function check_sns_user_login($dbh, $name_id, $password) {
    global $err_msg;
    $user_id = '';
        $sql = 'SELECT
                    user_id,
                    name,
                    name_id,
                    comment,
                    img
                FROM
                    sns_user
                WHERE
                    name_id = ?
                AND
                    password = ?';
        $data = fetch_all_query($dbh, $sql, array($name_id, $password));
    if (isset($data)) {
        $_SESSION['user_id'] = $data[0]['user_id'];
        $_SESSION['name'] = $data[0]['name'];
        $_SESSION['name_id'] = $data[0]['name_id'];
        $_SESSION['comment'] = $data[0]['comment'];
        $_SESSION['img'] = $data[0]['img'];
        header('Location: home.php');
        exit;
    } else {
        $err_msg[] = 'ログインができませんでした。';
    }
}

/**
* ユーザテーブルにデータを作成
*/
function insert_sns_user($dbh, $user_name, $name_id, $password, $user_comment, $new_img_filename, $created, $updated) {
    $sql = 'INSERT INTO
                sns_user(
                name,
                name_id,
                password,
                comment,
                img,
                created,
                updated
                )
            VALUES(?, ?, ?, ?, ?, ?, ?)';
    return execute_query($dbh, $sql, array($user_name, $name_id, $password, $user_comment, $new_img_filename, $created, $updated));
}




/** 新規登録画面でのエラーをチェックする
* $user_name, $password
*/
function check_id($register_regex, $name_id) {
    global $err_msg;

    if ($id === '') {
        $err_msg[] = 'ユーザ名を入力してください';
    } else if (!preg_match($register_regex, $name_id)) {
        $err_msg[] = 'ユーザ名は6文字以上8文字以下の半角英数字で入力してください。';
    }
}

function check_password($register_regex, $password) {
    global $err_msg;

    if ($password === '') {
        $err_msg[] = 'パスワードを入力してください';
    } else if (!preg_match($register_regex, $password)) {
        $err_msg[] = 'パスワードは6文字以上8文字以下の半角英数字で入力してください。';
    }
}

function check_follow_user($follow_user, $check_follow){
    global $err_msg;

    if($follow_user === '') {
        $err_msg[] = '不適切な処理です';
    } else if (empty($check_follow)) {
        $err_msg[] = '不適切な処理です2.';
    }
}
function check_follow_status($follow_status) {
    global $err_msg;

    if ($follow_status === '') {
        $err_msg[] ='不適切な処理です';
    } else if ($follow_status !== '1' && $follow_status !== '0') {
        $err_msg[] = '不適切な処理です';
    }
}
