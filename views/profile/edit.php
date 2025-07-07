<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

?>

<div class="editProfile mx-5 mt-3">
    <?php
    $form = ActiveForm::begin([
        'id' => 'editProfileForm'
    ]);
    ?>
        <?= $form->field($model, 'profile_image')->fileInput(); ?>
        <?= $form->field($model, 'nick_name')->textInput(); ?>
        <?= $form->field($model, 'desc')->textInput(); ?>
        <div>
             <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php
    ActiveForm::end();
    ?>
</div>