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
        <h2>ログインページ</h2>
        <form method="post">
            <?php if (count($err_msg) !== 0) { ?>
                <?php foreach($err_msg as $value) { ?>
                    <p><?php print $value; ?></p>
                <?php } ?>
            <?php } else if ($result_msg !== '') { ?>
                <p><?php print $result_msg; ?></p>
            <?php } ?>
        <p>ユーザID：<br><input type="text" name="id"></p>
        <p>パスワード：<br><input type="password" name="password"></p>
        <p><input type="submit" value="ログインする"></p>
        <a href="register.php">新規登録ページへ</a>
    </main>
</body>
</html>
