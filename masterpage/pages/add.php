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
            <h1>Добавить страницу</h1>
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
                    $qaddpage = "INSERT INTO `pages`(`page_date`, `page_title`, `en`, `ru`, `page_content`, `page_status`, `page_name`) VALUES ('$datenow','$page_title','$en','$ru','$page_content','$page_status','$page_name')";
                    $artpad -> query($qaddpage);
                    $qidpage = "SELECT id FROM `pages` WHERE `page_title`='$page_title'";
                    $ridpage = $artpad -> query($qidpage);
                    $ridpage = $ridpage->fetch_assoc();
                    $qguid = "UPDATE `pages` SET `page_guid` = '/?page=$ridpage[id]' WHERE `id` = $ridpage[id]";
                    $rguid = $artpad -> query($qguid);
                    echo "<meta http-equiv='refresh' content='0'>";
                } ?>
                <form name="addpage" method="POST" action="">
                    <p>
                        <label>Название</label>
                        <input type="text" name="title">
                    </p>
                    <p>
                        <label>Название на английском</label>
                        <input type="text" name="en">
                    </p>
                    <p>
                        <label>Название на русском</label>
                        <input type="text" name="ru">
                    </p>
                    <p>
                        <label>Содержимое</label>
                        <textarea name="content"></textarea>
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