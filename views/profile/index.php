<?php

use app\models\Posts;
use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\helpers\StringHelper;

// echo '<pre>';
// print_r($model->getBio());
// exit;

?>



<!-- Profile Container start -->

<div class="profile_container">
    <div class="profile_info">
        <p>test</p>
        <div class="cart">
            <div class="img">
                <img src='<?= $model->getProfileimage() ?>'>

                <!-- <img src="./images/profile_img.jpg" alt=""> -->
            </div>
            <div class="info">
                <p class="name">
                    <?= Html::encode($model->username) ?>
                    <?php if (!Yii::$app->user->isGuest && $model->id == Yii::$app->user->id) : ?>
                        <a href="<?= Url::to(['/profile/edit']) ?>" class="edit_profile">
                            Edit profile
                        </a>
                    <?php else : ?>
                        <?php
                        $is_following = $model->getFollowers()->where([
                            'user_id' => Yii::$app->user->id
                        ])->one();
                        $followback = $model->getFollowers0()->where([
                            'follower_id' => Yii::$app->user->id
                        ])->one();
                        $text = '';
                        $class = '';
                        if ($followback && !$is_following) {
                            $text = 'Follow Back';
                        } elseif ($followback && $is_following) {
                            $class = 'greyBtn';
                            $text = 'Following';
                        } elseif ($is_following) {
                            $class = 'greyBtn';
                            $text = 'Following';
                        } else {
                            $class = 'blueBtn';
                            $text = 'Follow';
                        }

                        ?>

                        <a href="javascript:void(0);" data-user-profile="1" data-user-id="<?= $model->uuid ?>" class="statusBtn <?= $class ?>"><?= $text ?></a>
                    <?php endif; ?>

                </p>
                <div class="general_info">
                    <p><span><?= $model->getPosts()->count() ?></span> post</p>
                    <p>

                        <?= Html::a(
                            '<span> ' . $model->getFollowers()->count() . '</span> followers',
                            [''],
                            [
                                'class' => 'seeFollowers',
                                'data-bs-toggle' => "modal",
                                'data-bs-target' => "#followersModal",
                            ]
                        )  ?>
                    </p>
                    <p>
                        <?= Html::a(
                            '<span> ' . $model->getFollowers0()->count() . '</span> following',
                            [''],
                            [
                                'class' => 'seeFollowing',
                                'data-bs-toggle' => "modal",
                                'data-bs-target' => "#followingModal",
                            ]
                        )  ?>
                    </p>
                </div>
                <p class="nick_name"><?= $model->getBio()['nick_name'] ?? null ?></p>
                <p class="desc">
                    <?= $model->getBio()['desc'] ?? null ?>
                </p>
            </div>
        </div>
    </div>
    <!-- Latest Hignlights Start-->
    <div class="highlights">



        <?php foreach ($latestPosts = $model->getPosts()
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(5)
            ->all() as $post) : ?>
            <div class="highlight">
                <div class="img">
                    <img src="<?= Yii::getAlias('@web/web/' . $post->image_path); ?>" alt="">
                </div>
                <p><?= StringHelper::truncateWords(strip_tags($post->caption), 1, '...') ?></p>
            </div>

        <?php endforeach; ?>
        <script>
            console.log(document.cookie);
        </script>
        <!-- 
                   <div class="highlight">
                    <div class="img">
                        <img src="./images/profile_img.jpg" alt="">
                    </div>
                    <p>conseils</p>
                </div>
                <div class="highlight highlight_add">
                    <div class="img">
                        <img src="./images/plus.png" alt="">
                    </div>
                    <p>New</p>
                </div> -->
    </div>
    <!-- Latest Hignlights End -->
    <hr>
    <div class="posts_profile">
        <ul class="nav-pills w-100 d-flex justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item mx-2" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                    <img src="<?= Yii::getAlias('@web/web/images/feed.png') ?>" alt="posts">
                    POSTS
                </button>
            </li>
            <li class="nav-item mx-2" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
                    <img src="<?= Yii::getAlias('@web/web/images/save-instagram.png') ?>" alt="saved posts">

                    SAVED
                </button>
            </li>
            <li class="nav-item mx-2" role="presentation">
                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">
                    <img src="<?= Yii::getAlias('@web/web/images/tagged.png') ?>" alt="tagged posts">

                    TAGGED
                </button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <div id="posts_sec" class="post">

                    <?php
                    echo $this->render('_user_posts', [
                        'model' => $model
                    ]);
                    ?>

                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                <div id="saved_sec" class="post">
                    <div class="item">
                        <img class="img-fluid item_img" src="https://i.ibb.co/6WvdZS9/account12.jpg" alt="">
                    </div>
                    <div class="item">
                        <img class="img-fluid item_img" src="https://i.ibb.co/pJ8thst/account13.jpg" alt="">
                    </div>

                </div>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                <div id="tagged" class="post">
                    <div class="item">
                        <img class="img-fluid item_img" src="https://i.ibb.co/Zhc5hHp/account4.jpg" alt="">
                    </div>
                    <div class="item">
                        <img class="img-fluid item_img" src="https://i.ibb.co/SPTNbJL/account5.jpg" alt="">
                    </div>
                </div>
            </div>

        </div>
    </div>






    <!-- Followers Modal -->
    <div class="modal fade" id="followersModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h5 class="modal-title mx-auto" id="">Followers</h5>
                    <button type="button" class="btn-close m-0 p-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-2">
                    <div class="followersList">

                    </div>
                </div>
                <!-- <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div> -->
            </div>
        </div>
    </div>
    <!-- Followers Modal End-->



    <!-- Following Modal -->
    <div class="modal fade" id="followingModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h5 class="modal-title mx-auto" id="">Following</h5>
                    <button type="button" class="btn-close m-0 p-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-2">
                    <div class="followersList">

                    </div>
                </div>
                <!-- <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div> -->
            </div>
        </div>
    </div>
    <!-- Following Modal End-->







