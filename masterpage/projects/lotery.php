<? define('artpadadm', true);
    include '../../config.php';
    include ADMIN_DIR.'header.php';
    
    $id = $_POST['nomer'];
    $requests = $artpad->query("SELECT * FROM `requests` WHERE `project`='$id' AND `active`='1'");
    $req_cnt = $requests->num_rows;
    $project = $artpad->query("SELECT * FROM `projects` WHERE `id`='$id'")->fetch_assoc();
    echo $project['project_initial_supply']."<br><br>";
    ?>
    
    <table style="color: gray">
        <tr><td>Логин</td><td>Уровень</td><td>Аллокация</td><td>Шанс</td></tr>
        <?
            $doli = 0;
            while ($ruser = $requests->fetch_assoc()) {
                $uuser = $artpad->query("SELECT * FROM `users` WHERE `id`='$ruser[user]'");
                $uuser = $uuser -> fetch_assoc();
                $lvl = $artpad->query("SELECT * FROM `levels` WHERE `lvl`='$uuser[lvl]'");
                $lvl = $lvl -> fetch_assoc();
                if ($ruser[user] == $user[id]) {
                    $user[allok] = $lvl['weight'];
                }
                $random = rand(1, 4);
                $flag = 0;
                if ($uuser[lvl] > 3) {
                    $doli += $lvl['weight'];
                } else {  
                    if ($uuser[lvl]==1) {
                        if ($random == 3) {
                            $flag = 1;
                            $doli += 1;
                        } else {
                            $artpad->query("UPDATE `requests` SET `lotery` = '1' WHERE `user` = '$user[id]' AND `project` = '$id'");
                        }
                    }
                    if ($uuser[lvl]==2) {
                        if (($random == 3) OR ($random == 2)) {
                            $flag = 1;
                            $doli += 1;
                        } else {
                            $artpad->query("UPDATE `requests` SET `lotery` = '1' WHERE `user` = '$user[id]' AND `project` = '$id'");
                        }
                    }
                    if ($uuser[lvl]==3) {
                        if (($random == 1) OR ($random == 2) OR ($random == 4)) {
                            $flag = 1;
                            $doli += 1;
                        } else {
                            $artpad->query("UPDATE `requests` SET `lotery` = '1' WHERE `user` = '$user[id]' AND `project` = '$id'");
                        }
                    }
                }
                if ($uuser[lvl] > 3) {
                    
                    echo "<tr><td>".$uuser['login']."</td><td>".$uuser['lvl']."</td><td>".$lvl['weight']."</td><td>1</td></tr>";
                } else {  
                    echo "<tr><td>".$uuser['login']."</td><td>".$uuser['lvl']."</td><td>".$lvl['weight']."</td><td>".$flag."</td></tr>";
                }
                
            }
            
            echo "<tr><td>Итого</td><td> </td><td>".$doli."</td><td> </td></tr>";
            $dolya = $project['project_initial_supply'] / $doli; ?>
            <br><br>
            <table style="color: gray">
                <tr><td>Логин</td><td>Уровень</td><td>Аллокация</td><td>Выигрыш</td></tr>
                    <? $winners = $artpad->query("SELECT * FROM `requests` WHERE `project`='$id' AND `active`='1' AND `lotery`='0'");
                    while ($winner = $winners->fetch_assoc()) {
                        $uuser = $artpad->query("SELECT * FROM `users` WHERE `id`='$winner[user]'");
                        $uuser = $uuser -> fetch_assoc();
                        $lvl = $artpad->query("SELECT * FROM `levels` WHERE `lvl`='$uuser[lvl]'");
                        $lvl = $lvl -> fetch_assoc();
                        if ($ruser[user] == $user[id]) {
                            $user[allok] = $lvl['weight'];
                        }
                        $vyigrysh = $dolya*$lvl['weight'];
                        echo "<tr><td>".$uuser['login']."</td><td>".$uuser['lvl']."</td><td>".$lvl['weight']."</td><td>".$vyigrysh."</td></tr>";
                        echo "UPDATE `requests` SET `lotery` = '1',`claim` = '$vyigrysh' WHERE `user` = '$uuser[id]' AND `project` = '$id' AND `active` = '1'";
                        $artpad->query("UPDATE `requests` SET `lotery` = '1',`claim` = '$vyigrysh' WHERE `user` = '$uuser[id]' AND `project` = '$id' AND `active` = '1'");
                    }
        ?>
    </table>
    <?
    $artpad -> query("UPDATE `projects` SET `project_lotery`='1' WHERE `id`=$id");  
    
    header('Location: /masterpage/projects/editproject.php?project='.$id.'&main=content&sub=projects');
?>