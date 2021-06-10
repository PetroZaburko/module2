<?php

use App\Helpers;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $this->e($title); ?></title>
    <meta name="description" content="Chartist.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">

    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="<?= Helpers::const('url.path') . $this->asset('css/vendors.bundle.css') ?>">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="<?= Helpers::const('url.path') . $this->asset('css/app.bundle.css') ?>">
    <link id="myskin" rel="stylesheet" media="screen, print" href="<?= Helpers::const('url.path') . $this->asset('css/skins/skin-master.css') ?>">
    <link rel="stylesheet" media="screen, print" href="<?= Helpers::const('url.path') . $this->asset('css/fa-solid.css') ?>">
    <link rel="stylesheet" media="screen, print" href="<?= Helpers::const('url.path') . $this->asset('css/fa-brands.css') ?>">
    <link rel="stylesheet" media="screen, print" href="<?= Helpers::const('url.path') . $this->asset('css/fa-regular.css') ?>">
    <link rel="stylesheet" media="screen, print" href="<?= Helpers::const('url.path') . $this->asset('css/page-login-alt.css') ?>">
</head>
    <?= $this->section('content') ?>
</html>