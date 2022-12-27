<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?
    if (!defined('artpadadm')) exit('No direct script access allowed');
    include '../config.php';
    mb_internal_encoding("UTF-8");
    include CORE_DIR.'connect.php';
    include CORE_DIR.'functions.php';
    include_once AUTH_DIR.'handler.php';
    if (!$user) { header('Location: /');}
    // получаем настройки сайта
    $qstgs ="SELECT name,value FROM `settings`";
    $rstgs = $artpad -> query($qstgs);
    $settings = array();
    while ($setting = $rstgs->fetch_assoc()) {
        $settings[$setting[name]] = $setting[value];
    }
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
        <meta name=viewport content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/style/bootstrap.css">
        <link rel="stylesheet" href="/style/admin.css">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <script src="/js/admin.js"></script>
        <title>Административная панель <?=$settings['name']?></title>
        <meta name="description" content="Рабочая область для настройки сайта <?=$settings['description']?>">
    </head>
    <body>
        <header>
            <div class="container">
                <div class="topmenu">
                    <div class="logo">
                        <a href="/" class="header__mob-logo" target="_blank">
                            <img src="/public/img/svg/mob-logo.svg" alt="mob-logo"/>
                        </a>
                    </div>
                    
                    <div class="search">
                        <input type="text" placeholder="Поиск">
                    </div>
                    
                    <div class="profile">
                        <? include AUTH_DIR.'authadm.php' ?>
                    </div>
                </div>
            </div>
        </header>
        <main>