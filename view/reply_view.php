<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>SNS</title>
    <link rel="stylesheet" href="./view/home.css">
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
            <h2>投稿内容</h2>

                <?php if(!empty($comments)) { ?>
                    <?php foreach($comments as $comment) { ?>
                        <div class="comment">
                            <div class="user_info">
                                <img src="<?php print $user_img_dir . $comment['img']; ?>">
                                <div class="user_name">
                                    <span class="name"><?php print (h($comment['name'])); ?></span>
                                    <span class="id">＠<?php print (h($comment['name_id'])); ?></span>
                                    <span class="id">＠<?php print $comment['comment_created']; ?></span>
                                </div>
                            </div>
                            <p><?php print (h($comment['comment'])); ?></p>
                        </div>
                <div class="reply_form">
                    <form method="post">
                        <h2>返信フォーム</h2>
                        <textarea name="reply_comment" rows="8" cols="80" placeholder="返信を入力して下さい。"></textarea>
                        <p class="post_button"><input type="submit" value="送信する" class="btn post"></p>
                        <input type="hidden" name="reply_id" value="<?php if(isset($comment['reply_id'])) { print $comment['reply_id']; }?>">
                        <input type="hidden" name="comment_id" value="<?php print $comment['comment_id']; ?>">
                        <input type="hidden" name="process_kind" value="insert_reply">

                    <?php } ?>
                <?php } ?>
                </form>
            </div>
            </div>
        </section>
    </main>
</body>
</html>