</div>
<!--Create model-->
<?php
echo $this->render('../partials/_create_model', [
    'model' => new Posts()
]);
?>
<!-- Create model end -->
<!-- Profile Container end -->


<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') // CSRF token header
            }
        });

        // $('#followersModal').on('shown.bs.modal', function(event){
        //     var button = $(event.relatedTarget);
        //     console.log('data');
        //     $.ajax({
        //         url:'<?= Url::to(['followers/getfollowers']) ?>',
        //         method:'get',
        //         success:function(response){
        //             $('.followersList').html('');
        //             response.forEach(function(data){
        //                 $content = `  <div class="followers mb-2" id="follower">
        //                             <div class="d-flex justify-content-between w-100 align-items-center">
        //                                 <div class="content d-flex ms-2">
        //                                     <div class="img"><img src="${data.profile_image} " alt="Profile image"></div>
        //                                     <div class="person d-flex ms-2">
        //                                         <h6>${data.username}</h6><span></span></div>
        //                                         <p>
        //                                         </p>
        //                                 </div>
        //                                 <div>
        //                                     <a href="void:javascript"  data-follower-id='${data.follower_id}' class="followStatusBtn">Remove</a>
        //                                 </div>
        //                             </div>
        //                         </div>`;
        //                         $('.followersList').append($content);
        //             });



        //         }
        //     });
        // });




        // $('body').on('click','.followStatusBtn', function(e){
        //     e.preventDefault();
        //     var element = $(this);
        //     // console.log(response);
        //    var followerId= element.data('follower-id');
        //     $.ajax({
        //         url:'<?= Url::to(['followers/removefollower']) ?>',
        //         method:'post',
        //         data:{
        //             followerId:followerId
        //         },
        //         success:function(response){
        //             if(response.success){
        //                 element.text('Removed');
        //             }
        //         }

        //     });
        // });






        // $('#followingModal').on('shown.bs.modal', function(event){
        //     var button = $(event.relatedTarget);
        //     console.log('data');
        //     $.ajax({
        //         url:'<?= Url::to(['followers/getfollowing']) ?>',
        //         method:'get',
        //         success:function(response){
        //             $('.followersList').html('');
        //             response.forEach(function(data){
        //                 $content = `  <div class="followers mb-2" id="follower">
        //                             <div class="d-flex justify-content-between w-100 align-items-center">
        //                                 <div class="content d-flex ms-2">
        //                                     <div class="img"><img src="${data.profile_image} " alt="Profile image"></div>
        //                                     <div class="person d-flex ms-2">
        //                                         <h6>${data.username}</h6><span></span></div>
        //                                         <p>
        //                                         </p>
        //                                 </div>
        //                                 <div>
        //                                     <a href="void:javascript" data-user-id=""  data-following-id='${data.following_id}' class="followingStatusBtn">Following</a>
        //                                 </div>
        //                             </div>
        //                         </div>`;
        //                         $('.followersList').append($content);
        //             });



        //         }
        //     });
        // });


        // $('body').on('click','.followingStatusBtn', function(e){
        //     e.preventDefault();
        //     var element = $(this);
        //     // console.log(response);
        //    var followingId= element.data('following-id');
        //     $.ajax({
        //         url:'<?= Url::to(['followers/removefollowing']) ?>',
        //         method:'post',
        //         data:{
        //             followingId:followingId
        //         },
        //         success:function(response){
        //             if(response.success){
        //                 element.replaceWith(`
        //                 <a 
        //                     href="javascript:void(0);" 
        //                     data-user-id="${response.user_id}" class="follow btn btn-primary ">
        //                     Follow
        //                 </a>`);

        //             }



        //         }

        //     });
        // });



        // $('body').on('click','.follow', function(e){
        //     e.preventDefault();
        //     var $this = $(this);
        //    var followerId = $(this).data('user-id');
        //    if(followerId.length>0){
        //     $.ajax({
        //         url:'<?= Url::to(['followers/followstatus']) ?>',
        //         method:'post',
        //         data:{
        //             followerId:followerId
        //         },
        //         success:function(data){
        //             if(data.success){
        //                 if(data.is_following){
        //                     $this.text('Following');
        //                     console.log('following');
        //                 }else{
        //                     $this.text('Follow');
        //                     console.log('not following');
        //                 }

        //             }
        //         }
        //     });


        // }
        // })




        // Caching DOM Elements
        var $followersList = $('.followersList');
        var offset = 0;
        var limit = 10;
        var loading = false;
        var totalPosts = 0; // You need to set this from your server response

        // Function to populate followers/following list
        function populateList(url, modalType, offset, limit) {
            var id = '<?= Yii::$app->request->get('id') ?>' || null;


            $.ajax({
                url: url,
                method: 'get',
                data: {
                    id: id,
                    offset: offset,
                    limit: limit,
                },
                success: function(response) {
                    totalPosts = response.totalPosts || 0; // Assuming the server returns totalPosts count
                    $followersList.html(''); // Clear previous content

                    if (response.list.length > 0) {
                        response.list.forEach(function(data) {
                            var $subContent = '';
                            var $rightSubcontent = '';
                            var customClass = '';
                            var text = '';


                            // If the current user is not the same as the user in data
                            if (!data.is_current_user) {
                                if (modalType === 'followers') {
                                    // Followers logic
                                    if (data.is_follower == 0 && data.is_following == 0) {
                                        customClass = 'blueBtn';
                                        text = 'Follow';
                                    } else if (data.is_follower == 1 && data.is_following == 1) {
                                        text = 'Remove'; // Could also add an action for Remove
                                    } else if (data.is_follower == 1 && data.is_following == 0) {
                                        text = 'Following';
                                    } else if (data.is_following == 1 && data.is_follower == 0) {
                                        text = 'Remove';
                                        $subContent = `<a href="javascript:void(0);" data-follow-type="followers" data-user-id="${data.uid}" class="statusBtn ms-2">Follow</a>`;
                                    }
                                } else {
                                    // Following logic
                                    if (data.is_follower == 1) {
                                        text = 'Following';
                                    } else if (data.is_follower == 0) {
                                        customClass = 'blueBtn';
                                        text = 'Follow';
                                    }
                                }

                                $rightSubcontent = `<a href="javascript:void(0);" data-user-id="${data.uid}"
                                            data-id="${modalType === 'followers' ? data.follower_id : data.following_id}" 
                                            class="statusBtn greyBtn ${customClass}">${text}</a>`;
                            }

                            // Building HTML content
                            var $content = `
                        <div class="followers mb-3" id="follower-${data.id}">
                            <div class="d-flex justify-content-between w-100 align-items-center">
                                <div class="content align-items-center d-flex ms-2">
                                    <div class="img"><img src="<?= Yii::getAlias('@web'); ?>${data.profile_image || '/web/images/profile_img.jpg'}" alt="Profile image"></div>
                                    <div class="d-flex flex-column ms-3">
                                        <div class="person">
                                            <span class="username">${data.username}</span>
                                            <span class="circle"></span>
                                            ${$subContent}
                                        </div>
                                        <div class="nick_name">
                                            ${data.bio && JSON.parse(data.bio).nick_name ? JSON.parse(data.bio).nick_name : ''}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    ${$rightSubcontent}
                                </div>
                            </div>
                        </div>
                    `;
                            $followersList.append($content);
                        });
                    } else {
                        $followersList.text('No user');
                    }
                },
                error: function() {
                    alert('Failed to load data');
                }
            });
        }

        // Modal Trigger - Fetch Followers
        $('#followersModal').on('shown.bs.modal', function() {

            populateList('<?= Url::to(['followers/getfollowers']) ?>', 'followers', offset, limit);
        });

        // Modal Trigger - Fetch Following
        $('#followingModal').on('shown.bs.modal', function() {

            populateList('<?= Url::to(['followers/getfollowing']) ?>', 'following', offset, limit);
        });

        // Infinite Scroll - Load more users as user scrolls
        $(document).on('scroll', '.modal-body', function() {
            console.log('Is followingModal open? ', $('#followingModal').hasClass('show')); // Check if following modal is open
            console.log("Scroll event triggered");
            var scrollPosition = $(this).scrollTop() + $(this).height();
            var documentHeight = $(this)[0].scrollHeight;
            console.log("Scroll position: ", scrollPosition, "Document height: ", documentHeight);

            if (scrollPosition >= documentHeight - 10 && !loading && offset < totalPosts) {
                loading = true;
                offset += limit;
                var url = $('#followersModal').hasClass('show') ? '<?= Url::to(['followers/getfollowers']) ?>' : '<?= Url::to(['followers/getfollowing']) ?>';
                var modalType = $('#followersModal').hasClass('show') ? 'followers' : 'following';
                populateList(url, modalType, offset, limit);
                setTimeout(function() {
                    loading = false;
                }, 1000);
            }
        });






        var is_other_user = '<?= Yii::$app->request->get('id') ?>';

        // console.log(is_other_user);

        // Unified Event Handler for both Follow and Remove actions
        $('body').on('click', '.statusBtn', function(e) {
            e.preventDefault();
            var $this = $(this);
            var id = $this.data('user-id');

            // console.log(id);

            if ($this.text() === 'Remove') {
                // Remove Follower
                $.ajax({
                    url: '<?= Url::to(['followers/removefollower']) ?>',
                    method: 'post',
                    data: {
                        followerId: id
                    },
                    success: function(response) {
                        if (response.success) {
                            if (is_other_user == '') {
                                $this.text('Removed').attr('disabled', true);
                            } else {
                                $this.text('Follow').addClass('blueBtn').parent().parent().find('.person a').remove();

                            }

                            // $this.closest('.followers').remove(); // Remove the follower element
                            // $this.text('Follow').addClass('blueBtn').parent().parent().find('.person a').remove();
                        }
                    },
                    error: function() {
                        alert('Failed to remove follower');
                    }
                });
            } else if ($this.text() === 'Following') {
                // Remove Following
                $.ajax({
                    url: '<?= Url::to(['followers/removefollowing']) ?>',
                    method: 'post',
                    data: {
                        followingId: id
                    },
                    success: function(response) {

                        if (response.success) {
                            if (response.is_following == 1 && $this.data('user-profile')) {
                                $this.text('Follow Back').addClass('greyBtn');
                                console.log(response.is_following);
                            } else {
                                $this.text('Follow').addClass('blueBtn'); // Change button to Follow
                            }
                        }
                    },
                    error: function() {
                        alert('Failed to remove following');
                    }
                });
            } else if ($this.text() == 'Follow' || $this.text() == 'Follow Back') {
                // Follow User
                var followerId = $this.data('user-id');
                console.log(followerId);
                $.ajax({
                    url: '<?= Url::to(['followers/followstatus']) ?>',
                    method: 'post',
                    data: {
                        followerId: followerId
                    },
                    success: function(response) {
                        if (response.success) {
                            if ($this.data('follow-type') == 'followers') {
                                $this.text('');
                            } else {
                                $this.text('Following').removeClass('blueBtn').addClass('greyBtn'); // Change to Following
                            }

                        }
                    },
                    error: function() {
                        alert('Failed to follow');
                    }
                });
            }
        });



    });
</script>