<?php $this->layout('view_head', ['title' => $title]) ?>

<h2><?= $this->e($title) ?></h2>
<ul>
    <?php foreach($user as $key => $value): ?>
        <li>
            <?= $key ?> : <?= $value ?>
        </li>
    <?php endforeach ?>
</ul>