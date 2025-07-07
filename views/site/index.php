<?php 

use app\models\User;
use yii\helpers\Url;

?>


        <div id="search" class="search_section">
            <h2>Search</h2>
            <form method="post">
                <input type="text" placeholder="Search">
            </form>
            <div class="find">
                <div class="desc">
                    <h4>Recent</h4>
                    <p><a href="#">Clear all</a></p>
                </div>
                <div class="account">
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
                        <div class="clear">
                            <a href="#">X</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- search  -->
        <!-- notification -->
       <!-- notification end -->
        <!--***** nav menu end ****** -->

        <div class="second_container">
            <!--***** posts_container start ****** -->
            <div class="main_section">
                <div class="posts_container">
                    <div class="stories">
                        <div class="owl-carousel items">
                        </div>
                    </div>

                    <!-- <div class="posts">
                    </div> -->

                    <div class="postsList">
                            <div class="posts mb-5">
                             


                           
                            </div>
                    </div>
                    <div class="d-flex justify-content-center  mb-5">
                                <div class="spinner-border loadSpinner" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                </div>
            </div>
            <!--***** posts_container end ****** -->

            <!--***** followers_container start ****** -->
            <?php
                echo $this->render('../partials/_followers_container',[
                    'users'=>   $suggestions
                ]);
                ?>
            <!--***** followers_container end ****** -->

        </div>

        <!-- Modal for sending posts-->
        <div class="modal fade" id="send_message_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Share</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="send">
                            <div class="search_person">
                                <p>To:</p>
                                <input type="text" placeholder="Search">
                            </div>
                            <p>Suggested</p>
                            <div class="poeple">
                                <div class="person">
                                    <div class="d-flex">
                                        <div class="img">
                                            <img src="./images/profile_img.jpg" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="person">
                                                <h4>namePerson</h4>
                                                <span>zim ess</span>
                                            </div>
                                        </div>
                                    </div>
                                    <di class="circle">
                                        <span></span>
                                </div>
                            </div>
                            <div class="person">
                                <div class="d-flex">
                                    <div class="img">
                                        <img src="./images/profile_img.jpg" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="person">
                                            <h4>namePerson</h4>
                                            <span>zim ess</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="circle">
                                    <span></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Send</button>
                    </div>
                </div>

            </div>
        </div>

       
      <!-- Modal for add messages-->
      <div class="modal fade" id="message_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header px-3 py-2">
                        <h1 class="modal-title mx-auto fs-5" id="exampleModalLabel">Comments</h1>
                        <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Comments start -->
                        <!-- <div class="comments">
                            <div class="comment">
                                <div class="d-flex">
                                    <div class="img">
                                        <img src="./images/profile_img.jpg" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="person">
                                            <h4>namePerson</h4>
                                            <span>3j</span>
                                        </div>
                                        <p>Wow amzing shot</p>
                                        <div class="replay">
                                            <button class="replay">replay</button>
                                            <button class="translation">see translation</button>
                                        </div>
                                        <div class="answers">
                                            <button class="see_comment">
                                                <span class="hide_com">Hide all responses</span>
                                                <span class="show_c"> <span class="line"></span> See the <span> 1
                                                    </span> answers</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="like">
                                    <img class="not_loved" src="./images/love.png" alt="">
                                    <img class="loved" src="./images/heart.png" alt="">
                                    <p> 55</p>
                                </div>
                            </div>
                            <div class="responses">
                                <div class="response comment">
                                    <div class="d-flex">
                                        <div class="img">
                                            <img src="./images/profile_img.jpg" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="person">
                                                <h4>namePerson</h4>
                                                <span>3j</span>
                                            </div>
                                            <p>Wow amzing shot</p>
                                            <div class="replay">
                                                <button>replay</button>
                                                <button>see translation</button>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="like">
                                        <img class="not_loved" src="./images/love.png" alt="">
                                        <img class="loved" src="./images/heart.png" alt="">
                                        <p> 55</p>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                       <!-- Comments end -->
                    </div>
                    <div class="modal-footer">
                        <form id="comment-form" method="post" action="">
                            <div class="input">
                                <img src="<?= User::getAuthUserProfileImage() ?>" alt="">
                                <!-- <input value="" class="replyToPerson"/> -->
                                <input type="text" id="emoji_comment" placeholder="Add a comment..." />
                                <a href="Void:javascript" class="postComment">Post</a>
                            </div>
                            <!-- <div class="emogi">
                                <img src="./images/emogi.png" alt="">
                            </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!--Create model-->
        <?php
        echo $this->render('../partials/_create_model',[
            'model'=>$post
        ]);
        ?>
        <!-- Create model end -->
 





    <script>
    $('.loadSpinner').hide();

