<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
?>

<div class="container">
    <div class="login">
        <div class="images d-none d-lg-block">
            <div class="frame">
                <img src="<?= Yii::getAlias('@web/web/images/home-phones.png') ?>" alt="picutre frame">
            </div>
            <div class="sliders">
                <div id="carouselExampleSlidesOnly" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?= Yii::getAlias('@web/web/images/screenshot1.png') ?>" class="d-block" alt="screenshot1">
                        </div>
                        <div class="carousel-item active">
                            <img src="<?= Yii::getAlias('@web/web/images/screenshot2.png') ?>" class="d-block" alt="screenshot1">
                        </div>
                        <div class="carousel-item active">
                            <img src="<?= Yii::getAlias('@web/web/images/screenshot3.png') ?>" class="d-block" alt="screenshot1">
                        </div>
                        <div class="carousel-item active">
                            <img src="<?= Yii::getAlias('@web/web/images/screenshot4.png') ?>" class="d-block" alt="screenshot1">
                        </div>
                        <!-- <div class="carousel-item">
                            <img src="./images/screenshot2.png" class="d-block" alt="screenshot2">
                          </div>
                          <div class="carousel-item">
                            <img src="./images/screenshot3.png" class="d-block" alt="screenshot3">
                          </div>
                          <div class="carousel-item">
                            <img src="./images/screenshot4.png" class="d-block" alt="screenshot4">
                          </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="log-on border_insc">
                <div class="logo">
                    <img src="<?= Yii::getAlias('@web/web/images/logo.png') ?>" alt="Instagram logo">
                </div>
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                ]); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Username']) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']) ?>

                <div class="form-group">
                    <div>
                        <?= Html::submitButton('Login', ['class' => 'log_btn', 'name' => 'login-button']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
                <div class="other-ways">
                    <div class="seperator">
                        <span class="ligne"></span>
                        <span class="ou">OR</span>
                        <span class="ligne"></span>
                    </div>
                    <div class="facebook-connection">
                        <a href="#">
                            <img src="<?= Yii::getAlias('@web/web/images/facebook.png') ?>" alt="facebook icon">
                            Log in with Facebook
                        </a>
                    </div>
                    <div class="forget-password">
                        <a href="#">
                            Forgot password?
                        </a>
                    </div>
                </div>
            </div>
            <div class="sing-up border_insc">
                <p>
                    Don't have an account?
                    <a href="<?= Url::to(['site/signup']) ?>">Sign up</a>
                </p>
            </div>
            <div class="download">
                <p>Get the app.</p>
                <div>
                    <img src="<?= Yii::getAlias('@web/web/images/google_play_icon.png') ?>" alt="download app from google play">
                    <img src="
                    <?= Yii::getAlias('@web/web/images/microsoft-icon.png') ?>" alt="download app from microsoft">
                </div>
            </div>
        </div>
    </div>
</div>