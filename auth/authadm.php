<? include_once AUTH_DIR.'handler.php'; ?>

<? if ($user) { ?>
    <div class="usergroup">
        <div class="user">
            <span id="usermenus" class="header__icon-profile">
                Добро пожаловать, <? echo $user['login']; ?>!
            </span>
            <a style="margin-left: 5px;" href="/auth/exit.php"><img src="/public/img/svg/logout.svg" alt="profile-icon" style="height: 24px;"/></a>
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
                <input type="radio" name="odin" checked="checked" id="vkl1"/><label for="vkl1">Войти</label>
                <? if ($settings['can_register'] == 1) { ?>
                    <input type="radio" name="odin" id="vkl2"/><label for="vkl2">Регистрация</label>
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