$(document).ready(function() {


    $.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') // CSRF token header
    }
});



    var offset = 0;      
    var limit = 5;      
    var loading = false; 
    var totalPosts = <?= $totalPosts ?>;

    // Hide the spinner initially
    $('.loadSpinner').hide();

    // Initial load of posts
    loadPosts(offset, limit);

    // Function to load posts via AJAX
    function loadPosts(offset, limit) {
        // If there are no more posts, don't send an AJAX request
      
        $.ajax({
            url: '<?= Url::to(['posts/fetchposts']); ?>',  // URL to fetch posts
            type: 'GET',
            data: {
                offset: offset,
                limit: limit
            },
            beforeSend: function() {
                // Show the spinner before making the request
         
                    $('.loadSpinner').show();
            },
            success: function(response) {
                // Append the new posts to the container
                $('.posts').append(response);
                console.log('Posts loaded successfully.');

                // Update the offset for the next batch
                offset += limit;
                loading = false;  // Reset the loading flag
                $('.loadSpinner').hide();  // Hide the spinner after loading posts

    
               
            },
            error: function() {
                // Handle error if the request fails
                alert('Error loading posts.');
                loading = false;  // Reset loading in case of an error
                $('.loadSpinner').hide();  
            }
        });
    }

    $(window).scroll(function() {
        var scrollPosition = $(window).scrollTop() + $(window).height();
        var documentHeight = $(document).height();

        // console.log("Scroll Position: " + scrollPosition);
        // console.log("Document Height: " + documentHeight);

        if (scrollPosition >= documentHeight - 10) {
            // console.log("Bottom reached, making AJAX request.");
           
            if (!loading && offset < totalPosts) {
                loading = true;  
                offset = offset+limit;
             
                loadPosts(offset, limit);  
            }
        
        }
    });





// Like feature script

 $('body').on('click','.like-button',function(){
    $(this).toggleClass('active');
   var status = $(this).hasClass('active')?1:0;
   var element = $(this).parent().next().find('a');
   var count = parseInt(element.text(), 10); 
     status ?count++:count--;
      element.text(count+' likes');

    $.ajax({
        url:'<?= Url::to(['like/changestatus']) ?>',
        method:'post',
        data:{
            status:status,
            postId:$(this).data('post-id')
        },
        success:function(response){


        }
    })
})






// Comments script

$('#message_modal').on('shown.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var postId = button.data('post-id'); // Assuming you have a 'data-post-id' attribute in your button



    var modalBody = $(this).find('.modal-body'); // Get modal body
    $('#message_modal').attr('data-post-id', postId);
    // Clear any existing content in the modal body
    modalBody.empty();
    // console.log(modalBody);
    // Make an AJAX request to get the comments
    $.ajax({
        url: '<?= Url::to(['comments/getcomments']) ?>', // The action URL
        type: 'GET',
        data: { postId: postId },
        dataType: 'json', 
        success: function (data) {
    // Check if we got comments
if (data.length > 0) {
    data.forEach(function(comment) {
        var replyBtn = '';
        if(comment.replies.length>0){
            replyBtn = '<div class="answers">' +
                            '<button class="see_comment">' +
                                '<span class="hide_com">Hide all responses</span>' +
                                '<span class="show_re"> <span class="line"></span> See the <span class="answer-count">' + comment.replies.length + '</span> answers</span>' +
                            '</button>' +
                        '</div>'
        };
        var commentHtml = '<div class="comments"   data-comment-id="'+comment.id+'">' +
            '<div class="comment" id="comment-'+comment.id+'">' +
                '<div class="d-flex">' +
                    '<div class="img">' +
                        '<img src="'+comment.profile_image+'" alt="Profile image">' + // You can replace with actual user profile image
                    '</div>' +
                    '<div class="content">' +
                        '<div class="person">' +
                            '<h4>' + comment.username + '</h4>' +
                            '<span>' + comment.created_at + '</span>' +
                        '</div>' +
                        '<p>' + comment.content + '</p>' +
                        '<div class="replay">' +
                            '<button class="replay">Reply</button>' +
                            '<button class="translation">See Translation</button>' +
                        '</div>' +
                        replyBtn+
                    '</div>' +
                '</div>' +

                // Like section
                '<div class="like">'+   
                    '<div class="likeContainer">'+
                        '<div class="commentLike-button ' + (comment.like_status ? 'active' : '') + '" data-comment-id="'+comment.id+'">' + 
                            '<div class="heart" id="likeHeart"></div>'+
                        '</div>'+
                    '</div>'+
                    '<p style="margin-top: 10px;margin-right: 9px;">'+comment.likes_count+'</p>'+
                '</div>' +
            '</div>'; // End of .comment div

        // Add the replies if any
        if (comment.replies.length > 0) {
            commentHtml += '<div class="responses" id="responses-for-comment-'+comment.id+'">';
            comment.replies.forEach(function(reply) {
                commentHtml += '<div class="response comment">' +
                    '<div class="d-flex">' +
                        '<div class="img">' +
                            '<img src="'+reply.profile_image+'" alt="Profile image">' + // Assuming replies have profile image too
                        '</div>' +
                        '<div class="content">' +
                            '<div class="person">' +
                                '<h4>' + reply.username + '</h4>' +
                                '<span>' + reply.created_at + '</span>' +
                            '</div>' +
                            '<p>' + reply.content + '</p>' +
                        '</div>' +
                    '</div>' +
                    '<div class="like">'+   
                        '<div class="likeContainer">'+
                            '<div class="commentLike-button ' + (reply.like_status ? 'active' : '') + '" data-comment-id="'+reply.id+'" >' + 
                                '<div class="heart" id="likeHeart"></div>'+
                            '</div>'+
                        '</div>'+
                        '<p style="margin-top: 10px;margin-right: 9px;">'+reply.likes_count+'</p>'+
                    '</div>' +
                '</div>';
            });
            commentHtml += '</div>'; // Closing the responses div
        }else{
            commentHtml += '<div class="responses" id="responses-for-comment-'+comment.id+'"></div>';
    
        }

        commentHtml += '</div>'; // Closing the .comments div
        $('.modal-body').get(0).offsetHeight;
        // Append the comment HTML to the modal body
        modalBody.append(commentHtml);
    });
} else {
    modalBody.append('<p class="emptyTemplete">No comments yet.</p>');
}

$('.responses').addClass('hide');
$('.show_re').show();
$('.hide_com').addClass('hide');

        },
        error: function (xhr, status, error) {
            console.error('Error loading comments:', error);
            modalBody.append('<p>Failed to load comments.</p>');
        }
    });
});


