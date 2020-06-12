<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>SNS</title>
    <link rel="stylesheet" href="./view/home.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
    <header>

    </header>
    <main>
        <nav>
            <div class="prof">
                <a href="mypage.php"><img src="<?php print $user_img_dir . $user_img; ?>" ></a>
                <label class="name"><?php print (h($name)); ?></label>
                <span class="id">＠<?php print (h($name_id)); ?></span>
                <p class="comment_prof"><?php print (h($comment)); ?></p>
                <span class="follow_prof">フォロー中</span><br>
                <span class="follow_prof">フォロワー</span>
                <ul>
                    <li><a href="home.php" class="prof_menu">ホーム</a></li>
                    <li><a href="mypage.php" class="prof_menu">プロフィール</a></li>
                    <li><a href="like.php" class="prof_menu">いいねした投稿</a></li>
                    <li><a href="follow.php" class="prof_menu">フォロー</a></li>
                    <li><a href="follower.php" class="prof_menu">フォロワー</a></li>
                </ul>


                <form method="post" action="logout.php">
                    <input type="submit" name="delete" value="ログアウトする" >
                </form>
            </div>
        </nav>

        <section>
            <div class="reply_msg">
                <h2>投稿一覧</h2>
                <?php if(count($err_msg) !== 0) { ?>
                    <?php foreach($err_msg as $value) { ?>
                        <p><?php print $value; ?></p>
                    <?php } ?>
                <?php } ?>
                <?php if(empty($my_all_comments)) { ?>
                    <p><?php print '投稿がありません';?></p>
                <?php } else { ?>
                    <?php foreach($my_all_comments as $my_all_comment) { ?>
                        <div class="comment">
                            <div class="user_info">
                                <img src="<?php print $user_img_dir . $my_all_comment['img']; ?>">
                                <div class="user_name">
                                    <span class="name"><?php print (h($my_all_comment['name'])); ?></span>
                                    <span class="id">＠<?php print (h($my_all_comment['name_id'])); ?></span>
                                    <span class="id"><?php print (h($my_all_comment['created'])); ?></span>
                                </div>
                            </div>
                            <p><?php print (h($my_all_comment['comment'])); ?></p>
                        </div>
                    <?php } ?>
                <?php } ?>
                <a href="home.php">ホームにもどる</a>
            </div>
        </section>
    </main>
</body>
</html>
