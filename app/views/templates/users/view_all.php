<?php $this->layout('view_head', ['title' => $title]) ?>
<div class="test">
    <?php
    echo flash()->display();
    ?>

</div>

<h2><?= $this->e($title) ?></h2>
<ul>
    <?php foreach($users as $user): ?>
        <li>
            <a href="<?=\App\Route::getBasePath() ?>users/one/<?=$this->e($user['id'])?>">
                <?=$this->e($user['name'])?>
            </a>
        </li>
    <?php endforeach ?>
</ul>