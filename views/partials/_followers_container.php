<?php
use app\models\User;
use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\components\Utility;

?>


<div class="followers_container">
                <div>
                <div class="cart">
                        <div>
                            <div class="img">
                                <img src="<?= User::getAuthUserProfileImage() ?>" alt="">
                            </div>
                            <div class="info">
                                <p class="name"><?= Yii::$app->user->identity->username ?></p>
                                <p class="second_name"><?= Yii::$app->user->identity->getBio()['nick_name']??null ?></p>
                            </div>
                        </div>
                        <div class="switch">
                            <a href="#">Switch</a>
                        </div>
                    </div>
            
                  
                    <div class="suggestions">
                    <div class="title">
                            <h4>Suggestions for you</h4>
                            <a class="dark" href="#">See All</a>
                        </div>
                    <?php foreach($users as $user):
                    // echo "<pre>";
                    // print_r($user->is_following());
                    // exit;
                        ?>
                       
                        <div class="cart">
                            <div>
                                <div class="img">
                                     <?= Html::img($user->getProfileimage())?>
                                    
                                </div>
                                <div class="info">
                                    <p class="name"><?= html::encode($user->username) ?></p>
                                    <p class="second_name"><?= html::encode($user->getBio()['nick_name']??null) ?></p>
                                </div>
                            </div>
                            <div class="switch">
                                <button class="follow_text followBtn" href="#" data-user-id='<?= html::encode($user->uuid) ?>'>
                                    
                                    <?php 
                                       $is_following = $user->getFollowers()->where([
                                            'user_id'=>Yii::$app->user->id
                                        ])->one();
                                    ?>
                                <?= $is_following?'Following':'Follow'; ?>
                                </button>
                            </div>
                        </div>
                         <!--<div class="cart">
                            <div>
                                <div class="img">
                                    <img src="./images/profile_img.jpg" alt="">
                                </div>
                                <div class="info">
                                    <p class="name">Zineb_essoussi</p>
                                    <p class="second_name">Zim Ess</p>
                                </div>
                            </div>
                            <div class="switch">
                                <button class="follow_text" href="#">follow</button>
                            </div>
                        </div>
                        <div class="cart">
                            <div>
                                <div class="img">
                                    <img src="./images/profile_img.jpg" alt="">
                                </div>
                                <div class="info">
                                    <p class="name">Zineb_essoussi</p>
                                    <p class="second_name">Zim Ess</p>
                                </div>
                            </div>
                            <div class="switch">
                                <button class="follow_text" href="#">follow</button>
                            </div>
                        </div> -->
                        <?php endforeach ;?>

                    </div>

           </div>
 </div>
<script>
    $(document).ready(function(){
        $('button.follow_text').on('click', function(){
            var $this = $(this);
           var followerId = $(this).data('user-id');
            $.ajax({
                url:'<?= Url::to(['followers/followstatus']) ?>',
                method:'post',
                data:{
                    followerId:followerId
                },
                success:function(data){
                    if(data.success){
                        if(data.is_following){
                            $this.text('Following');
                            console.log('following');
                        }else{
                            $this.text('Follow');
                            console.log('not following');
                        }
                     
                    }
                }
            });
        })
    })
</script>