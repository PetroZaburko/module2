<?php

use App\Helpers;

$this->layout('view_user_head', ['title' => $title]);
?>

<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-lock'></i> Безопасность
        </h1>
    </div>
    <?= flash()->display(); ?>
    <form action="<?= Helpers::const('url.path') ?>user/password" method="post">
        <div class="row">
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2><?= $title ?></h2>
                        </div>
                        <div class="panel-content">
                            <!-- id-->
                            <input type="hidden" id="id" name="id" class="form-control" value="<?= $user['id'] ?>">
                            <!-- password -->
                            <div class="form-group">
                                <label class="form-label" for="password">Новий пароль</label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                            <!-- password confirmation-->
                            <div class="form-group">
                                <label class="form-label" for="confirm_password">Подтверждение нового пароля</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                            </div>
                            <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                <button class="btn btn-warning">Изменить</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</main>
