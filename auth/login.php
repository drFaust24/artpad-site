<?
    include '../config.php';
    include_once CORE_DIR.'connect.php';
    
    if(!empty($_POST['login']) AND !empty($_POST['password'])) {
        $login = $artpad -> real_escape_string(htmlspecialchars($_POST['login']));
        $password = $artpad -> real_escape_string(htmlspecialchars($_POST['password']));
        
        $queryuser ="SELECT * FROM `users` WHERE `login` = '".$login."' AND `password` = '".md5($password)."'";
        $finduser = $artpad -> query($queryuser);
        
        if($finduser == 0) { ?>
            <div class="authform">
                <div class="wrong"><?=$arrLang['wrong']?></div>
                <form action="login.php" method="POST">
                    <input name="login" type="text" placeholder="<?=$arrLang['login']?>" class="input-text" /><br />
                    <input name="password" type="password" placeholder="<?=$arrLang['password']?>" class="input-text" /><br /><br />
                    <input type="submit" value="<?=$arrLang['signin']?>" class="submit btn-primary" />
                </form>
            </div>
            <? exit();
        } else {
            // заносим логин и пароль в куки
            $time = 60*60*24; // сколько времени хранить данные в куках
            setcookie('username', $login, time()+$time, '/');
            setcookie('password', md5($password), time()+$time, '/');
            $datenow= date('Y-m-d H:i:s');
            $artpad -> query("UPDATE `users` SET `lastauth` = '$datenow' WHERE `login` = '".$login."'");
            header("Location: /");
            exit();
        }
        
    } else { ?>
        <div class="authform">
            <form action="/auth/login.php" method="POST">
                <input name="login" type="text" placeholder="<?=$arrLang['login']?>" class="input-text" <? if(!empty($_COOKIE['username'])) {?>value="<? echo $_COOKIE['username'];?>"<?} ?> />
                <input name="password" type="password" placeholder="<?=$arrLang['password']?>" class="input-text" />
                <input type="submit" value="<?=$arrLang['signin']?>" class="submit btn-primary" />
            </form>
        </div>
    <? } ?>