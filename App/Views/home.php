

<?php if($posts): ?>
<?php foreach($posts as $post): ?>
<div class="flex-r justify-center padding-rl-10p padding-tb-5p" id="postContainer" data-file="<?= $post['file_name']?>" data-title="<?= $post['title'] ?>">
    <div class="flex main-box justify-spacebetween secondary-color">
        <div class="flex">
            <div class="circular-img-holder margin-r15 flex align-i-center justify-center">
                <?php if($post['avatar']): ?>
                <img src="avatars/<?= $post['avatar'] ?>">
                <?php else: ?>
                <div>
                    <?= $post['aliasName'] ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="flex-r justify-center">
                <h5 class="p-1 margin-b5"><?= $post['title'] ?></h5>
                <p class="p-2 margin-b5 subcolor-1"><?= $post['fullname'] ?></p>
                <p class="p-2 subcolor-1"> <i class="far fa-clock subcolor-1"></i> <?= $post['createdat'] ?></p>
            </div>      
        </div>
        <div class="flex-r justify-center pointer">
            <div class="cir-dot margin-b5"></div>
            <div class="cir-dot margin-b5"></div>
            <div class="cir-dot margin-b5"></div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php else: ?>

    <p class="p-1 flex-r align-i-center">
        There is no feed yet.
    </p> 

<?php endif; ?>