<?
    define('footballadm', true);
    include 'header.php';
    if (($user) AND ($user['access']==10)) { ?>
    <div class="menu">
        <?php
            include 'adminmenu.php';
        ?>
    </div>
    <div class="contentadm">
        <? if($_FILES) {
            foreach ($_FILES["uploads"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["uploads"]["tmp_name"][$key];
                    $name = $_FILES["uploads"]["name"][$key];
                    move_uploaded_file($tmp_name, UPLOAD_DIR."$name");
                }
            }
            $file = file(UPLOAD_DIR."$name", true);
            print_r($file);
            if ($_POST['select'] == "team") {
                foreach ($file as $team) {
                    $team = explode(";", $team);
                    $proverka = "SELECT * FROM `teams` WHERE name='$team[0]' AND league='$team[1]' AND country='$team[2]'";
                    $prov = mysqli_query($assaulter, $proverka);
                    $row_cnt = $prov->num_rows;
                    if ($row_cnt == 0) {
                        //mysqli_query($assaulter, "INSERT INTO `teams` (`name`, `league`, `country`, `logo`) VALUES ('Зенит', '1', '1', '')");
                    }
                    echo $proverka." - ".$row_cnt."<br>";
                }
                
            }
            if ($_POST['select'] == "league") {
                $proverka = "SELECT * FROM `leagues`";
                
            }
            if ($_POST['select'] == "country") {
                $proverka = "SELECT * FROM `countries`";
                
            }
        } ?>
        
        <h1>Добавить данные</h1>
        <form method="post" enctype="multipart/form-data">
            <select name="select">
                <option value="team">Команды</option>
                <option value="league">Лиги</option>
                <option value="country">Страны</option>
            </select><br /><br />
            <input type="file" name="uploads[]" /><br />
            <input type="submit" value="Загрузить" />
        </form>
    </div>
    <? include 'footer.php';
} else {
    header("Location: ".$_SERVER['HTTP_REFERER']);
} ?>