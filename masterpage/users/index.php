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
            <div class="users">
    <h1>Пользователи сайта <?=$settings['name']?></h1>
    <div class="users">
        <table>
            <thead>
                <th>
                    №
                </th>
                <th>
                    Login
                </th>
                <th>
                    Activity
                </th>
                <th>
                    Lvl
                </th>
                <th>
                    Name
                </th>
                <th>
                    Surname
                </th>
                <th>
                    E-mail
                </th>
                <th>
                    Status
                </th>
                <th>
                    Edit
                </th>
            </thead>
            <tbody>
                <?  $numb = 1;
                    $qusrs ="SELECT `id`,`login`,`activity`,`email`,`access`,`name`,`surname`,`lvl` FROM `users`";
                    $rusrs = $artpad -> query($qusrs);
                    while ($usr = $rusrs->fetch_assoc()) { ?>
                        <tr>
                            <td>
                                <?=$numb; ?>
                            </td>
                            <td>
                                <?=$usr['login']; ?>
                            </td>
                            <td>
                                <?=$usr['activity']; ?>
                            </td>
                            <td>
                                <?=$usr['lvl']; ?>
                            </td>
                            <td>
                                <?=$usr['name']; ?>
                            </td>
                            <td>
                                <?=$usr['surname']; ?>
                            </td>
                            <td>
                                <?=$usr['email']; ?>
                            </td>
                            <td>
                                <?=$usr['access']; ?>
                            </td>
                            <td>
                                <a href="/masterpage/users/edituser.php?user=<?=$usr['id'];?>&main=settings&sub=users"><img class="edit" id="edit<?=$usr['id'];?>" src="/images/pencil.svg"></a>
                            </td>
                        </tr>
                    <? $numb++;
                } ?>
            </tbody>
        </table>
    </div>
</div>
        </div>
        <? include ADMIN_DIR.'footer.php';
    } else {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
?>