<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>








<div id="message">
    <div class="message_container">
        <div class="persons">
            <div class="account_name">
                <p>Zineb_essoussi</p>
                <p class="search">
                    <img src="./images/edit.png" alt="edit">
                </p>
            </div>
            <div class="account_message">
                <div class="desc">
                    <p>Messages</p>
                    <p><a href="#">3 requests</a></p>
                </div>
                 <?php foreach ($friends as $user): ?>
                    <div class="cart">
                    <div>
                        <div class="img">
                            <img src="<?= Yii::getAlias('@web/web/'.$user->profile_image)?>" alt="">
                        </div>
                        <div class="info">
                            <p class="name"><?= Html::encode($user->username) ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
           
                <!-- <div class="cart">
                    <div>
                        <div class="img">
                            <img src="./images/profile_img.jpg" alt="">
                        </div>
                        <div class="info">
                            <p class="name">Zineb_essoussi</p>
                        </div>
                    </div>

                </div>
                <div class="cart">
                    <div>
                        <div class="img">
                            <img src="./images/profile_img.jpg" alt="">
                        </div>
                        <div class="info">
                            <p class="name">Zineb_essoussi</p>
                        </div>
                    </div>

                </div>
                <div class="cart">
                    <div>
                        <div class="img">
                            <img src="./images/profile_img.jpg" alt="">
                        </div>
                        <div class="info">
                            <p class="name">Zineb_essoussi</p>
                        </div>
                    </div>

                </div>
                <div class="cart">
                    <div>
                        <div class="img">
                            <img src="./images/profile_img.jpg" alt="">
                        </div>
                        <div class="info">
                            <p class="name">Zineb_essoussi</p>
                        </div>
                    </div>
                </div>
                <div class="cart">
                    <div>
                        <div class="img">
                            <img src="./images/profile_img.jpg" alt="">
                        </div>
                        <div class="info">
                            <p class="name">Zineb_essoussi</p>
                        </div>
                    </div>

                </div>
                <div class="cart">
                    <div>
                        <div class="img">
                            <img src="./images/profile_img.jpg" alt="">
                        </div>
                        <div class="info">
                            <p class="name">Zineb_essoussi</p>
                        </div>
                    </div>

                </div>
                <div class="cart">
                    <div>
                        <div class="img">
                            <img src="./images/profile_img.jpg" alt="">
                        </div>
                        <div class="info">
                            <p class="name">Zineb_essoussi</p>
                        </div>
                    </div>

                </div> -->
            </div>
        </div>
        <div class="message">
            <div class="messageContainer">
                <div class="options">
                    <div class="cart">
                        <div>
                            <div class="img">
                                <img src="./images/profile_img.jpg" alt="">
                            </div>
                            <div class="info">
                            </div>
                        </div>
                    </div>
                    <div class="other">
                        <a href="#">
                            <img src="./images/telephone.png" alt="call">
                        </a>
                        <a href="#">
                            <img src="./images/video_call.png" alt="video call">
                        </a>
                    </div>
                </div>
                <div class="content">
                    <!-- <?php foreach ($messages as $message): ?> -->

                    <!-- <div class="my_message">
                        <p class="p_message">hello how are you?</p>
                    </div>
                    <div class="response_message">
                        <p class="p_message">hi! i'm fine and you?</p>
                    </div>
                    <div class="my_message">
                        <p class="p_message">I'm good </p>
                    </div>
                    <div class="response_message">
                        <p class="p_message">I'll come tomorrow</p>
                    </div> -->
                    <!-- <div class="my_message">
                        <?= Html::encode($message->content) ?>
                    </div>
                    <?php endforeach; ?> -->

                </div>
           

                <!-- Form to send a new message -->
                <!-- <form id="message-form">
                    <textarea id="message-text" placeholder="Type a message..."></textarea>
                    <button type="submit">Send</button>
                </form> -->
                <form id="message-form">
                    <input type="text" id="emoji" placeholder="write your email" />
                </form>
            </div>





        </div>
    </div>
</div>


















<script>
    document.getElementById('message-form').onsubmit = function(e) {
        e.preventDefault();
        var messageText = document.getElementById('message-text').value;
        var receiverId = 1;
        $.get('<?= Url::to(['message/send']) ?>', {
            receiverId: receiverId,
            messageText: messageText
        }, function(response) {
            if (response.success) {
                // Append the new message to the conversation
                var message = '<div><strong>Me:</strong> ' + messageText + '</div>';
                $('.content').append(message);
                $('#message-text').val('');
            } else {
                alert('Failed to send message');
            }
        });
    };
</script>