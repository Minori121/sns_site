<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>SNS</title>
</head>
<body>
    <header>

    </header>
    <main>
        <h2>新規登録ページ</h2>
        <form method="post" enctype="multipart/form-data">
            <?php if (count($err_msg) !== 0) { ?>
                <?php foreach($err_msg as $value) { ?>
                    <p><?php print $value; ?></p>
                <?php } ?>
            <?php } else if ($result_msg !== '') { ?>
                <p><?php print $result_msg; ?></p>
            <?php } ?>
            <p>ユーザネーム：<br><input type="text" name="user_name"></p>
            <p>ユーザID：<br><input type="text" name="name_id"></p>
            <p>パスワード：<br><input type="password" name="password"></p>
            <p>自己紹介：<br><textarea name="comment"></textarea></p>
            <p>画像：<br><input type="file" name="new_img"></p>
            <p><input type="submit" value="会員登録をする"></p>
        </form>
    </main>
</body>
</html>
