<?php

use App\Helpers;

$this->layout('view_user_head', ['title' => $title]);
?>

<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-lock'></i> Смена email аддреса
        </h1>
    </div>
    <?= flash()->display(); ?>
    <form action="<?= Helpers::const('url.path') ?>user/email" method="post">
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
                            <!-- username-->
                            <input type="hidden" id="username" name="username" class="form-control" value="<?= $user['username'] ?>">
                            <!-- password -->
                            <div class="form-group">
                                <label class="form-label" for="password">Enter current password</label>
                                <input type="text" id="password" name="password" class="form-control">
                            </div>
                            <!-- email -->
                            <div class="form-group">
                                <label class="form-label" for="email">Enter new email</label>
                                <input type="text" id="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
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