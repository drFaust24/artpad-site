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
            <h1>Меню</h1>
            <div class="menus">
                <div class="pagetoolbar">
                    <a href="/masterpage/menus/add.php?main=content&sub=menu" class="btn-primary">Добавить меню</a>
                </div>
                <table>
                    <thead>
                        <th>
                            Меню
                        </th>
                        <th>
                            Страницы
                        </th>
                        <th class="tableedit">
                            Править
                        </th>
                    </thead>
                    <tbody>
                        <?
                        $qmenus ="SELECT * FROM `menu`";
                        $rmenus = $artpad -> query($qmenus);
                        while ($rmenu = $rmenus->fetch_assoc()) { ?>
                            <tr>
                                <td>
                                    <?=$rmenu['menu_name']; ?>
                                </td>
                                <td>
                                    <?
                                        $pages = $rmenu['pages'];
                                        //$pages = implode(",", $pages);
                                        $qpages ="SELECT `page_title` FROM `pages` WHERE `id` IN ($pages)";
                                        $rpages = $artpad -> query($qpages);
                                        $numb = 0;
                                        while ($rpage = $rpages->fetch_assoc()) {
                                            if ($numb > 0) { echo ", "; }
                                            print_r($rpage['page_title']);
                                            $numb++;
                                        }
                                    ?>
                                </td>
                                <td class="tableedit">
                                    <a href="/masterpage/users/edituser.php?user=<?=$rmenu['id'];?>&main=settings&sub=users"><img class="edit" id="edit<?=$rmenu['id'];?>" src="/images/pencil.svg"></a>
                                    <a href="/masterpage/users/edituser.php?user=<?=$rmenu['id'];?>&main=settings&sub=users"><img class="edit" id="edit<?=$rmenu['id'];?>" src="/images/trash.svg"></a>
                                </td>
                            </tr>
                        <? } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <? include ADMIN_DIR.'footer.php';
    } else {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
?>