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
                <h2>ユーザ一覧</h2>
                <?php if(count($err_msg) !== 0) { ?>
                    <?php foreach($err_msg as $value) { ?>
                        <p><?php print $value; ?></p>
                    <?php } ?>
                <?php } ?>

                <?php if(empty($all_users)) { ?>
                    <p><?php print '他のユーザがいません'; ?></p>
                <?php } else { ?>
                    <?php foreach($all_users as $user) { ?>
                        <!--フォローもフォロワーも0でない場合-->
                        <?php if(!empty($follows) && !empty($followers)) { ?>
                            <form method="post" action="search.php">
                                <div class="comment">
                                    <div class="user_info">
                                        <img src="<?php print $user_img_dir . $user['img']; ?>">
                                        <div class="user_name">
                                            <span class="name"><?php print (h($user['name'])); ?></span>
                                            <span class="id">＠<?php print (h($user['name_id'])); ?></span>

                                            <?php if(in_array($user['user_id'],array_column($followers,'user_id'))) { ?>
                                                <p class="follower_msg">フォローされています</p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <p class="comment_prof"><?php print (h($user['comment'])); ?></p>
                                    <?php if(in_array($user['user_id'], array_column($follows, 'follow_user'))) { ?>
                                        <button type="submit" name="follow_user" value="0" class="btn follow">フォロー中</button>
                                        <input type="hidden" name="follow_user_id" value="<?php print $user['user_id']; ?>">
                                    <?php } else { ?>
                                        <button type="submit" name="follow_user" value="1" class="btn follow">フォローする</button>
                                        <input type="hidden" name="follow_user_id" value="<?php print $user['user_id']; ?>">
                                    <?php } ?>
                                </div>
                            </form>
                        <!--フォロワーのみが0の場合-->
                        <?php } else if(!empty($follows) && empty($followers)) { ?>
                            <form method="post" action="search.php">
                                <div class="comment">
                                    <div class="user_info">
                                        <img src="<?php print $user_img_dir . $user['img']; ?>">
                                        <div class="user_name">
                                            <span class="name"><?php print (h($user['name'])); ?></span>
                                            <span class="id">＠<?php print (h($user['name_id'])); ?></span>
                                        </div>
                                    </div>
                                    <p class="comment_prof"><?php print (h($user['comment'])); ?></p>
                                        <?php if(in_array($user['user_id'], array_column($follows, 'follow_user'))) { ?>
                                            <button type="submit" name="follow_user" value="0" class="btn follow">フォロー中</button>
                                            <input type="hidden" name="follow_user_id" value="<?php print $user['user_id']; ?>">
                                        <?php } else { ?>
                                            <button type="submit" name="follow_user" value="1" class="btn follow">フォローする</button>
                                            <input type="hidden" name="follow_user_id" value="<?php print $user['user_id']; ?>">
                                    <?php } ?>
                                </div>
                            </form>
                        <!--フォローのみが0の場合  -->
                        <?php } else if(empty($follows) && !empty($followers)) { ?>
                            <form method="post" action="search.php">
                                <div class="comment">
                                    <div class="user_info">
                                        <img src="<?php print $user_img_dir . $user['img']; ?>">
                                        <div class="user_name">
                                            <span class="name"><?php print (h($user['name'])); ?></span>
                                            <span class="id">＠<?php print (h($user['name_id'])); ?></span>

                                            <?php if(in_array($user['user_id'],array_column($followers,'user_id'))) { ?>
                                                <p class="follower_msg">フォローされています</p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <p class="comment_prof"><?php print (h($user['comment'])); ?></p>
                                        <button type="submit" name="follow_user" value="1" class="btn follow">フォローする</button>
                                        <input type="hidden" name="follow_user_id" value="<?php print $user['user_id']; ?>">
                                </div>
                            </form>
                        <!--フォローもフォロワーも0の場合-->
                        <?php } else { ?>
                        <form method="post" action="search.php">
                            <div class="comment">
                                <div class="user_info">
                                    <img src="<?php print $user_img_dir . $user['img']; ?>">
                                    <div class="user_name">
                                        <span class="name"><?php print (h($user['name'])); ?></span>
                                        <span class="id">＠<?php print (h($user['name_id'])); ?></span>
                                    </div>
                                </div>
                                <p class="comment_prof"><?php print (h($user['comment'])); ?></p>
                                <button type="submit" name="follow_user" value="1"  class="btn follow">フォローする</button>
                                <input type="hidden" name="follow_user_id" value="<?php print $user['user_id']; ?>">
                            </div>
                        </form>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </section>
    </main>
</body>
</html>
