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
            <h1>Создать меню</h1>
            <div class="contentblock">
                <? if (isset($_POST['save'])) {
                    $mname = trim($_POST['name']);
                    $mpages = $_POST['pages'];
                    $mpages = implode(",", $mpages);
                    $qaddmenu = "INSERT INTO `menu` (`menu_name`, `pages`) VALUES ('$mname','$mpages')";
                    $artpad -> query($qaddmenu);
                    //echo "<meta http-equiv='refresh' content='0'>";
                } ?>
                <form name="addmenu" method="POST" action="">
                    <table class="edit">
                        <tr>
                            <td class="editprop">
                                Название меню:
                            </td>
                            <td class="editval">
                                <input name="name" type="text" value="">
                            </td>
                        </tr>
                        <tr>
                            <td class="editprop" style="vertical-align: top;">
                                Страницы:
                            </td>
                            <td class="editval">
                                <?
                                    $qpages = "SELECT `id`,`page_title` FROM `pages`";
                                    $rpages = $artpad -> query($qpages);
                                    $i=1;
                                    while ($rpage = $rpages->fetch_assoc()) { ?>
                                        <div><input type="checkbox" name="pages[]" value="<?=$rpage['id']?>"> <?=$rpage['page_title']?></div>
                                    <? $i++; 
                                    }
                                ?>
                            </td>
                        </tr>
                    </table>
                    <input type="submit" name="save" value="Сохранить" class="button">
                </form>
            </div>
        </div>
        <? include ADMIN_DIR.'footer.php';
    } else {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
?>