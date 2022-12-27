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
            
            <? 
                $page = $artpad -> query("SELECT * FROM `pages` WHERE `id` = '$_GET[page]'") -> fetch_assoc();
            ?>
            
            <h1>Редактировать страницу <?=$page['page_title']?></h1>
            <div class="contentblock">
                <? if (isset($_POST['save'])) {
                    $datenow= date('Y-m-d H:i:s');
                    $page_title = trim($_POST['title']);
                    $en = trim($_POST['en']);
                    $ru = trim($_POST['ru']);
                    $page_content = trim($_POST['content']);
                    if (isset($_POST['activity'])==true) {
                        $page_status = 1;
                    } else {
                        $page_status = 0;
                    }
                    $page_name = translit($page_title);
                    $qeditpage = "UPDATE `pages` SET `page_title` = '$page_title',`en` = '$en',`ru` = '$ru',`page_content` = '$page_content',`page_status` = '$page_status',`page_name` = '$page_name' WHERE `id` = $page[id]";
                    $reditpage = $artpad -> query($qeditpage);
                    echo "<meta http-equiv='refresh' content='0'>";
                } ?>
                <form name="addpage" method="POST" action="">
                    <p>
                        <label>Название</label>
                        <input type="text" name="title" value="<?=$page['page_title']?>">
                    </p>
                    <p>
                        <label>Название на английском</label>
                        <input type="text" name="en" value="<?=$page['en']?>">
                    </p>
                    <p>
                        <label>Название на русском</label>
                        <input type="text" name="ru" value="<?=$page['ru']?>">
                    </p>
                    <p>
                        <label>Содержимое</label>
                        <textarea name="content"><?=$page['page_content']?></textarea>
                    </p>
                    <p>
                        <span>Активна:</span>
                        <input type="checkbox" name="activity" value="1" checked>
                    </p>
                    <p>
                        <input type="submit" name="save" value="Сохранить" class="button">
                    </p>
                </form>
            </div>
        </div>
        <? include ADMIN_DIR.'footer.php';
    } else {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
?>