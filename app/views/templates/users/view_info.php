<?php

use App\Helpers;

$this->layout('view_user_head', ['title' => $title]);
?>

<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Редактировать
        </h1>
    </div>
    <form action="<?= Helpers::const('url.path') ?>user/edit" method="post">
        <div class="row">
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2><?= $title ?></h2>
                        </div>
                        <div class="panel-content">
                            <!-- id -->
                            <input type="hidden" id="id" class="form-control" name="user_id" value="<?= $user['id'];?>">
                            <!-- username -->
                            <div class="form-group">
                                <label class="form-label" for="username">Имя</label>
                                <input type="text" id="username" name="username" class="form-control" value="<?= $user['username'] ?>">
                            </div>
                            <!-- title -->
                            <div class="form-group">
                                <label class="form-label" for="company">Место работы</label>
                                <input type="text" id="company" name="company" class="form-control" value="<?= $user['company'] ?>">
                            </div>
                            <!-- tel -->
                            <div class="form-group">
                                <label class="form-label" for="telephone">Номер телефона</label>
                                <input type="text" id="telephone" name="telephone" class="form-control" value="<?= $user['telephone'] ?>">
                            </div>
                            <!-- address -->
                            <div class="form-group">
                                <label class="form-label" for="address">Адрес</label>
                                <input type="text" id="address" name="address" class="form-control" value="<?= $user['address'] ?>">
                            </div>
                            <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                <button class="btn btn-warning">Редактировать</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>