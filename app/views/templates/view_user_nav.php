<?php

use App\Auth;
use App\Helpers;
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
    <a class="navbar-brand d-flex align-items-center fw-500" href="<?= Helpers::const('url.path') ?>users"><img alt="logo" class="d-inline-block align-top mr-2" src="<?= Helpers::const('url.path')?>img/logo.png"> Учебный проект</a> <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?= Helpers::const('url.path') ?>users">Главная <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?= Helpers::const('url.path')?>user/profile?id=<?= Auth::userID() ?>">Logged as: <?= Auth::userName() ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= Helpers::const('url.path')?>logout" onclick="return confirm('Do you realy want to logout?');">Выйти</a>
            </li>
        </ul>
    </div>
</nav>