// Reply to comment feature

$('body').on('click','button.replay', function(){
    var parentId = $(this).closest('.comments').data('comment-id');
    var commentInput = $('#comment-form');
    var tagText = $(this).closest('.content').find('h4').text();

    commentInput.find('input').val('@'+tagText+'  ');
    // commentInput.find('.replyToPerson').val('@'+tagText);
    // console.log(parentId);
    commentInput.find('.input').attr('id', parentId);
});

// Clear reply input

$('body').on('keyup','#comment-form input', function(){
    if($(this).val()==''){
    $('.postComment').hide();
        $(this).parent().attr('id', '');
    }else{
        $('.postComment').show();
    }
});

$('.postComment').hide();
$('.postComment').on('click',function(){
    $(this).trigger('submit');
})

    // Handle comment form submission
    $(document).on('submit', '#comment-form', function() {
    // $('#comment-form').submit(function(event) {
        event.preventDefault();  // Prevent the default form submission

        var commentText = $('#emoji_comment').val();  // Get the comment text
        var postId = $(this).closest('#message_modal').data('post-id');  // Assuming you're passing postId in the form
        var parentId = $(this).find('.input').attr('id') || null;  // Check if it's a reply

        if (commentText.trim() === '') {
            alert('Please enter a comment');
            return;
        }

        // AJAX Request to submit the comment
        $.ajax({
            url: '<?= Url::to(['comments/addcomment']) ?>',  // The URL to handle the comment submission
            type: 'POST',
            data: {
                comment: commentText,
                postId: postId,
                parentId: parentId  // Pass parentId if this is a reply
            },
            dataType:'json',
            success: function(response) {
                if (response.success) {
                    $('#message_modal').find('.emptyTemplete').remove();
                    replyContainer='';
                    if(!parentId){
                        console.log(parentId);
                        // var replyContainer = '<div class="answers">' +
                        //     '<button class="see_comment">' +
                        //         '<span class="hide_com">Hide all responses</span>' +
                        //         '<span class="show_c"> <span class="line"></span> See the <span></span> answers</span>' +
                        //     '</button>' +
                        // '</div>';

                        var replyContainer =  '<div class="replay">' +
                            '<button class="replay">Reply</button>' +
                            '<button class="translation">See Translation</button>' +
                        '</div>' ;

                    }
                    // If comment submission is successful, append the new comment
 var newCommentHtml = '<div class="comments"   data-comment-id="'+response.comment.id +'">' +
            '<div class="comment" id="comment-'+response.comment.id+'">' +
                '<div class="d-flex">' +
                    '<div class="img">' +
                        '<img src="'+response.comment.profile_image+'" alt="Profile image">' + // You can replace with actual user profile image
                    '</div>' +
                    '<div class="content">' +
                        '<div class="person">' +
                            '<h4>' + response.comment.username + '</h4>' +
                            '<span>' + response.comment.created_at + '</span>' +
                        '</div>' +
                        '<p>' + response.comment.content + '</p>' +
                            replyContainer+
                    '</div>' +
                '</div>' +

                // Like section
                '<div class="like">'+   
                    '<div class="likeContainer">'+
                        '<div class="commentLike-button ' + (response.comment.like_status ? 'active' : '') + '" data-comment-id="'+response.comment.id+'">' + 
                            '<div class="heart" id="likeHeart"></div>'+
                        '</div>'+
                    '</div>'+
                    '<p style="margin-top: 10px;margin-right: 9px;">'+response.comment.likes_count+'</p>'+
                '</div>' +
                    
            '</div>'+
             '<div class="responses" id="responses-for-comment-'+response.comment.id+'">'+
            '</div>'+
        '</div>'; 








                    // var newCommentHtml = `
                    //     <div class="comment" id="comment-${response.comment.id}">
                    //         <div class="d-flex">
                    //             <div class="img">
                    //                 <img src="${response.comment.profile_image}" alt="Profile Image">
                    //             </div>
                    //             <div class="content">
                    //                 <div class="person">
                    //                     <h4>${response.comment.username}</h4>
                    //                     <span>${response.comment.created_at}</span>
                    //                 </div>
                    //                 <p>${response.comment.content}</p>
                    //                 <div class="replay">
                    //                     <button class="replay" data-comment-id="${response.comment.id}">Reply</button>
                    //                     <button class="translation">See Translation</button>
                    //                 </div>
                    //                 <div class="answers">
                    //                     <button class="see_comment" data-comment-id="${response.comment.id}">
                    //                         <span class="hide_com hide">Hide all responses</span>
                    //                         <span class="show_c"> <span class="line"></span> See the <span class="answer-count">0</span> answers</span>
                    //                     </button>
                    //                 </div>
                    //             </div>
                    //         </div>
                    //         <div class="like">
                    //             <img class="not_loved" src="./images/love.png" alt="">
                    //             <img class="loved" src="./images/heart.png" alt="">
                    //             <p>55</p>
                    //         </div>
                    //     </div>
                    // `;

                    if (parentId) {
                        console.log(parentId);
                        // If it's a reply, add it under the appropriate comment's responses
                        $('#responses-for-comment-' + parentId).append(newCommentHtml).removeClass('hide');
                        // Update the reply count for the parent comment
                        var replyCount = $('#comment-' + parentId).find('.answer-count').text();
                        $('#responses-for-comment-' + parentId).parent().find('.hide_com ').show();
                        $('#responses-for-comment-' + parentId).parent().find('.show_re ').hide();

                        $('#comment-' + parentId).find('.answer-count').text(parseInt(replyCount) + 1);
                    } else {
                        // If it's a new top-level comment, add it to the top of the comments list
                        $('.modal-body').prepend(newCommentHtml);
                    }

                    // Clear the input field
                    $('#emoji_comment').val('');
                    $(this).find('.input').attr('id','')
                } else {
                    alert('Failed to add comment');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Something went wrong');
            }
        });
    });

    // Show/Hide replies
    $(document).on('click', '.see_comment', function() {
        var commentId = $(this).data('comment-id');
        var responsesSection = $('#responses-for-comment-' + commentId);
        var toggleText = $(this).find('.show_c span');
        if (responsesSection.hasClass('hide')) {
            responsesSection.removeClass('hide');
            toggleText.text('Hide all responses');
        } else {
            responsesSection.addClass('hide');
            toggleText.text('See the ' + responsesSection.find('.comment').length + ' answers');
        }
    });






// Comment Likes feature

$(document).on('click', '.commentLike-button', function () {
    var element = $(this).parent().next();

    $(this).toggleClass('active');
    var commentId = $(this).data('comment-id'); // Get the comment ID from the button
    var button = $(this); // The like button clicked

    // Send AJAX request to like/unlike the comment
    $.ajax({
        url: '<?= \yii\helpers\Url::to(['comments/like-comment']) ?>', // Update with your controller URL
        type: 'POST',
        data: {
            commentId: commentId
        },
        success: function(response){
            if (response.status === 'success') {

                    console.log(response.likeStatus+'  '+element.text());
                 
                    var count = parseInt(element.text(), 10); 
                    response.likeStatus ?count++:count--;
                        element.text(count);
                button.closest('.comment').find('.like-count').text(response.likeCount);

                // Optionally show a message
                // alert(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log('Error:', error);
        }
    });
});




// See replies to comments

$(document).on('click', '.see_comment',function(){
    var hide_com = $('.hide_com');
    var responses = $(this).closest('.comment').next();
    responses.toggleClass('hide');
    if(responses.hasClass('hide')){
        responses.prev().find('.show_re').show();
        responses.prev().find('.hide_com').hide();
        // responses.prev().find('.hide_com').addClass('hide');
    }
    else{
        responses.prev().find('.hide_com').show();
        responses.prev().find('.show_re').hide();
    }
});




});


      </script>