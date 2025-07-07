<?php

use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\components\Utility;

?>

<?php foreach ($posts as $post) :

    // echo "<pre>";
    // print_r($post->getLikes()->where([
    //     'user_id'=>Yii::$app->user->id,
    //     ]));
    // exit;
?>

    <div class="post">
        <div class="info">
            <div class="person">
                <!-- <img src="https://i.ibb.co/3S1hjKR/account1.jpg"> -->

                <img src='<?=
                            $post->user->getProfileimage()
                            ?>'>

                <a href="<?= Yii::$app->user->id == $post->user->id ?

                                Url::to(['/profile/index'])

                                : Url::to(['/profile/view', 'id' => $post->user->uuid])

                            ?>"><?= Html::encode($post->user->username) ?></a>
                <span class="circle">.</span>

                <span><?php
                        $createdAt = strtotime($post->created_at);
                        echo Yii::$app->formatter->asRelativeTime($createdAt);
                        ?>
            </div>
            <div class="more">
                <img src="<?= Yii::getAlias('@web/web/images/show_more.png') ?>" alt="show more">
            </div>
        </div>
        <div class="image">
            <!-- <img src="https://i.ibb.co/Jqh3rHv/img1.jpg"> -->
            <img src=<?=
                        $post->image_path ?
                            Yii::getAlias('@web/web/' . $post->image_path) :
                            'https://i.ibb.co/Jqh3rHv/img1.jpg';
                        ?>>

        </div>
        <div class="desc">
            <div class="icons">
                <div class="icon_left d-flex">
                    <div class="like d-flex align-items-center me-3">
                        <!-- <img class="not_loved" src="./images/love.png"> 
                  <img class="loved" src="./images/heart.png">  -->
                        <!-- <i class="fa-solid fa-heart loved text-danger likeStatus" data-status='1' data-post-id='<?= $post->id ?>'></i>
                  <i class="fa-regular fa-heart not_loved likeStatus" data-status='0' data-post-id='<?= $post->id ?>'></i>
                 -->

                        <div class="likeContainer">
                            <div class="like-button <?= $post->getLikes()->where([
                                                        'user_id' => Yii::$app->user->id,
                                                        'post_id' => $post->id
                                                    ])->one() ? 'active' : '' ?> " data-post-id='<?= $post->uuid ?>'>
                                <div class="heart" id="likeHeart"></div>
                            </div>
                        </div>
                        <div class="liked">
                            <a class="bold" href="void:javascript;"><?= $post->getLikes()->count() ?> likes</a>
                        </div>
                    </div>
                    <div class="chat d-flex align-items-center me-3">

                        <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#message_modal" data-post-id='<?= $post->uuid ?>'>
                            <img class="me-1" src="<?= Yii::getAlias('@web/web/images/bubble-chat.png') ?>">
                            <a class="bold" href="void:javascript;"><?= $post->getComments()->where(['parent_comment_id' => null])->count() ?> Comments</a>
                        </button>

                        <!-- <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#message_modal">
                      <img src=" <?= Yii::getAlias('@web/web/images/bubble-chat.png') ?> ">
                  </button> -->
                    </div>
                    <div class="send">
                        <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="##send_message_modal">
                            <img src=" <?= Yii::getAlias('@web/web/images/send.png') ?> ">
                        </button>
                    </div>
                </div>
                <div class="save not_saved">
                    <img class="hide saved" src="./images/save_black.png">
                    <img class="not_saved" src="<?= Yii::getAlias('@web/web/images/save-instagram.png') ?>">
                </div>
            </div>
            <!-- <div class="liked">
          <a class="bold" href="#"><?= $post->getLikes()->count() ?> likes</a>
      </div> -->
            <div class="post_desc">
                <p>
                    <a class="bold" href="#"><?= Html::encode($post->user->username) ?></a>
                    <?= Html::encode($post->caption) ?>
                </p>
                <p><a class="gray" data-bs-toggle="modal" data-post-id='<?= $post->uuid ?>' data-bs-target="#message_modal" href="void:javascript;">View all <?= $post->getComments()->where(['parent_comment_id' => null])->count() ?> comments</a></p>
                <input type="text" placeholder="Add a comments...">
            </div>
        </div>
    </div>



<?php endforeach; ?>