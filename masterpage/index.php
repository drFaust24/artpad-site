<? define('artpadadm', true);
    include 'header.php';
    if (($user) AND ($user['access']==10)) { ?>
        <div class="menu">
            <?php
                include 'adminmenu.php';
            ?>
        </div>
        <div class="admincontent">
            123
        </div>
        <? include 'footer.php';
    } else {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
?>