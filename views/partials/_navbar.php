<?php

use app\components\Utility;
use app\models\User;
use yii\helpers\Url;
?>
<div class="nav_menu">
    <div class="fix_top">
        <!-- nav for big->medium screen -->
        <div class="nav  ps-4">
            <div class="logo">
                <a href="<?= Url::to(['site/index']) ?>">
                    <img class="d-block d-lg-none small-logo" src="<?= Yii::getAlias('@web/web/images/instagram.png') ?>" alt="logo">
                    <img class="d-none d-lg-block" src="<?= Yii::getAlias('@web/web/images/logo_menu.png') ?>" alt="logo">
                </a>
            </div>
            <div class="menu">
                <ul>
                    <li>
                        <a class="active" href="<?= Url::to(['site/index']) ?>">
                            <img src="<?= Yii::getAlias('@web/web/images/accueil.png') ?>">
                            <span class="d-none d-lg-block ">Home</span>
                        </a>
                    </li>
                    <!-- <li id="search_icon">
                                <a href="#">
                                <img src="<?= Yii::getAlias('@web/web/images/search.png') ?>">
                                    <span class="d-none d-lg-block search">Search </span>
                                </a>
                            </li>
                            <li>
                                <a href="./explore.html">
                                <img src="<?= Yii::getAlias('@web/web/images/compass.png') ?>">
                                    <span class="d-none d-lg-block ">Explore</span>
                                </a>
                            </li>
                            <li>
                                <a href="./reels.html">
                                <img src="<?= Yii::getAlias('@web/web/images/video.png') ?>">
                                    <span class="d-none d-lg-block ">Reels</span>
                                </a>
                            </li>
                            <li>
                                <a href=" ./messages.html">
                                    <img src="<?= Yii::getAlias('@web/web/images/send.png') ?> ">
                                    <span class="d-none d-lg-block ">Messages</span>
                                </a>
                            </li>
                            <li class="notification_icon">
                                <a href="void:javascript;">
                                    <?php if (Utility::getNotificationCount()) : ?>
                                        <span class="notificationBadge"><?= Utility::getNotificationCount() ?></span>
                                    <?php endif; ?>

                                    
                                    <img src="<?= Yii::getAlias('@web/web/images/love.png') ?> ">
                                    <span class="d-none d-lg-block ">Notifications</span>
                                </a>
                            </li> -->
                    <li>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#create_modal">
                            <img src=" <?= Yii::getAlias('@web/web/images/tab.png'); ?>">
                            <span class="d-none d-lg-block ">Create</span>
                        </a>

                    </li>
                    <li>
                        <a href="<?= Url::to(['/profile/index']) ?>">
                            <img class="circle story" src="<?= User::getAuthUserProfileImage() ?>">
                            <span class="d-none d-lg-block ">Profile</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="more">
                <div class="btn-group dropup">
                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= Yii::getAlias('@web/web/images/menu.png') ?>">
                        <span class="d-none d-lg-block ">More</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">
                                <span>Settings</span>
                                <img src="./images/reglage.png">
                            </a></li>
                        <li><a class="dropdown-item" href="#">
                                <span>Your activity</span>
                                <img src="./images/history.png">
                            </a></li>
                        <li><a class="dropdown-item" href="#">
                                <span>Saved</span>
                                <img src="./images/save-instagram.png">
                            </a></li>
                        <li><a class="dropdown-item" href="#">
                                <span>Switch apperance</span>
                                <img src="./images/moon.png">
                            </a></li>
                        <li><a class="dropdown-item" href="#">
                                <span>Report a problem</span>
                                <img src="./images/problem.png">
                            </a></li>
                        <li><a class="dropdown-item bold_border" href="#">
                                <span>Switch accounts</span>
                            </a></li>
                        <li><a class="dropdown-item" data-method="post" href="<?= Url::to(['/site/logout']) ?>">
                                <span>Log out</span>
                            </a></li>
                    </ul>
                </div>
                <!--  -->

            </div>
        </div>
        <!-- nav for small screen  -->
        <div class="nav_sm">
            <div class="content">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="logo" src="./images/logo_menu.png">
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">
                                <span>Following</span>
                                <img src="./images/add-friend.png">
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="#">
                                <span>Favorites</span>
                                <img src="./images/star.png">
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="left">
                    <div class="search_bar">
                        <div class="input-group">
                            <div class="form-outline">
                                <div>
                                    <img src="./images/search.png" alt="search">
                                </div>
                                <input type="search" id="form1" class="form-control" placeholder="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="notifications notification_icon">
                        <a href="./notification.html">
                            <img src="./images/love.png">
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <!-- nav for ex-small screen  -->
        <div class="nav_xm">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="logo" src="<?= Yii::getAlias('@web/web/images/logo_menu.png') ?>">
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">
                            <span>Following</span>
                            <img src="./images/add-friend.png">
                        </a></li>
                    <li><a class="dropdown-item" href="#">
                            <span>Favorites</span>
                            <img src="./images/star.png">
                        </a></li>
                </ul>
            </div>
            <div class="left">

                <img src="<?= Yii::getAlias('@web/web/images/send.png') ?>">
                <a href="./notification.html">
                    <img class="notification_icon" src="<?= Yii::getAlias('@web/web/images/love.png') ?>">
                </a>

            </div>
        </div>
    </div>
    <!-- menu in the botton for smal screen  -->
    <div class="nav_bottom">
        <a href="<?= Url::to(['site/index']) ?>"><img src="<?= Yii::getAlias('@web/web/images/accueil.png') ?>"></a>
        <a href="./explore.html"><img src="<?= Yii::getAlias('@web/web/images/compass.png') ?> "></a>
        <a href="./reels.html"><img src="<?= Yii::getAlias('@web/web/images/video.png') ?>"></a>
        <a href="#" data-bs-toggle="modal" data-bs-target="#create_modal"><img src="<?= Yii::getAlias('@web/web/images/tab.png') ?> "></a>
        <a href="<?= Url::to(['profile/index']) ?>"><img class="circle story" src="<?= Yii::getAlias('@web/web/images/profile_img.jpg') ?> .jpg"></a>
    </div>
    <!-- notification start -->
    <div id="notification" class="notification_section">
        <h2>Notifications</h2>
        <div class="notifications">

            <!-- <div class="notif story_notif">
                    <div class="cart">
                        <div>
                            <div class="img">
                                <img src="./images/profile_img.jpg" alt="">
                            </div>
                            <div class="info">
                                <div class="info">
                                    <p class="name">
                                        Zineb_essoussi
                                        <span class="desc">liked your story.</span>
                                        <span class="time">2d</span>
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="story_like">
                            <img src="./images/img2.jpg" alt="">
                        </div>
                    </div>
                </div>  -->
            <!-- <div class="notif follow_notif">
                    <div class="cart">
                        <div>
                            <div class="img">
                                <img src="./images/profile_img.jpg" alt="">
                            </div>
                            <div class="info">
                                <p class="name">
                                    Zineb_essoussi
                                    <span class="desc">started following you.</span>
                                    <span class="time">2h</span>
                                </p>

                            </div>
                        </div>
                        <div class="follow_you">
                            <button class="follow_text">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="notif follow_notif">
                    <div class="cart">
                        <div>
                            <div class="img">
                                <img src="./images/profile_img.jpg" alt="">
                            </div>
                            <div class="info">
                                <p class="name">
                                    Zineb_essoussi
                                    <span class="desc">started following you.</span>
                                    <span class="time">2h</span>
                                </p>

                            </div>
                        </div>
                        <div class="follow_you">
                            <button class="follow_text">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="notif story_notif">
                    <div class="cart">
                        <div>
                            <div class="img">
                                <img src="./images/profile_img.jpg" alt="">
                            </div>
                            <div class="info">
                                <div class="info">
                                    <p class="name">
                                        Zineb_essoussi
                                        <span class="desc">liked your story.</span>
                                        <span class="time">2d</span>
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="story_like">
                            <img src="./images/img2.jpg" alt="">
                        </div>
                    </div>
                </div> -->
            <!-- <div class="notif follow_notif">
                    <div class="cart">
                        <div>
                            <div class="img">
                                <img src="./images/profile_img.jpg" alt="">
                            </div>
                            <div class="info">
                                <p class="name">
                                    Zineb_essoussi
                                    <span class="desc">started following you.</span>
                                    <span class="time">2h</span>
                                </p>

                            </div>
                        </div>
                        <div class="follow_you">
                            <button class="follow_text">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="notif story_notif">
                    <div class="cart">
                        <div>
                            <div class="img">
                                <img src="./images/profile_img.jpg" alt="">
                            </div>
                            <div class="info">
                                <div class="info">
                                    <p class="name">
                                        Zineb_essoussi
                                        <span class="desc">liked your story.</span>
                                        <span class="time">2d</span>
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="story_like">
                            <img src="./images/img2.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="notif follow_notif">
                    <div class="cart">
                        <div>
                            <div class="img">
                                <img src="./images/profile_img.jpg" alt="">
                            </div>
                            <div class="info">
                                <p class="name">
                                    Zineb_essoussi
                                    <span class="desc">started following you.</span>
                                    <span class="time">2h</span>
                                </p>

                            </div>
                        </div>
                        <div class="follow_you">
                            <button class="follow_text">Follow</button>
                        </div>
                    </div>
                </div> -->
        </div>
    </div>
    <!-- notification end -->

