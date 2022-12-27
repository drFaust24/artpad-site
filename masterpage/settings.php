<? define('artpadadm', true);
    include 'header.php';
    if (($user) AND ($user['access']==10)) { ?>
        <div class="menu">
            <?php
                include 'adminmenu.php';
            ?>
        </div>
        <div class="admincontent">
            <h1>Редактирование сайта <?=$settings['name']?></h1>
            <div class="settings">
                <? if (isset($_POST['save'])) {
                    if ((!empty($_POST[name])) AND ($_POST[name] != $settings['name'])) {
                        $artpad->query("UPDATE `settings` SET `value`='$_POST[name]' WHERE `name`='name'");
                    }
                    if ((!empty($_POST[title])) AND ($_POST[title] != $settings['title'])) {
                        $artpad->query("UPDATE `settings` SET `value`='$_POST[title]' WHERE `name`='title'");
                    }
                    if ((!empty($_POST[description])) AND ($_POST[description] != $settings['description'])) {
                        $artpad->query("UPDATE settings SET `value`='$_POST[description]' WHERE `name`='description'");
                    }
                    if ((!empty($_POST[admin_email])) AND ($_POST[admin_email] != $settings['admin_email'])) {
                        $artpad->query("UPDATE settings SET `value`='$_POST[admin_email]' WHERE `name`='admin_email'");
                    }
                    if ((!empty($_POST[posts_per_page])) AND ($_POST[posts_per_page] != $settings['posts_per_page'])) {
                        $artpad->query("UPDATE settings SET `value`='$_POST[posts_per_page]' WHERE `name`='posts_per_page'");
                    }
                    if (isset($_POST[canregister])==true) {
                        $artpad->query("UPDATE settings SET `value`='1' WHERE `name`='can_register'");
                    } else {
                        $artpad->query("UPDATE settings SET `value`='0' WHERE `name`='can_register'");
                    }
                    echo "<meta http-equiv='refresh' content='0'>";
                } ?>
                <form name="settings" method="POST" action="">
                    <p>
                        <span class="sname">Название сайта:</span>
                        <span class="svalue">
                            <input type="text" name="name" value="<?=$settings['name']?>">
                        </span>
                    </p>
                    <p>
                        <span class="sname">Title (SEO):</span>
                        <span class="svalue">
                            <input type="text" name="title" value="<?=$settings['title']?>">
                        </span>
                    </p>
                    <p>
                        <span class="sname">Description (SEO):</span>
                        <span class="svalue">
                            <textarea name="description"><?=$settings['description']?></textarea>
                        </span>
                    </p>
                    <p>
                        <span class="sname">E-mail администратора:</span>
                        <span class="svalue">
                            <input type="text" name="admin_email" value="<?=$settings['admin_email']?>">
                        </span>
                    </p>
                    <p>
                        <span class="sname">Записей на страницу:</span>
                        <span class="svalue">
                            <input type="text" name="posts_per_page" value="<?=$settings['posts_per_page']?>">
                        </span>
                    </p>
                    <p>
                        <span class="sname">Возможность регистрироваться всем:</span>
                        <span class="svalue">
                            <input type="checkbox" name="canregister" value="<?=$settings['can_register'];?>" <?if ($settings['can_register']==1) {echo "checked";}?> style="width: 23px;height: 31px;">
                        </span>
                    </p>
                    
                    <input type="submit" name="save" value="Сохранить" class="button">
                </form>
            </div>
        </div>
        <? include 'footer.php';
    } else {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
?>