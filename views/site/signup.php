<?php


use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

?>
    



  
        
<div class="container">
        <div class="sign_up">
            <div class="content">
                <div class="log-on border_insc">
                    <div class="logo">
                        <img src="<?=Yii::getAlias('@web/web/images/logo.png')?> " alt="Instagram logo">
                        <p>Sign up to see photos and videos from your friends.</p>
                        <button class="btn log_fac">
                            <a href="#">
                                <img src="<?=Yii::getAlias('@web/web/images/facebook_white.png')?>" alt="facebook icon">
                                Log in with Facebook
                            </a>
                        </button>
                        <div class="seperator">
                            <span class="ligne"></span>
                            <span class="ou">OR</span>
                            <span class="ligne"></span>
                        </div>

                    </div>
                    <?php $form = ActiveForm::begin([
                            'id' => 'signup-form',
                            'fieldConfig' => [
                                'template' => "{label}\n{input}\n{error}",
                            ],
                        ]); ?>
                        <div>
                             <?= $form->field($model, 'email')->textInput(['type'=>'email','placeholder'=>'Email Address']) ?>
                        </div>
                        <div>
                            <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder'=>'Username']) ?>
                        </div>
                        <div>
                         <?= $form->field($model, 'password_hash')->passwordInput(['placeholder'=>'Password'])->label('Password') ?>
                        </div>
                        <div class="info">
                            <p>
                                People who use our service may have uploaded your contact information to Instagram. 
                                <a href="#">Learn more</a>
                            </p>
                            <p>
                                By signing up, you agree to our 
                                <a href="#">Terms, Privacy Policy and Cookies Policy.</a> 
                            </p>
                        </div>
                        
                        <?= Html::submitButton('Sign Up', ['class' => 'log_btn', 'name' => 'login-button']) ?>
                        <?php ActiveForm::end(); ?>

    
                </div>
                <div class="sing-in border_insc">
                    <p>
                        Have an account? 
                        <a href="./login.html">Log in</a>
                    </p>
                </div>
                <div class="download">
                    <p>Get the app.</p>
                    <div>
                        <img src="./images/google_play_icon.png" alt="download app from google play">
                        <img src="./images/microsoft-icon.png" alt="download app from microsoft">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
       

