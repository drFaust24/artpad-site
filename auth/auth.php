<? include_once AUTH_DIR.'handler.php'; ?>

<? if ($user) { ?>
    <? if ($user['wallet']) { ?>
        <a href="#" class="header__buy btn-primary" onclick="test()"><?=$arrLang['buy']?></a>
    <? } ?>
    <div class="usergroup">
        <div class="user">
            <? if ($user['wallet']) { ?>
                <div class="wallet">
                    <div class="amount"></div>
                    <span><?echo substr($user['wallet'], 0, 6)."...".substr($user['wallet'], -4, 4);?></span>
                    <img src="/public/img/svg/copy.svg"/ id="copywallet" onclick="copywallet('<?=$user['wallet']?>')">
                </div>
            <? } else { ?>
                <a href="#" class="header__connect btn-primary" onclick="connect()"><?=$arrLang['connect']?></a>
            <? } ?>
            
            <span id="usermenus" class="header__icon-profile">
                <img src="/public/img/svg/user.svg" alt="profile-icon" title="<? echo $user['login']; ?>"/>
            </span>
        </div>
        <div id="usermenu" class="usermenu w-full  bg-black z-10 block">
            <div class="w-full flex justify-end">
                <button id="usermenuc" class="ml-auto text-[#CD3ED0]">
                    <svg width="28" height="28" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 6.5L6 18.5" stroke="#CD3ED0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M6 6.5L18 18.5" stroke="#CD3ED0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </button>
            </div>
            <ul class="list-none">
                <li class="flex justify-between">
                    <span>KYC</span>
                </li>
                <li><?=$arrLang['wallet']?></li>
                <li><?=$arrLang['rectran']?></li>
                <li>Your NFT</li>
                <li><a href="/lk/"><?=$arrLang['profile']?></a></li>
                <li class="flex justify-between items-center">
                    <a href="/auth/exit.php">
                        <span><?=$arrLang['exit']?></span>
                    </a>
                    <a style="margin-left: 5px;" href="/auth/exit.php">
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.9767 7.53625C17.0079 7.46084 17.0079 7.37584 16.9767 7.30011C16.9609 7.26209 16.9381 7.22778 16.9096 7.19904L13.2008 3.49056C13.08 3.36971 12.8846 3.36971 12.7638 3.49056C12.6429 3.61142 12.6429 3.80676 12.7638 3.92762L15.9453 7.10909H11.1278V0.309091C11.1278 0.138164 10.9896 0 10.8187 0H0.309579C0.299688 0 0.291034 0.00463636 0.281452 0.00556364C0.264143 0.00710909 0.248997 0.0111273 0.232616 0.0154545C0.203561 0.0231818 0.177597 0.0336909 0.152561 0.0488364C0.144525 0.0537818 0.134634 0.0537818 0.127216 0.0593455C0.117634 0.0664545 0.110216 0.0754182 0.101561 0.0831455C0.0963065 0.0880909 0.0907428 0.0924182 0.0857974 0.0976727C0.0623065 0.123018 0.0431428 0.151145 0.0289246 0.182055C0.0261428 0.188236 0.0245974 0.194418 0.0221246 0.2006C0.00914283 0.235218 0.000488281 0.271382 0.000488281 0.309091V14.5273C0.000488281 14.5659 0.00945192 14.6024 0.0227428 14.637C0.0270701 14.6484 0.033561 14.658 0.0391246 14.6688C0.050561 14.6908 0.0635428 14.7109 0.0799246 14.7294C0.0888883 14.7393 0.0978519 14.7483 0.107743 14.7572C0.12567 14.773 0.145761 14.786 0.167397 14.7974C0.178834 14.8036 0.189343 14.8101 0.201706 14.8147C0.206961 14.8166 0.210979 14.8203 0.216234 14.8221L7.01623 16.9858C7.04652 16.9951 7.07805 17 7.10958 17C7.17449 17 7.23847 16.9796 7.29194 16.9407C7.37169 16.8825 7.41867 16.7898 7.41867 16.6909V14.8364H10.8187C10.9896 14.8364 11.1278 14.6982 11.1278 14.5273V7.72727H15.9453L12.7638 10.9087C12.6429 11.0296 12.6429 11.2249 12.7638 11.3458C12.8241 11.4061 12.9032 11.4364 12.9823 11.4364C13.0614 11.4364 13.1406 11.4061 13.2008 11.3458L16.9096 7.63702C16.9381 7.60858 16.9609 7.57427 16.9767 7.53625ZM6.80049 16.2684L0.61867 14.3013V0.731618L6.80049 2.69867V16.2684ZM10.5096 14.2182H7.41867V2.47273C7.41867 2.33796 7.33151 2.21896 7.20323 2.17816L2.30043 0.618182H10.5096V14.2182Z" fill="white"></path><path d="M6.29656 9.60378L4.75111 8.9856C4.59378 8.92224 4.41266 8.99889 4.34929 9.15807C4.28593 9.31664 4.3632 9.49653 4.52176 9.55989L6.06722 10.1781C6.10462 10.1932 6.14356 10.2 6.18189 10.2C6.30429 10.2 6.42051 10.1268 6.46904 10.0056C6.53209 9.84704 6.45482 9.66715 6.29656 9.60378Z" fill="white"></path></svg>
                    </a>
                </li>
            </ul>
        </div>
    </div>
<? } else { ?>

    <span class="header__icon-profile">
        <img id="myBtn" src="/public/img/svg/user.svg" alt="profile-icon"/>
    </span>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="tabs">
                <input type="radio" name="odin" checked="checked" id="vkl1"/><label for="vkl1"><?=$arrLang['signin']?></label>
                <? if ($settings['can_register'] == 1) { ?>
                    <input type="radio" name="odin" id="vkl2"/><label for="vkl2"><?=$arrLang['signup']?></label>
                <? } ?>
                <div><? include_once AUTH_DIR.'login.php'; ?></div>
                <? if ($settings['can_register'] == 1) { ?>
                    <div><? include_once AUTH_DIR.'register.php'; ?></div>
                <? } ?>
            </div>
        </div>
    </div>
<? } ?>

<? if (!$user) { ?>
    <script>
        // Получить модальный
        var modal = document.getElementById("myModal");
        
        // Получить кнопку, которая открывает модальный
        var btn = document.getElementById("myBtn");
        
        // Получить элемент <span>, который закрывает модальный
        var span = document.getElementsByClassName("close")[0];
        
        // Когда пользователь нажимает на кнопку, откройте модальный
        btn.onclick = function() {
          modal.style.display = "block";
        }
        
        // Когда пользователь нажимает на <span> (x), закройте модальное окно
        span.onclick = function() {
          modal.style.display = "none";
        }
        
        // Когда пользователь щелкает в любом месте за пределами модального, закройте его
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        }
    </script>
<? } ?>