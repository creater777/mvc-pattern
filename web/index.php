<?php

use Lib\App;

include "../index.php";

/**
 * @var $content
 * @var $errors []
 */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/web/res/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/web/res/custom.css">
<!--    <script type="text/javascript" src="/web/res/script.js"></script>-->
    <title>Тестовое приложение</title>
</head>
<body>
<? require_once App::getView("header"); ?>
<main role="main" class="container">

    <? foreach ($errors as $error): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?= $error ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <? endforeach; ?>

    <script type="text/javascript" src="/web/res/jquery.min.js"></script>
    <script type="text/javascript" src="/web/res/bootstrap.min.js"></script>

    <?= $content ?>

</main>
<? require_once App::getView("footer"); ?>

</body>
</html>
