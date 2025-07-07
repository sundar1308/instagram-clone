<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
?>
<div class="modal fade" id="create_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title w-100 fs-5 d-flex align-items-end justify-content-between" id="exampleModalLabel">
                    <span class="title_create      ">Create new post</span>
                    <!-- Form Start -->
                    <?php $form = ActiveForm::begin([
                        'id' => 'post-form',
                        'action' => ['/posts/create'],
                        'options' => ['enctype' => 'multipart/form-data'],
                    ]); ?>
                    <!-- <button class="next_btn_post btn_link"></button> -->
                    <div>
                        <?= Html::button('', ['class' => 'next_btn_post btn_link', 'name' => 'share-button']) ?>
                    </div>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <img class="up_load" src="<?= Yii::getAlias('@web/web/images/upload.png'); ?>" alt="upload">
                <p>Drag photos and videos here</p>
                <!-- <button class="btn btn-primary btn_upload">
                            select from your computer
                            <form id="upload-form">
                                <input class="input_select" type="file" id="image-upload" name="image-upload">
                            </form>
                        </button> -->
                <a href="void:javascript;" class="btn_upload btn btn-primary">
                    <div id="upload-form">
                        <?= $form->field($model, 'image_path')->fileInput(['id' => 'image-upload', 'class' => 'input_select'])->label('Select from your computer') ?>
                    </div>
                </a>



                <div id="image-container" class="hide_img">
                </div>
                <div id="image_description" class="hide_img">
                    <div class="img_p"></div>
                    <div class="description">
                        <div class="cart">
                            <div>
                                <div class="img">
                                    <img src=<?=
                                                Yii::$app->user->identity->profile_image ?
                                                    Yii::getAlias('@web/web/' . Yii::$app->user->identity->profile_image) :
                                                    Yii::getAlias('@web/web/images/profile_img.jpg');
                                                ?>>
                                </div>
                                <div class="info">
                                    <p class="name"><?= Yii::$app->user->identity->username ?></p>
                                </div>
                            </div>
                        </div>
                        <!-- <form>
                                    <textarea type="text" id="emoji_create" placeholder="write your email"></textarea>
                                </form> -->
                        <?= $form->field($model, 'caption')->textarea(['rows' => 4, 'id' => 'emoji_create']) ?>

                    </div>
                </div>
                <div class="post_published hide_img">
                    <img src="<?= Yii::getAlias('@web/web/images/uploaded_post.gif') ?>" alt="">
                </div>
                <?php ActiveForm::end() ?>
                <!-- Form End -->
            </div>
        </div>
    </div>
</div>