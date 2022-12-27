<? define('artpadadm', true);
    include '../../config.php';
    include ADMIN_DIR.'header.php';
    
    if (($user) AND ($user['access']==10)) { ?>
        <div class="menu">
            <?php
                include ADMIN_DIR.'adminmenu.php';
            ?>
        </div>
        <div class="admincontent">
            <? breadcrumbs(); ?>
            <? if (isset($_POST['save'])) {
                $login = $_POST['login'];
                $name = $_POST['name'];
                $surname = $_POST['surname'];
                $email = $_POST['email'];
                $lvl = $_POST['lvl'];
                $newpass = $_POST['newpass'];
                $newpass2 = $_POST['newpass2'];
                if (isset($_POST['activity'])==true) {$actiivity = 1;} else {$actiivity = 0;}
                if (!empty($newpass) AND !empty($newpass2)) {
                    if ($newpass == $newpass2) {
                        $pass = md5((htmlspecialchars($newpass)));
                        $qeuser = "UPDATE `users` SET `login`='$login',`password`='$pass',`activity`=$actiivity,`email`='$email',`name`='$name',`surname`='$surname',`lvl`=$lvl WHERE `id`=$userid";
                        $artpad->query($qeuser);
                        echo "<meta http-equiv='refresh' content='0'>";
                    } else {
                        $qeuser = "UPDATE `users` SET `login`='$login',`activity`=$actiivity,`email`='$email',`name`='$name',`surname`='$surname',`lvl`=$lvl WHERE `id`=$userid";
                        $artpad->query($qeuser);
                    }
                } else {
                    $qeuser = "UPDATE `users` SET `login`='$login',`activity`=$actiivity,`email`='$email',`name`='$name',`surname`='$surname',`lvl`=$lvl WHERE `id`=$userid";
                    $artpad->query($qeuser);
                    echo "<meta http-equiv='refresh' content='0'>";
                }
            } ?>
            <div class="editusers">
                <h1>Редактирование пользователя <?=$rusr['login']?></h1>
                <div class="contentblock">
                    <form name="useredit" method="POST" action="">
                        <table>
                            <tr>
                                <td class="userprop">
                                    Активность:
                                </td>
                                <td class="userval">
                                    <input name="activity" type="checkbox" value="1" <? if ($rusr['id']==1) {echo "disabled";} ?> <? if ($rusr['activity']==1) {echo "checked";} ?>>
                                </td>
                            </tr>
                            <tr>
                                <td class="userprop">
                                    Логин:
                                </td>
                                <td class="userval">
                                    <input name="login" type="text" value="<?=$rusr['login']?>" <? if (($rusr['id']==1) AND ($user['id'] != $rusr['id'])) {echo "disabled";} ?>>
                                </td>
                            </tr>
                            <tr>
                                <td class="userprop">
                                    Имя:
                                </td>
                                <td class="userval">
                                    <input name="name" type="text" value="<?=$rusr['name']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="userprop">
                                    Фамилия:
                                </td>
                                <td class="userval">
                                    <input name="surname" type="text" value="<?=$rusr['surname']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="userprop">
                                    E-Mail:
                                </td>
                                <td class="userval">
                                    <input name="email" type="text" value="<?=$rusr['email']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="userprop">
                                    Доступ:
                                </td>
                                <td class="userval">
                                    
                                </td>
                            </tr>
                            <tr>
                                <td class="userprop">
                                    Lvl:
                                </td>
                                <td class="userval">
                                    <input name="lvl" type="text" value="<?=$rusr['lvl']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="userprop">
                                    Пароль:
                                </td>
                                <td class="userval">
                                    <input name="newpass" type="text" value="" style="-webkit-text-security: disc;">
                                </td>
                            </tr>
                            <tr>
                                <td class="userprop">
                                    Подтверждение пароля:
                                </td>
                                <td class="userval">
                                    <input name="newpass2" type="text" value="" style="-webkit-text-security: disc;">
                                </td>
                            </tr>
                        </table>
                        <? if (($newpass != $newpass2) AND !empty($newpass) AND !empty($newpass2)) { echo "<div class=\"error\">Пароли не совпадают</div>"; } ?>
                        
                        <input type="submit" name="save" value="Сохранить" class="button">
                    </form>
                </div>
            </div>
        </div>
        <? include ADMIN_DIR.'footer.php';
    } else {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
?>