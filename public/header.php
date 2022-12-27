<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<? date_default_timezone_set('Europe/Moscow'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="stylesheet" href="/public/style/bootstrap.css">
        <link rel="stylesheet" href="/public/css/index.css">
        <link rel="stylesheet" href="/public/css/vendor.css">
        <link rel="stylesheet" href="/public/css/main.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script defer="defer" src="/public/js/main.js"></script>
        <script defer="defer" src="/public/js/index.js"></script>
        <script defer="defer" src="/public/js/web3.js"></script>
        <script defer="defer" src="/public/js/ethereum.js"></script>
        <script defer="defer" src="/public/js/axios.min.js"></script>
        <script defer="defer" src="/public/js/artr-wallet-browser.js"></script>
        <script defer="defer" src="/public/js/artr-signer-demo.js"></script>
        <script defer="defer" src="/public/js/Swap.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/hmac-sha256.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/enc-base64.min.js"></script>
        <script defer="defer" src="/public/js/subscription-api.js"></script>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <title><?=$settings['title']?></title>
        <meta name="description" content="<?=$settings['description']?>">
    </head>
    <div class="overlay">
        <body class="page__body">
            <div class="site-container">
                <header class="header">
                    <div class="header__container _container">
                        <div class="header__mob-body">
                            <a href="/" class="header__mob-logo">
                                <img src="/public/img/svg/mob-logo.svg" alt="mob-logo"/>
                            </a>
                            <div id="header__burger" class="header__burger">
                                <div class="header__burger-menu">
                                    <span> </span>
                                    <span> </span>
                                    <span> </span>
                                </div>
                            </div>
                            <div id="mob-menu" class="mob-menu">
                                <div class="mob-menu__container">
                                    <div class="mob-menu__body">
                                        <div class="mob-menu__services services">
                                            <ul class="services__list">
                                                <li class="services__item">
                                                    <a href="#" class="services__link">
                                                        <img src="/public/img/svg/account-circle.svg" alt="mob-account"/>
                                                    </a>
                                                </li>
                                                <li class="services__item" style="position: relative;">
                                                    <a id="langm" href="#" class="services__link">
                                                        <!--<img src="/public/img/svg/calendar-range.svg" alt="mob-calendar"/>-->
                                                        <img src="/public/img/svg/lang.svg" alt="lang"/>
                                                        <div id="chnglangm" class="chnglangm bg-black z-10">
                                                            <ul class="list-none">
                                                                <li><a href="<?=$_SERVER[REQUEST_URI]?>?language=ru">RU</a></li>
                                                                <li><a href="<?=$_SERVER[REQUEST_URI]?>?language=en">EN</a></li>
                                                            </ul>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div id="services__close-icon" class="services__close-icon">
                                                <span> </span>
                                                <span> </span>
                                            </div>
                                        </div>
                                        <? showmobmenu(1,$_SESSION[language]); ?>
                                        <div class="mob-menu__buttons">
                                            <button class="mob-menu__button btn-primary">
                                                <?=$arrLang['buy']?>
                                            </button>
                                            <button class="mob-menu__button btn-primary">
                                                Connect Wallet
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="header__body">
                            <a href="/" class="header__logo">
                                <img class="logo-desktop" src="/public/img/svg/logo.svg" alt="logo-header" />
                                <img class="logo-tablet" src="/public/img/svg/tablet-logo.svg" alt="logo-header"/>
                            </a>
                            <div class="header__services">
                                <? showmenu(1,$_SESSION[language]); ?>
                                <div class="header__options">
                                    <div class="header__icons-btn">
                                        <a href="#" class="header__icon-calendar">
                                            <img src="/public/img/svg/calendar-range.svg" alt="calendar" />
                                        </a>
                                        <div id="lang" class="header__icon-calendar">
                                            <img src="/public/img/svg/lang.svg" alt="lang"/>
                                            <div id="chnglang" class="chnglang bg-black z-10">
                                                <ul class="list-none">
                                                    <li><a href="<?=$_SERVER[REQUEST_URI]?>?language=ru">RU</a></li>
                                                    <li><a href="<?=$_SERVER[REQUEST_URI]?>?language=en">EN</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="header__buttons">
                                        <? include AUTH_DIR.'auth.php' ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                
                
                <script>
                    window.onload = function () {
                        var hb = document.getElementById('header__burger');
                        var mm = document.getElementById('mob-menu');
                        var sci = document.getElementById('services__close-icon');
                        d=document.querySelector("body");
                        var lm = document.getElementById('langm');
                        
                        hb.onclick = function() {
                            mm.classList.add('--active-menu');
                            d.classList.add("body-lock");
                        }
                        sci.onclick = function() {
                            mm.classList.remove('--active-menu');
                            d.classList.remove("body-lock");
                        }
                        
                        lm.onclick = function() {
                            document.getElementById('chnglangm').style.display = 'block';
                        }
                    }
                </script>