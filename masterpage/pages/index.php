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
            <h1>Страницы сайта <?=$settings['name']?></h1>
            <div class="pages">
                <div class="pagetoolbar">
                    <a href="/masterpage/pages/add.php?main=content&sub=pages" class="btn-primary">Добавить страницу</a>
                </div>
                <table>
                    <thead>
                        <th>
                            id
                        </th>
                        <th>
                            Page
                        </th>
                        <th>
                            Activity
                        </th>
                        <th>
                            Edit
                        </th>
                    </thead>
                    <tbody>
                        <?
                            $qpgs ="SELECT `id`,`page_title`,`page_status`,`page_date` FROM `pages`";
                            $rpgs = $artpad -> query($qpgs);
                            while ($pgs = $rpgs->fetch_assoc()) { ?>
                                <tr>
                                    <td>
                                        <?=$pgs['id']; ?>
                                    </td>
                                    <td>
                                        <a href="/masterpage/pages/editpage.php?page=<?=$pgs['id'];?>&main=content&sub=pages"><?=$pgs['page_title']; ?></a>
                                    </td>
                                    <td>
                                        <?=$pgs['page_status']; ?>
                                    </td>
                                    <td>
                                        <? truedatetime($pgs['page_date']); ?>
                                    </td>
                                </tr>
                            <?
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <? include ADMIN_DIR.'footer.php';
    } else {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
?>