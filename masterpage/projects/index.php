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
            <h1>Проекты</h1>
            <div class="projects">
                <div class="pagetoolbar">
                    <a href="/masterpage/projects/add.php?main=content&sub=projects" class="btn-primary">Добавить проект</a>
                </div>
                <div class="row">
                    <?
                        $qprjts ="SELECT `id`,`project_title`,`project_logo`,`project_listing` FROM `projects`";
                        $rprjts = $artpad -> query($qprjts);
                        while ($prjt = $rprjts->fetch_assoc()) { ?>
                            <a class="col-md-3" href="/masterpage/projects/editproject.php?project=<?=$prjt['id'];?>&main=content&sub=projects">
                                <div class="project">
                                    <p>
                                        <img src="<?=$prjt['project_logo']; ?>">
                                    </p>
                                    <p>
                                        <?=$prjt['project_title']; ?>
                                    </p>
                                    <p>
                                        <?=$prjt['project_listing']; ?>
                                    </p>
                                </div>
                            </a>
                        <? }
                    ?>
                </div>
            </div>
        </div>
        <? include ADMIN_DIR.'footer.php';
    } else {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
?>