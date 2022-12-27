<?
    include '../config.php';
    include_once CORE_DIR.'connect.php';
    
    if(!empty($_POST['login']) AND !empty($_POST['password']) AND !empty($_POST['email'])) {
        $login = $artpad -> real_escape_string(htmlspecialchars($_POST['login']));
        $password = $artpad -> real_escape_string(htmlspecialchars($_POST['password']));
        $email = $artpad -> real_escape_string(htmlspecialchars($_POST['email']));
        
        $qproverka = "SELECT * FROM `users` WHERE `login` = '".$login."'";
        $rproverka = $artpad -> query($qproverka);
        $row_cnt = $rproverka->num_rows;
        
        if ($row_cnt != 0) { header("Location: /");?>
            <div class="authform">1
                <div class="wrong"><?=$arrLang['wrongreg']?></div>
                <form action="register.php" method="POST">
                    <input name="login" type="text" placeholder="<?=$arrLang['login']?>" class="input-text" /><br />
                    <input name="password" type="password" placeholder="<?=$arrLang['password']?>" class="input-text" /><br /><br />
                    <input type="submit" value="<?=$arrLang['signin']?>" class="submit btn-primary" />
                </form>
            </div>
            <? exit();
        } else {
            $ref = $_COOKIE['ref'];
            $qadd = "INSERT INTO `users` (`login`, `password`, `email`, `ref`) VALUES ('$login', '".md5($password)."', '$email', '$ref')";
            $artpad -> query($qadd);
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
        <div class="regform">
            <form action="/auth/register.php" method="POST">
                <input name="login" type="text" placeholder="<?=$arrLang['login']?>">
                <input name="email" type="text" placeholder="E-mail">
                <input name="password" type="text" placeholder="<?=$arrLang['password']?>">
                <input type="submit" value="<?=$arrLang['signup']?>"  class="submit btn-primary">
            </form>
        </div>
    <? } ?>