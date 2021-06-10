<?php

use App\Helpers;

$this->layout('view_user_head', ['title' => $title]);
?>

<main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-sun'></i> Установить статус
            </h1>
        </div>
        <form action="<?= Helpers::const('url.path') ?>user/status" method="post">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2><?= $title ?></h2>
                            </div>
                            <div class="panel-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <!-- id-->
                                        <input type="hidden" name="id" id="id" class="form-control" value="<?= $user['id'] ?>">
                                        <!-- status -->
                                        <div class="form-group">
                                            <label class="form-label" for="example-select">Выберите статус</label>
                                            <select class="form-control" id="status" name="status">
                                                <?php foreach ($statuses as $status): ?>
                                                    <option value="<?= $status['id'] ?>" <?= $status['id'] == $user['status'] ? 'selected' : '' ?>><?= $status['status'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                        <button class="btn btn-warning">Set Status</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>