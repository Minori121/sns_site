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
                <span class="follow_prof"><?php print $follow_num; ?> フォロー中</span><br>
                <span class="follow_prof"><?php print $follower_num; ?> フォロワー</span>
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
                <h2>フォロー 一覧</h2>
                <?php if(count($err_msg) !== 0) { ?>
                    <?php foreach($err_msg as $value) { ?>
                        <p><?php print $value; ?></p>
                    <?php } ?>
                <?php } ?>

                <?php if(empty($follows)) { ?>
                    <p><?php print '誰もフォローしていません'; ?></p>
                <?php } else { ?>
                    <?php foreach($follows as $follow) { ?>
                        <?php if(!empty($followers)) { ?>

                            <div class="comment">
                                <div class="user_info">
                                    <img src="<?php print $user_img_dir . $follow['img']; ?>">
                                    <div class="user_name">
                                        <span class="name"><?php print (h($follow['name'])); ?></span>
                                        <span class="id">＠<?php print (h($follow['name_id'])); ?></span>

                                            <?php if(in_array($follow['user_id'],array_column($followers,'user_id'))) { ?>
                                                <p class="follower_msg">フォローされています</p>
                                            <?php } ?>
                                    </div>
                                </div>
                                <p><?php print (h($follow['comment'])); ?></p>
                                <form method="post" action="home_follow.php">
                                        <button type="submit" name="follow_user" value="0" class="btn follow">フォロー解除</button>
                                        <input type="hidden" name="follow_user_id" value="<?php print $follow['user_id']; ?>">
                                </form>
                            </div>
                        <?php } else { ?>
                            <div class="comment">
                                <div class="user_info">
                                    <img src="<?php print $user_img_dir . $follow['img']; ?>">
                                    <div class="user_name">
                                        <span class="name"><?php print (h($follow['name'])); ?></span>
                                        <span class="id">＠<?php print (h($follow['name_id'])); ?></span>
                                    </div>
                                </div>
                                <p><?php print (h($follow['comment'])); ?></p>
                                <form method="post" action="home_follow.php">
                                        <button type="submit" name="follow_user" value="0" class="btn follow">フォロー解除</button>
                                        <input type="hidden" name="follow_user_id" value="<?php print $follow['user_id']; ?>">
                                </form>
                            </div>






                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </section>
    </main>
</body>
</html>
