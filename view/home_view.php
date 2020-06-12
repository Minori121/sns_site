<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>SNS</title>
    <link rel="stylesheet" href="./view/home.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <!-- <script>
        $(function() {
            $('.replies').hide();
            $('.posting').click(function() {
                $(this).next().slideToggle();
            });
        });
    </script> -->

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
            <div class="user_search">
                <h2>他のユーザを探す</h2>
                    <?php foreach($three_users as $user) { ?>
                    <!--フォローもフォロワーも0でない場合-->
                        <?php if(!empty($follows) && !empty($followers)) { ?>

                            <form method="post" action="home_follow.php">
                                <div class="others">
                                    <img src="<?php print $user_img_dir . $user['img']; ?>">
                                    <span class="name"><?php print (h($user['name'])); ?></span>
                                    <span class="id">＠<?php print (h($user['name_id'])); ?></span>

                                    <?php if(in_array($user['user_id'],array_column($followers,'user_id'))) { ?>
                                        <p class="follower_msg">フォローされています</p>
                                    <?php } ?>

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

                            <form method="post" action="home_follow.php">
                                <div class="others">
                                    <img src="<?php print $user_img_dir . $user['img']; ?>">
                                    <span class="name"><?php print (h($user['name'])); ?></span>
                                    <span class="id">＠<?php print (h($user['name_id'])); ?></span>

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
                            <form method="post" action="home_follow.php">
                                <div class="others">
                                    <img src="<?php print $user_img_dir . $user['img']; ?>">
                                    <span class="name"><?php print (h($user['name'])); ?></span>
                                    <span class="id">＠<?php print (h($user['name_id'])); ?></span>

                                    <?php if(in_array($user['user_id'],array_column($followers,'user_id'))) { ?>
                                        <p class="follower_msg">フォローされています</p>
                                    <?php } ?>

                                    <p class="comment_prof"><?php print (h($user['comment'])); ?></p>
                                        <button type="submit" name="follow_user" value="1" class="btn follow">フォローする</button>
                                        <input type="hidden" name="follow_user_id" value="<?php print $user['user_id']; ?>">
                                </div>
                            </form>
                        <!--フォローもフォロワーも0の場合-->
                        <?php } else { ?>
                            <form method="post" action="home_follow.php">
                                <div class="others">
                                    <img src="<?php print $user_img_dir . $user['img']; ?>">
                                    <span class="name"><?php print (h($user['name'])); ?></span>
                                    <span class="id">＠<?php print (h($user['name_id'])); ?></span>
                                    <p class="comment_prof"><?php print (h($user['comment'])); ?></p>

                                    <button type="submit" name="follow_user" value="1" class="btn follow">フォローする</button>
                                    <input type="hidden" name="follow_user_id" value="<?php print $user['user_id']; ?>">

                                </div>
                            </form>
                        <?php } ?>
                    <?php } ?>

                <a href="search.php">さらに表示</a>
            </div>
        </nav>
        <section>
            <div class="post_form">
                <h2>投稿フォーム</h2>
                <form method="post">
                    <textarea name="comment" rows="8" cols="80" placeholder="今何してる？"></textarea>
                    <p class="post_button"><input type="submit" value="投稿する" class="btn post"></p>
                    <input type="hidden" name="process_kind" value="insert_comment">
                </form>
            </div>
            <div class="timeline">
                <h2>タイムライン</h2>
                <?php if(count($err_msg) !== 0) { ?>
                    <?php foreach($err_msg as $value) { ?>
                        <p><?php print $value; ?></p>
                    <?php } ?>
                <?php } ?>
                <?php if(empty($all_comments)) { ?>
                    <p><?php print '投稿がありません';?></p>
                <?php } else { ?>
                    <?php foreach($all_comments as $all_comment) { ?>
                    <div id="accordion">
                    <!-- 1つ目の投稿 -->
                    <?php if((in_array($all_comment['reply_user_id'], array_column($follows, 'follow_user'))) || (in_array($all_comment['reply_user_id'], array_column($follows, 'user_id'))) || $all_comment['reply_user_id'] === null){ ?>
                    <div class="posting comment">
                        <div class="user_info">
                            <img src="<?php print $user_img_dir . $all_comment['comment_img']; ?>">
                            <div class="user_name">
                                <span class="name"><?php print (h($all_comment['comment_name'])); ?></span>
                                <span class="id">＠<?php print (h($all_comment['comment_name_id'])); ?></span>
                                <span class="id"><?php print (h($all_comment['comment_created'])); ?></span>
                            </div>
                        </div>
                        <p><?php print (h($all_comment['comment'])); ?></p>
                        <div class="btns">
                            <form method="post" action="reply.php" class="reply_btn">
                                <button type="submit"class="btn reply" >返信</button>
                                <input type="hidden" name="comment_id_reply" value="<?php print $all_comment['comment_id']; ?>">
                                <input type="hidden" name="process_kind" value="first_reply">
                            </form>

                            <?php if($all_comment['comment_user_id'] === $user_id) { ?>
                                <form method="post" action="home_comment_delete.php" class="btn delete">
                                    <button type="submit">削除</button>
                                    <input type="hidden" name="comment_id" value="<?php print $all_comment['comment_id']; ?>">
                                    <input type="hidden" name="process_kind" value="delete_comment">
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                     <?php } ?>
                    <!-- 2つ目の投稿 -->
                    <div class="replies">
                    <?php if(isset($all_comment['id'])) { ?>
                    <?php if((in_array($all_comment['reply_user_id'], array_column($follows, 'follow_user'))) || (in_array($all_comment['reply_user_id'], array_column($follows, 'user_id')))){ ?>

                    <div class="replying comment">
                        <div class="user_info">
                            <img src="<?php print $user_img_dir . $all_comment['reply_img']; ?>">
                            <div class="user_name">
                                <span class="name"><?php print (h($all_comment['reply_name'])); ?></span>
                                <span class="id">＠<?php print (h($all_comment['reply_name_id'])); ?></span>
                                <span class="id"><?php print (h($all_comment['reply_created'])); ?></span>
                            </div>
                        </div>
                        <p class="to_reply">返信先：＠<?php print $all_comment['comment_name_id']; ?>さん</p>
                        <p><?php print (h($all_comment['reply_comment'])); ?></p>

                        <div class="btns">
                            <form method="post" action="reply.php" class="reply_btn">
                                <button type="submit"class="btn reply" >返信</button>
                                <input type="hidden" name="comment_id_reply" value="<?php print $all_comment['comment_id']; ?>">
                                <input type="hidden" name="reply_id" value="<?php print $all_comment['id']; ?>">
                                <input type="hidden" name="process_kind" value="second_reply">
                            </form>

                            <?php if($all_comment['reply_user_id'] === $user_id) { ?>
                                <form method="post" action="home_comment_delete.php" class="btn delete">
                                    <button type="submit">削除</button>
                                    <input type="hidden" name="comment_id" value="<?php print $all_comment['comment_id']; ?>">
                                    <input type="hidden" name="process_kind" value="delete_comment">
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } ?>
                    <!-- 3つ目の投稿 -->
                    <?php if(in_array($all_comment['id'],array_column($all_replies,'reply_id'))) { ?>
                        <?php foreach($all_replies as $all_reply) { ?>
                            <?php if($all_comment['id'] === $all_reply['reply_id']) { ?>
                        <div class="replying02 comment">
                            <div class="user_info">
                                <img src="<?php print $user_img_dir . $all_reply['img']; ?>">
                                <div class="user_name">
                                    <span class="name"><?php print (h($all_reply['name'])); ?></span>
                                    <span class="id">＠<?php print (h($all_reply['name_id'])); ?></span>
                                    <span class="id"><?php print (h($all_reply['reply_created'])); ?></span>
                                </div>
                            </div>
                            <p class="to_reply">返信先：＠<?php print $all_comment['comment_name_id']; ?>さん</p>
                            <p><?php print (h($all_reply['reply_comment'])); ?></p>

                            <div class="btns">
                                <form method="post" action="reply.php" class="reply_btn">
                                    <button type="submit"class="btn reply" >返信</button>
                                    <input type="hidden" name="comment_id_reply" value="<?php print $all_comment['comment_id']; ?>">
                                    <input type="hidden" name="reply_id" value="<?php print $all_reply['id']; ?>">
                                    <input type="hidden" name="process_kind" value="second_reply">
                                </form>

                                <?php if($all_comment['reply_user_id'] === $user_id) { ?>
                                    <form method="post" action="home_comment_delete.php" class="btn delete">
                                        <button type="submit">削除</button>
                                        <input type="hidden" name="comment_id" value="<?php print $all_comment['comment_id']; ?>">
                                        <input type="hidden" name="process_kind" value="delete_comment">
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    </div>


                </div>
                 <?php } ?>
                 <?php } ?>
            </div>
        </section>
    </main>
</body>
</html>