</div>

<script>
    $(document).ready(function() {
        $('.notification_icon').on('click', function(e) {
            const $this = $('#notification');
            if ($this.hasClass('show')) {
                $.ajax({
                    url: '<?= Url::to(['notification/getusernotifications']) ?>',
                    method: 'post',
                    success: function(response) {
                        $('.notifications').html('');
                        // console.log(response);
                        response.notification.forEach(data => {
                            var postImg = '';
                            if (data.post_image) {
                                var postImg = `<img src="${data.post_image}" alt=""> `;
                            }
                            var content = ` <div class="notif story_notif">
                    <div class="cart">
                        <div>
                            <div class="img">
                                    <a href="${data.profile_url}" >
                                        <img src="${data.profile_image}" alt="">
                                    </a>
                            </div>
                            <div class="info">
                                <div class="info">
                                    <p class="name">
                                        ${data.username}
                                        <span class="desc">${data.message}</span>
                                        <span class="time">${data.created_at}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="story_like">
                            ${postImg}
                        </div>
                    </div>
                </div> `;
                            $('.notifications').append(content);
                        });
                    }
                });
            }

        });


        $(document).ready(function() {
            // Click event for notification icon
            $('.notification_icon').on('click', function() {
                changeNotificationStatus();
            });

            // Click event for the notification cart image
            // $('body').on('click', '.notifications .cart .img', function() {
            //     changeNotificationStatus();
            // });

            function changeNotificationStatus() {
                // Check if the badge is already hidden to prevent multiple requests
                if ($('.notificationBadge').is(':hidden')) {
                    return; // Do nothing if the badge is already hidden
                }

                // Send the AJAX request to mark notifications as read
                $.ajax({
                    url: '<?= Url::to(['notification/changenotificationstatus']) ?>', // Replace with your correct URL
                    method: 'POST', // Use POST for changing status
                    success: function(response) {
                        if (response.success) {
                            // If the server responds with success, hide the badge
                            $('.notificationBadge').hide();
                        } else {
                            console.log('Failed to update notification status');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX error:', error);
                    }
                });
            }
        });



    })
</script>