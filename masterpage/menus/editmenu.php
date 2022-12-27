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
                $projectid=$_GET['project'];
                $qprjt ="SELECT * FROM `projects` WHERE `id`=$projectid";
                $rprjt = $artpad -> query($qprjt);
                $rprjt = $rprjt->fetch_assoc();
                
                if (isset($_POST['save'])) {
                    $datenow= date('Y-m-d H:i:s');
                    if (isset($_POST['activity'])==true) {$actiivity = 1;} else {$actiivity = 0;}
                    $ptitle = trim($_POST['title']);
                    $pname = translit($ptitle);
                    $pdescription = trim($_POST['description']);
                    $paccesstype = trim($_POST['access_type']);
                    $pstart = trim($_POST['start']);
                    $ppriceipo = trim($_POST['price_ipo']);
                    $ptfull = trim($_POST['token_full']);
                    $ptsmall = trim($_POST['token_small']);
                    $ptype = trim($_POST['type']);
                    $ptsupply = trim($_POST['total_supply']);
                    $pisupply = trim($_POST['initial_supply']);
                    $plisting = $_POST['trip-start'];
                    $pdistribution = trim($_POST['distribution']);
                    $pvesting = trim($_POST['vesting']);
                    
                    if ($_FILES AND (!empty($_FILES['logo']['name'])) AND ($_FILES['logo']['size'] > 0) AND $_FILES['logo']["error"]== UPLOAD_ERR_OK) {
                        $uploaddir = UPLOAD_DIR.'tokens/';
                        $falename = explode(".",$_FILES['logo']['name']);
                        $plogo = $projectid.".".$falename[1];
                        $uploadfile = $uploaddir . basename($plogo);
                        
                        $qeproject = "UPDATE `projects` SET
                            `project_change` = '$datenow',
                            `project_title` = '$ptitle',
                            `project_logo` = '/uploads/tokens/$plogo',
                            `project_content` = '$pdescription',
                            `project_status` = '$actiivity',
                            `project_name` = '$pname',
                            `project_access_type` = '$paccesstype',
                            `project_start` = '$pstart',
                            `project_price_ido` = '$ppriceipo',
                            `project_token_full` = '$ptfull',
                            `project_token_small` = '$ptsmall',
                            `project_type` = '$ptype',
                            `project_total_supply` = '$ptsupply',
                            `project_initial_supply` = '$pisupply',
                            `project_listing` = '$plisting',
                            `project_distribution` = '$pdistribution',
                            `project_vesting` = '$pvesting'
                        WHERE `id` = $projectid";
                    } else {
                        $qeproject = "UPDATE `projects` SET
                            `project_change` = '$datenow',
                            `project_title` = '$ptitle',
                            `project_content` = '$pdescription',
                            `project_status` = '$actiivity',
                            `project_name` = '$pname',
                            `project_access_type` = '$paccesstype',
                            `project_start` = '$pstart',
                            `project_price_ido` = '$ppriceipo',
                            `project_token_full` = '$ptfull',
                            `project_token_small` = '$ptsmall',
                            `project_type` = '$ptype',
                            `project_total_supply` = '$ptsupply',
                            `project_initial_supply` = '$pisupply',
                            `project_listing` = '$plisting',
                            `project_distribution` = '$pdistribution',
                            `project_vesting` = '$pvesting'
                        WHERE `id` = $projectid";
                    }
                    if( $artpad -> query($qeproject) ) {
                       move_uploaded_file($_FILES['logo']["tmp_name"], $uploadfile);
                    }
                    
                    echo "<meta http-equiv='refresh' content='0'>";
                }
            ?>
            <div class="editproject">
                <h1>Редактирование проекта <?=$rprjt['project_title']?></h1>
                <div class="contentblock">
                    <form name="projectedit" enctype="multipart/form-data" method="POST" action="">
                        <table class="edit">
                            <tr>
                                <td class="editprop">
                                    ID:
                                </td>
                                <td class="editval">
                                    <?=$rprjt['id']?>
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Дата изменения:
                                </td>
                                <td class="editval">
                                    <? if ($rprjt['project_change'] != 0) {
                                        echo truedatetime($rprjt['project_change']);
                                    } else {
                                        echo truedatetime($rprjt['project_date']);
                                    } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Активность:
                                </td>
                                <td class="editval">
                                    <input name="activity" type="checkbox" <? if ($rprjt['project_status'] == 1) {echo "checked";} ?>><?=$rprjt['activity']?>
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Название:
                                </td>
                                <td class="editval">
                                    <input name="title" type="text" value="<?=$rprjt['project_title']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Описание:
                                </td>
                                <td class="editval">
                                    <textarea name="description"><?=$rprjt['project_content']?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Логотип:
                                </td>
                                <td class="editval">
                                    <input name="logo" type="file"> <? if (!empty($rprjt['project_logo'])) {?><img src="<?=$rprjt['project_logo']?>" width="32"><?}?>
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Access type:
                                </td>
                                <td class="editval">
                                    <input name="access_type" type="text" value="<?=$rprjt['project_access_type']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Start:
                                </td>
                                <td class="editval">
                                    <input name="start" type="text" value="<?=$rprjt['project_start']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Цена IDO:
                                </td>
                                <td class="editval">
                                    <input name="price_ipo" type="text" value="<?=$rprjt['project_price_ido']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Полное название токена:
                                </td>
                                <td class="editval">
                                    <input name="token_full" type="text" value="<?=$rprjt['project_token_full']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Короткое название токена:
                                </td>
                                <td class="editval">
                                    <input name="token_small" type="text" value="<?=$rprjt['project_token_small']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Type:
                                </td>
                                <td class="editval">
                                    <input name="type" type="text" value="<?=$rprjt['project_type']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Total supply:
                                </td>
                                <td class="editval">
                                    <input name="total_supply" type="text" value="<?=$rprjt['project_total_supply']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Initial supply:
                                </td>
                                <td class="editval">
                                    <input name="initial_supply" type="text" value="<?=$rprjt['project_initial_supply']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Listing:
                                </td>
                                <td class="editval">
                                    <? $date = date('Y-m-d');
                                    $to_date = date('Y-m-d', strtotime($date.' +1 day'));?> 
                                    <input type="date" id="start" name="trip-start" value="<?=$rprjt['project_listing']?>" min="<?=$to_date?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Distribution:
                                </td>
                                <td class="editval">
                                    <input name="distribution" type="text" value="<?=$rprjt['project_distribution']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Vesting:
                                </td>
                                <td class="editval">
                                    <input name="vesting" type="text" value="<?=$rprjt['project_vesting']?>">
                                </td>
                            </tr>
                        </table>
                        
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