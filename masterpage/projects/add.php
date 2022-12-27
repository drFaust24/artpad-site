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
            <h1>Add project</h1>
            <div class="contentblock">
                <? if (isset($_POST['save'])) {
                    $datenow= date('Y-m-d H:i:s');
                    $ptitle = trim($_POST['title']);
                    $pname = translit($ptitle);
                    $pkind = trim($_POST['kind']);
                    $pdescription = trim($_POST['description']);
                    //$plogo = trim($_POST['logo']);
                    $paccesstype = trim($_POST['access_type']);
                    $ppriceipo = trim($_POST['price_ipo']);
                    $ptfull = trim($_POST['token_full']);
                    $ptsmall = trim($_POST['token_small']);
                    $ptype = trim($_POST['type']);
                    $ptsupply = trim($_POST['total_supply']);
                    $pisupply = trim($_POST['initial_supply']);
                    $pregstart = $_POST['regstart'];
                    $pregend = $_POST['regend'];
                    $psalestart = $_POST['salestart'];
                    $psaleend = $_POST['saleend'];
                    $plisting = $_POST['listing'];
                    $pdistribution = trim($_POST['distribution']);
                    $pvesting = trim($_POST['vesting']);
                    
                    $qaddproject = "INSERT INTO `projects` (
                        `project_date`, `project_title`, `project_kind`, `project_content`, `project_status`, `project_name`, `project_access_type`, `project_start`, `project_price_ido`, `project_token_full`,
                        `project_token_small`, `project_type`, `project_total_supply`, `project_initial_supply`, `project_register_start`, `project_register_end`, `project_sale_start`, `project_sale_end`, `project_listing`, `project_distribution`, `project_vesting`
                        ) VALUES (
                        '$datenow','$ptitle','$pkind','$pdescription','upcoming','$pname','$paccesstype','$pstart','$ppriceipo','$ptfull',
                        '$ptsmall','$ptype','$ptsupply','$pisupply','$pregstart','$pregend','$psalestart','$psaleend','$plisting','$pdistribution','$pvesting'
                        )";
                    if( $artpad -> query($qaddproject) ) {
                        //$artpad -> query($qaddproject);
                        $qidproject = "SELECT id FROM `projects` WHERE `project_title`='$ptitle'";
                        $ridproject = $artpad -> query($qidproject);
                        $ridproject = $ridproject->fetch_assoc();
                        if ($_FILES AND (!empty($_FILES['logo']['name'])) AND ($_FILES['logo']['size'] > 0) AND $_FILES['logo']["error"]== UPLOAD_ERR_OK) {
                            $uploaddir = UPLOAD_DIR.'tokens/';
                            $falename = explode(".",$_FILES['logo']['name']);
                            $plogo = $ridproject[id].".".$falename[1];
                            $uploadfile = $uploaddir . basename($plogo);
                            move_uploaded_file($_FILES['logo']["tmp_name"], $uploadfile);
                        }
                        $qguid = "UPDATE `projects` SET `project_guid` = '/projects/?project=$ridproject[id]',`project_logo` = '/uploads/tokens/$plogo' WHERE `id` = $ridproject[id]";
                        $rguid = $artpad -> query($qguid);
                    }
                    
                    echo "<meta http-equiv='refresh' content='0'>";
                } ?>
                <form name="addproject" enctype="multipart/form-data" method="POST" action="">
                    <table class="edit">
                        <tr>
                            <td class="editprop">
                                Project:
                            </td>
                            <td class="editval">
                                <input name="title" type="text" value="">
                            </td>
                        </tr>
                        <tr>
                            <td class="editprop">
                                Kind:
                            </td>
                            <td class="editval">
                                <select size="1" name="kind">
                                    <option value="claiming">Claiming</option>
                                    <option value="vesting">Vesting</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="editprop">
                                Description of project:
                            </td>
                            <td class="editval">
                                <textarea name="description"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="editprop">
                                Add logo:
                            </td>
                            <td class="editval">
                                <input name="logo" type="file">
                            </td>
                        </tr>
                        <tr>
                            <td class="editprop">
                                Access type:
                            </td>
                            <td class="editval">
                                <input name="access_type" type="text" value="">
                            </td>
                        </tr>
                        <tr>
                            <td class="editprop">
                                Start:
                            </td>
                            <td class="editval">
                                <input name="start" type="text" value="">
                            </td>
                        </tr>
                        <tr>
                            <td class="editprop">
                                Price IDO:
                            </td>
                            <td class="editval">
                                <input name="price_ipo" type="text" value="" placeholder="0.55 $"> 
                            </td>
                        </tr>
                        <tr>
                            <td class="editprop">
                                Token full:
                            </td>
                            <td class="editval">
                                <input name="token_full" type="text" value="">
                            </td>
                        </tr>
                        <tr>
                            <td class="editprop">
                                Token small:
                            </td>
                            <td class="editval">
                                <input name="token_small" type="text" value="">
                            </td>
                        </tr>
                        <tr>
                            <td class="editprop">
                                Type:
                            </td>
                            <td class="editval">
                                <input name="type" type="text" value="">
                            </td>
                        </tr>
                        <tr>
                            <td class="editprop">
                                Total supply:
                            </td>
                            <td class="editval">
                                <input name="total_supply" type="text" value="">
                            </td>
                        </tr>
                        <tr>
                            <td class="editprop">
                                Initial supply:
                            </td>
                            <td class="editval">
                                <input name="initial_supply" type="text" value="">
                            </td>
                        </tr>
                            <tr>
                                <td class="editprop">
                                    Register start:
                                </td>
                                <td class="editval">
                                    <input type="datetime-local" id="regstart" name="regstart" value="<?=$rprjt['project_register_start']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Register end:
                                </td>
                                <td class="editval">
                                    <input type="datetime-local" id="regend" name="regend" value="<?=$rprjt['project_register_end']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Sale start:
                                </td>
                                <td class="editval">
                                    <input type="datetime-local" id="salestart" name="salestart" value="<?=$rprjt['project_sale_start']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Sale end:
                                </td>
                                <td class="editval">
                                    <input type="datetime-local" id="saleend" name="saleend" value="<?=$rprjt['project_sale_end']?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="editprop">
                                    Listing:
                                </td>
                                <td class="editval">
                                    <input type="datetime-local" id="listing" name="listing" value="<?=$rprjt['project_listing']?>">
                                </td>
                            </tr>
                        <tr>
                            <td class="editprop">
                                Distribution:
                            </td>
                            <td class="editval">
                                <input name="distribution" type="text" value="">
                            </td>
                        </tr>
                        <tr>
                            <td class="editprop">
                                Vesting:
                            </td>
                            <td class="editval">
                                <input name="vesting" type="text" value="">
                            </td>
                        </tr>
                    </table>
                    <input type="submit" name="save" value="Add" class="button">
                </form>
            </div>
        </div>
        <? include ADMIN_DIR.'footer.php';
    } else {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
?>