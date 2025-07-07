<?php
$posts = $model->getPosts()->all();
// echo '<pre>';
// print_r( $posts);
// exit;
?>

<?php if (count($posts) > 0) : ?>
    <?php foreach ($posts as $post) : ?>
        <div class="item">
            <img class="img-fluid item_img" src=" <?= Yii::getAlias('@web/web/' . $post->image_path) ?> " alt="">
        </div>
    <?php endforeach; ?>

<?php else : ?>
    <div class="item">
        <p>No Posts available</p>
    </div>

<?php endif; ?>